<?php


namespace App\Queries;


use App\Queries\Eloquent\PostsQuery;

interface PostsQueryInterface
{
    public function execute(): \Illuminate\Contracts\Pagination\LengthAwarePaginator;

    public function setOrderBy(string $orderBy): PostsQuery;

    public function setAttachmentMimeType(string $attachmentMimeType): PostsQuery;

    public function setQuerySearch(string $qs): PostsQuery;

    public function setCategoryId(int $categoryId): PostsQuery;
}
