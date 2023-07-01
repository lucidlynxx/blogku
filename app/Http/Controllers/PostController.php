<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function home(): View
    {
        //* Latest post
        $latestPost = Post::with(['categories', 'user'])
            ->where('status', '=', 'published')
            ->whereDate('updated_at', '<=', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->first();

        //* Show the most popular 3 posts based on upvotes
        $popularPost = Post::with(['categories', 'user'])
            ->leftJoin('upvote_downvotes', 'posts.id', '=', 'upvote_downvotes.post_id')
            ->select('posts.*', DB::raw('COUNT(upvote_downvotes.id) as upvote_count'))
            ->where(function ($query) {
                $query->whereNull('upvote_downvotes.is_upvote')
                    ->orWhere('upvote_downvotes.is_upvote', '=', 1);
            })
            ->where('status', '=', 'published')
            ->whereDate('posts.updated_at', '<=', Carbon::now())
            ->orderByDesc('upvote_count')
            ->groupBy([
                'posts.id',
                'posts.title',
                'posts.slug',
                'posts.image',
                'posts.content',
                'posts.status',
                'posts.user_id',
                'posts.created_at',
                'posts.updated_at',
                'posts.meta_title',
                'posts.meta_description',
            ])
            ->limit(3)
            ->get();

        //* If authorized - Show recommended posts based on user upvotes
        $user = auth()->user();

        if ($user) {
            $leftJoin = "(SELECT cp.category_id, cp.post_id FROM upvote_downvotes 
            JOIN category_post cp ON upvote_downvotes.post_id = cp.post_id 
            WHERE upvote_downvotes.is_upvote = 1 and upvote_downvotes.user_id = ?) as t";

            $recommendedPosts = Post::with(['categories', 'user'])
                ->leftJoin('category_post as cp', 'posts.id', '=', 'cp.post_id')
                ->leftJoin(DB::raw($leftJoin), function ($join) {
                    $join->on('t.category_id', '=', 'cp.category_id')
                        ->on('t.post_id', '<>', 'cp.post_id');
                })
                ->select('posts.*')
                ->where('posts.id', '<>', DB::raw('t.post_id'))
                ->setBindings([$user->id])
                ->limit(3)
                ->get();
        } else {
            //* Not auhtorized - Popular posts based on views
            $recommendedPosts = Post::with(['categories', 'user'])
                ->leftJoin('post_views', 'posts.id', '=', 'post_views.post_id')
                ->select('posts.*', DB::raw('COUNT(post_views.id) as view_count'))
                ->where('status', '=', 'published')
                ->whereDate('posts.updated_at', '<=', Carbon::now())
                ->orderByDesc('view_count')
                ->groupBy([
                    'posts.id',
                    'posts.title',
                    'posts.slug',
                    'posts.image',
                    'posts.content',
                    'posts.status',
                    'posts.user_id',
                    'posts.created_at',
                    'posts.updated_at',
                    'posts.meta_title',
                    'posts.meta_description',
                ])
                ->limit(3)
                ->get();
        }

        //* Show recent categories with their latest posts
        $categories = Category::query()
            ->whereHas('posts', function ($query) {
                $query
                    ->where('status', '=', 'published')
                    ->whereDate('posts.updated_at', '<=', Carbon::now());
            })
            ->select('categories.*')
            ->selectRaw('MAX(posts.updated_at) as max_date')
            ->leftJoin('category_post', 'categories.id', '=', 'category_post.category_id')
            ->leftJoin('posts', 'posts.id', '=', 'category_post.post_id')
            ->orderByDesc('max_date')
            ->groupBy([
                'categories.id',
                'categories.name',
                'categories.slug',
                'categories.created_at',
                'categories.updated_at',
            ])
            ->limit(5)
            ->get();

        return view('home', compact(
            'latestPost',
            'popularPost',
            'recommendedPosts',
            'categories'
        ));
    }

    public function show(Post $post, Request $request)
    {
        if ($post->status !== 'published' || $post->updated_at > Carbon::now()) {
            throw new NotFoundHttpException();
        }

        $next = Post::with(['categories', 'user'])
            ->where('status', '=', 'published')
            ->whereDate('updated_at', '<=', Carbon::now())
            ->whereDate('updated_at', '<', $post->updated_at)
            ->orderBy('updated_at', 'desc')
            ->limit(1)
            ->first();

        $prev = Post::with(['categories', 'user'])
            ->where('status', '=', 'published')
            ->whereDate('updated_at', '<=', Carbon::now())
            ->whereDate('updated_at', '>', $post->updated_at)
            ->orderBy('updated_at', 'asc')
            ->limit(1)
            ->first();

        $user = $request->user();

        PostView::create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'post_id' => $post->id,
            'user_id' => $user?->id
        ]);

        return view('post.view', compact('post', 'next', 'prev'));
    }

    public function byCategory(Category $category)
    {
        $posts = Post::with(['categories', 'user'])
            ->join('category_post', 'posts.id', '=', 'category_post.post_id')
            ->select('posts.*')
            ->where('category_post.category_id', '=', $category->id)
            ->where('status', '=', 'published')
            ->whereDate('posts.updated_at', '<=', Carbon::now())
            ->orderBy('posts.updated_at', 'desc')
            ->paginate(10);

        return view('post.index', compact('posts', 'category'));
    }

    public function search(Request $request)
    {
        $q = $request->get('q');

        $posts = Post::query()
            ->where('status', '=', 'published')
            ->whereDate('posts.updated_at', '<=', Carbon::now())
            ->orderBy('posts.updated_at', 'desc')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%$q%")
                    ->orWhere('content', 'like', "%$q%");
            })
            ->paginate(10);

        return view('post.search', compact('posts'));
    }
}
