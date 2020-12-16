<?php

namespace App\Http\Controllers;

use App\Forms\PostForm;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Queries\PostsQueryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request, PostsQueryInterface $postQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $posts = $postQuery->execute($request->per_page, $request->page);

        return PostResource::collection($posts);
    }

    public function create(PostForm $form): JsonResponse
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(PostRequest $request, Post $post)
    {
        $attributes = $request->except('attachment');

        $post->fill($attributes)->save();
        $post->refresh();

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
        $attributes = collect($request->validated());

        if ($file = $request->file('attachment')) {
            $post->media()->delete();
            $post->addMedia($file)->toMediaCollection('files');;
        }

        $post->update($attributes->except('attachment')->toArray());

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
