<?php

namespace App\Providers;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Queries\CategoriesQueryInterface;
use App\Queries\Eloquent\CategoriesQuery;
use App\Queries\Eloquent\PostsQuery;
use App\Queries\Eloquent\UsersQuery;
use App\Queries\PostsQueryInterface;
use App\Queries\UsersQueryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostsQueryInterface::class, PostsQuery::class);
        $this->app->bind(CategoriesQueryInterface::class, CategoriesQuery::class);
        $this->app->bind(UsersQueryInterface::class, UsersQuery::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
    }
}
