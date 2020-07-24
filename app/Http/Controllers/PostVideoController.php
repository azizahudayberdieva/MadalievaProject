<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostVideoRequest;
use App\Models\Post;
use Carbon\Carbon;

class PostVideoController extends Controller
{
    public function store(PostVideoRequest $request)
    {
        $video = Post::create($request->except('file'));

        $ext = $request->file('file')->getClientOriginalExtension();
        $fileName = $request->name = Carbon::now()->timestamp . '.' . $ext;

        $request->file('file')->storeAs('public/uploads', $fileName);

        $video->files()->create([
            'extension' => $ext,
            'size' => $request->file('file')->getSize() / 1024,
            'source' => '/uploads/' . $fileName
        ]);

        return response()->json(['status' => 'completed'], 200);
    }
}
