<?php

namespace App\Http\Controllers;

class TranslationsController extends Controller
{
    public function index()
    {
        return response()->json([
            'admin_panel' => trans('admin_panel'),
            'auth' => trans('auth'),
            'pagination' => trans('pagination'),
            'passwords' => trans('passwords'),
            'validation' => trans('validation'),
        ]);
    }
}
