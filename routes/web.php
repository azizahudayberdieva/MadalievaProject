<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/download', function () {
    if (!request()->filename) {
        abort(404);
    }
    $file = storage_path('/app/') . request()->filename;

    if (file_exists($file)) {
        return Response::download($file);
    } else {
        abort(404);
    }
});
//->where('filename', '[A-Za-z0-9\-\_\.]+');
