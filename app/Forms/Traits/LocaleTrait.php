<?php


namespace App\Forms\Traits;


trait LocaleTrait
{
    public function getAppLocales()
    {
        return collect(config('app.supported_locales'))
            ->map(function ($locale) {
                return [
                    'id' => $locale['short_code'],
                    'name' => $locale['title']
                ];
            })
            ->toArray();
    }
}
