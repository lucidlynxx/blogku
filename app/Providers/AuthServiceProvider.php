<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Comment;
use App\Models\Permission;
use App\Models\Post;
use App\Models\Role;
use App\Models\TextWidget;
use App\Models\User;
use App\Policies\CommentPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\PostPolicy;
use App\Policies\RolePolicy;
use App\Policies\TextWidgetPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
        User::class => UserPolicy::class,
        TextWidget::class => TextWidgetPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        Gate::define('admin', function (User $user) {
            return $user->hasRole('admin');
        });
    }
}
