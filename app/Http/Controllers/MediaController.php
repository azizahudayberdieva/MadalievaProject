<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class MediaController extends Controller
{
    public function download(Request $request)
    {
        $media = Media::findOrFail($request->id);

        return \Response::download($media->getPath());
    }
}
