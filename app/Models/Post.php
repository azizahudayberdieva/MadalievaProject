<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    /**
     * Rules for validation Video model
     *
     * @const RULES
     */
    public const RULES = [
        'name' => 'nullable|string',
        'user_id' => 'required|exists:App\Models\User,id',
        'category_id' => 'required|exists:App\Models\Category,id',
        'file' => 'required|mimes:docx,pdf|max:15000',
        'description' => 'nullable|string|max:255'
    ];

    /**
     * @var string[]
     */
    protected $fillable = ['*'];

    /**
     * @return BelongsTo
     */
    public function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
