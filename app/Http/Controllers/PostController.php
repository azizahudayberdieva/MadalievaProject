<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
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
                'swtatus' => 'completed',
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

        return response()->json(['status' => 'completed', 'message' => 'Post Updated'], 200);
    }

    /**
     * Deletes the given resource
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $post = Post::findOrFail($id);

        $post->attachments->each(function ($attachment) {
            $attachment->delete();
        });

        $post->delete();

        return response()->json(['status' => 'completed', 'message' => 'Post Deleted'], 200);
    }
}
