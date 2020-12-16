<?php

namespace App\Providers;

use App\Enums\AccessTypes;
use App\Models\Category;
use App\Models\Post;
use App\Observers\CategoryObserver;
use App\Observers\PostObserver;
use App\Queries\CategoriesQueryInterface;
use App\Queries\Eloquent\CategoriesQuery;
use App\Queries\Eloquent\PostsQuery;
use App\Queries\Eloquent\UsersQuery;
use App\Queries\PostsQueryInterface;
use App\Queries\UsersQueryInterface;
use Illuminate\Support\Facades\Auth;
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
        $this->app->bind(PostsQueryInterface::class, function () {

            $access_type = Auth::user()->accessLevel();

            return new PostsQuery(request()->get('category_id'),
                $access_type,
                request()->get('status'),
                request()->get('mime_type'),
                request()->get('search'),
                request()->get('orderBy', 'created_at'));
        });

        $this->app->bind(CategoriesQueryInterface::class, function() {
            return new CategoriesQuery(
                request()->get('search'),
                request()->get('with_children', false),
                request()->get('with_posts', false),
                request()->get('orderBy', 'created_at')
            );
        });

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
        Category::observe(CategoryObserver::class);
    }
}
