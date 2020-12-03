<?php

namespace App\Http\Controllers;

class LocalesController extends Controller
{
    public function index()
    {
        return response()->json([
            'locale' => app()->getLocale(),
            'languages' => config('app.supported_locales'),
        ]);
    }
}
