<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class LocalesController extends Controller
{
    public function index()
    {
        if ($locales = Cache::get('locales')) {
            return response()->json($locales);
        }

        $locales = [
            'locale' => app()->getLocale(),
            'languages' => config('app.supported_locales'),
        ];

        Cache::put('locales', $locales);

        return response()->json($locales);
    }
}
