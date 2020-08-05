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
        'name' => 'required|string',
        'user_id' => 'required|exists:App\Models\User,id',
        'category_id' => 'required|exists:App\Models\Category,id',
        'attachment' => 'required|mimes:pptx,doc,docx,mp4,flv,video/mp4,max:5120000',
        'description' => 'required|string|max:255'
    ];

    protected $dateFormat = 'Y-m-d h:m';
    /**
     * @var string[]
     */
    protected $guarded = [];

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

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}
