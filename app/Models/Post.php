<?php

namespace App\Models;

use App\Models\Traits\TimeMutators;
use App\Scopes\LocaleScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Post extends Model implements HasMedia
{
    use HasMediaTrait;
    use TimeMutators;
    /**
     * Rules for validation Video model
     *
     * @const RULES
     */
    public const RULES = [
        'name' => 'required|string',
        'category_id' => 'required|exists:App\Models\Category,id',
        'attachment' => 'required|mimes:pptx,doc,docx,mp4,flv,xlsx,pdf|max:5120000',
        'excerpt' => 'required|string|max:255',
        'full_description' => 'required|string|max:5000'
    ];

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

    public function attachments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    protected static function booted() : void
    {
        static::addGlobalScope(new LocaleScope);
    }


}
