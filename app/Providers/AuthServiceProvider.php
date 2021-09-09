<?php

namespace App\Providers;

use App\Post;
use App\PostComment;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('change-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
        });

        Gate::define('change-comment', function (User $user, PostComment $comment) {
            return $user->id === $comment->user_id;
        });
    }
}
