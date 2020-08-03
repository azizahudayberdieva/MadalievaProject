<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    public const UPLOAD_PATH = 'public/uploads';

    /**
     * @var array
     */
    protected $guarded = [];

    protected $dateFormat = 'Y-m-d h:m';
    /**
     * @return MorphTo
     */
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}
