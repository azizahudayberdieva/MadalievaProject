<?php

namespace App\Models;

use App\Scopes\LocaleScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;

    /**
     * Rules for validation Video model
     *
     * @const RULES
     */
    public const RULES = [
        'name' => 'required|string',
        'user_id' => 'required|exists:App\Models\User,id',
        'category_id' => 'required|exists:App\Models\Category,id',
        'attachment' => 'required|mimes:pptx,doc,docx,mp4,flv,xlsx,max:5120000',
        'excerpt' => 'required|string|max:255',
        //'full_description' => 'required|string|max:5000'
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

    protected static function booted()
    {
        static::addGlobalScope(new LocaleScope);
    }
}
