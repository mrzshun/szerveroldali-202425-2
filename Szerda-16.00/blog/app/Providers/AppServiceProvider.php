<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->id === $post->user_id;
    
        });
        Paginator::useBootstrapFive();    
        //
    }
}
