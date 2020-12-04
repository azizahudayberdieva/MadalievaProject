<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class TranslationsController extends Controller
{
    public function index()
    {
        if ($translations = Cache::get('translations')) {
            return response()->json($translations);
        }

        $translations = [
            'admin_panel' => trans('admin_panel'),
            'auth' => trans('auth'),
            'pagination' => trans('pagination'),
            'passwords' => trans('passwords'),
            'validation' => trans('validation'),
        ];

        Cache::put('translations', $translations);

        return response()->json($translations);
    }
}
