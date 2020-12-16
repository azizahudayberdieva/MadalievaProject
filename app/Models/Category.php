<?php

namespace App\Models;

use App\Scopes\LocaleScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public const RULES = [
        'name' => 'required|string',
        'order' => 'nullable|integer',
        'parent_id' => 'nullable|integer',
    ];

    protected $guarded = [];

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'id', 'parent_id')->orderBy('order');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('order');
    }

    protected static function booted()
    {
        static::addGlobalScope(new LocaleScope);
    }

    public function getCreatedAtAttribute($attribute): string
    {
        return Carbon::parse($attribute)->format('Y-m-d H:i');
    }
}
