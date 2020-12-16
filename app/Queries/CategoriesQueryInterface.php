<?php


namespace App\Queries;


use App\Queries\Eloquent\CategoriesQuery;

interface CategoriesQueryInterface
{
    public function execute(int $perPage, int $page): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function setWithChildren(bool $bool): CategoriesQuery;

    public function setQuerySearch($querySearch) : CategoriesQuery;

    public function setWithPosts(bool $withChildrenPosts) : CategoriesQuery;
}
