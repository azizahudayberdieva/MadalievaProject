<?php

namespace App\Http\Controllers;

use App\Enums\PostStatuses;
use App\Models\Post;
use Illuminate\Http\Request;

class ApprovePostController extends Controller
{
    public function update(Request $request, int $id)
    {
        $post = Post::findOrFail($id);
        $post->status = PostStatuses::PUBLISHED;
        $post->saveQuietly();

        return response()->json(['message' => trans('crud.post_updated')]);
    }
}
