<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['categories', 'user'])
            ->where('status', '=', 'published')
            ->whereDate('updated_at', '<=', Carbon::now())
            ->orderBy('updated_at', 'desc')
            ->paginate(5);

        return view('home', compact('posts'));
    }

    public function show(Post $post)
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
}
