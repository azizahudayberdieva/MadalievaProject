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
        return PostResource::collection(Post::with('attachments')->get());
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

        $attachment = $request->file('attachment');

        $post->attachments()->saveMany(
            (new AttachmentController($attachment))->store()
        );

        return response()->json(
            [
                'message' => 'Запись добавлена',
                'post' => new PostResource($post->load(['user', 'category', 'attachments']))
            ], 200);
    }

    /**
     * @param $id
     * @return PostResource
     */
    public function show($id): PostResource
    {
        $post = Post::findOrFail($id)->load(['user', 'category', 'attachments']);
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

        //Todo allow to remove attachment
        if ($request->hasFile('attachment')) {

            $attachment = $request->file('attachment');

            $post->attachments()->saveMany(
                (new AttachmentController($attachment))->store()
            );
        }

        return response()->json(['message' => 'Запись Обновлена'], 200);
    }

    /**
     * Deletes the given resource
     *
     * @param Post $post
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Post $post): JsonResponse
    {
        $post->attachments->each(function ($attachment) {
            $attachment->delete();
        });

        $post->delete();

        return response()->json(['status' => 'completed', 'message' => 'Post Deleted'], 200);
    }
}
