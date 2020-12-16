<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function saved(Category $category)
    {
        $category->locale = app()->getLocale();
        $category->saveQuietly();
    }
}
