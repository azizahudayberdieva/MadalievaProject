<?php


namespace App\Models\Traits;


use Carbon\Carbon;

trait TimeMutators
{
    public function getCreatedAtAttribute($attribute): string
    {
        return Carbon::parse($attribute)->setTimezone('Asia/Tashkent')->format('Y-m-d H:i');
    }

    public function getUpdatedAtAttribute($attribute): string
    {
        return Carbon::parse($attribute)->setTimezone('Asia/Tashkent')->format('Y-m-d H:i');
    }
}
