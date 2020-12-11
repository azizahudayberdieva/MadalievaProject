<?php

namespace App\Http\Controllers;

use App\Forms\PostForm;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Queries\PostsQueryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request, PostsQueryInterface $postQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $posts = $postQuery->setCategoryId($request->category_id)
            ->setAttachmentMimeType($request->mime_type)
            ->setQuerySearch($request->search)
            ->setStatus($request->status)
            ->setOrderBy($request->orderBy)
            ->execute($request->per_page, $request->page);

        return PostResource::collection($posts);
    }

    public function create(PostForm $form): JsonResponse
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(PostRequest $request, Post $post): JsonResponse
    {
        $attributes = $request->except('attachment');

        $post = $post->fill($attributes)->save();

        if ($file = $request->file('attachment')) {
            $post->addMedia($file)->toMediaCollection('files');
        }

        return response()->json(['message' => trans('crud.post_created')], 201);
    }

    public function show($id): PostResource
    {
        $post = Post::findOrFail($id)->load(['user', 'category', 'media']);
        return new PostResource($post);
    }

    public function edit(Post $post, PostForm $form): JsonResponse
    {
        return response()->json(['form' => $form->fill($post)->get()]);
    }

    public function update(PostRequest $request, Post $post): JsonResponse
    {
        if ($request->hasFile('attachment')) {
            $post->updateMedia($request->file('attachment'), 'files');
        }

        $post->fill($request->except('attachment'))->save();

        return response()->json(['message' => trans('crud.post_updated')], 200);
    }

    public function destroy(Post $post): JsonResponse
    {
        $media = $post->media;

        $media->each(function ($attachment) use ($post) {
            $post->deleteMedia($attachment->id);
        });

        $post->delete();

        return response()->json(['message' => trans('crud.post_deleted')]);
    }
}
