<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const RULES = [
        'name' => 'required|string',
        'slug' => 'nullable|string',
        'order' => 'nullable|integer',
    ];

    protected $dateFormat = 'Y-m-d H:m';

    protected $guarded = [];
    /**
     * @return HasMany
     */
    public function posts() : HasMany
    {
        return $this->hasMany(Post::class);
    }
}
