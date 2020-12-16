<?php


namespace App\Enums;


class AccessTypes
{
    const OFFICE = 'office';
    const PRODUCTION = 'production';

    public static function getTypes(): array
    {
        return [
            self::OFFICE,
            self::PRODUCTION,
        ];
    }
}
