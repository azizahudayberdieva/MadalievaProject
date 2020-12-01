<?php

namespace App\Http\Controllers;

use App\Forms\PostForm;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['category', 'media']);

        if ($request->category_id) {
            $posts->whereHas('category', function ($q) use ($request){
               $q->where('id', $request->category_id);
               $q->orWhere('parent_id', $request->category_id);;
            });
        }

        if ($request->mime_type) {
            $posts->whereHas('media', function ($q) use ($request) {
                $q->whereIn('mime_type', $request->mime_type);
            });
        }

        $posts = $posts->get();

        return PostResource::collection($posts);
    }

    public function create(PostForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

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

    public function show($id): PostResource
    {
        $post = Post::findOrFail($id)->load(['user', 'category', 'media']);
        return new PostResource($post);
    }

    public function edit(Post $post,PostForm $form)
    {
        return response()->json(['form' => $form->fill($post)->get()]);
    }

    public function update(PostRequest $request, Post $post)
    {
        $post->fill($request->except('attachment'))->save();

        if ($request->hasFile('attachment')) {
            $post->updateMedia($request->file('attachment'), 'files');
        }

        return response()->json(['message' => 'Запись Обновлена'], 200);
    }

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
