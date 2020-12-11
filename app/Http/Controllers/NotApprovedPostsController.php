<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Queries\PostsQueryInterface;
use Illuminate\Http\Request;

class NotApprovedPostsController extends PostController
{
    public function index(Request $request, PostsQueryInterface $postQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $posts = $postQuery->setCategoryId($request->category_id)
            ->setAttachmentMimeType($request->mime_type)
            ->setQuerySearch($request->search)
            ->setOrderBy($request->orderBy)
            ->execute($request->per_page, $request->page);

        return PostResource::collection($posts);
    }
}
