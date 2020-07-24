<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

//    protected const RULES = [
//        'name' => 'nullable|string',
//        'file' => 'require|max:15000',
//    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    public function attachable()
    {
        return $this->morphTo();
    }

}
