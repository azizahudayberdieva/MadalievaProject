<?php


namespace App\Enums;


class AccessTypes
{
    const ALL = 'all';
    const OFFICE = 'office';
    const PRODUCTION = 'production';

    public static function getTypes(): array
    {
        return [
            self::ALL,
            self::OFFICE,
            self::PRODUCTION,
        ];
    }
}
