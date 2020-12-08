<?php


namespace App\Enums;


class FileMimeTypes
{
    const WORD = 1;
    const EXCEL = 2;
    const PDF = 3;
    const MP4 = 4;

    public static function getValues() : array
    {
        return [
            self::WORD => ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
            self::EXCEL => ['application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
            self::PDF => ['application/pdf'],
            self::MP4 => ['video/mp4']
        ];
    }

    public static function  getLabels() : array
    {
        return [
            self::WORD => 'Microsoft Word',
            self::EXCEL => 'Microsoft Power Point',
            self::PDF =>  'PDF',
            self::MP4 => 'MP4 Video',
        ];
    }
}
