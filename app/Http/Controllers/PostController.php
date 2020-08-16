<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Get a list of resources
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return PostResource::collection(Post::with('media')->get());
    }
    /**
     * Store a new resource
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request): JsonResponse
    {
        $post = Post::create($request->except('attachment'));

        $post->addMedia($request->file('attachment'))->toMediaCollection('files');

        return response()->json(
            [
                'message' => 'Запись добавлена',
                'post' => new PostResource($post->load(['user', 'category', 'media']))
            ], 200);
    }

    /**
     * @param $id
     * @return PostResource
     */
    public function show($id): PostResource
    {
        $post = Post::findOrFail($id)->load(['user', 'category', 'media']);
        return new PostResource($post);
    }

    /**
     * Updates the given resource
     *
     * @param PostRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->fill($request->except('attachment'))->save();

        if ($request->hasFile('attachment')) {
            $post->updateMedia($request->file('attachment'), 'files');
        }

        return response()->json(['message' => 'Запись Обновлена'], 200);
    }

    /**
     * Deletes the given resource
     *
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $media = $post->media;

        $media->each(function ($attachment) use ($post) {
            $post->deleteMedia($attachment->id);
        });

        $post->delete();

        return response()->json(['message' => 'Запись удаленна'], 200);
    }
}
