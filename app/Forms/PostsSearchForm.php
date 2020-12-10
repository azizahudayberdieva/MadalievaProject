<?php

namespace App\Forms;

use App\Enums\FileMimeTypes;

class PostsSearchForm extends AbstractForm
{
    protected function buildForm()
    {
        $this->formBuilder->add('treeselect', 'category_id', trans('admin_panel.categories.single'), [
            'options' => $this->getCategoriesWithChildren(),
            'attributes' => [
                'cols' => 4,
                'outlined' => true,
                'placeholder' => trans('admin_panel.categories.single'),
                'no-options-text' => trans('admin_panel.no_options'),
                'no-results-text' => trans('admin_panel.no_results')
            ]
        ]);

        $this->formBuilder->add('select', 'mime_type', trans('admin_panel.attachments.file_extension'), [
            'options' => $this->getAvailableFileTypes(),
            'attributes' => [
                'cols' => 4,
                'outlined' => true,
            ]
        ]);

        $this->formBuilder->add('text', 'search', trans('admin_panel.search'), [
            'attributes' => [
                'cols' => 4,
                'outlined' => true,
                'append-icon' => 'mdi-magnify'
            ]
        ]);
    }

    protected function getAvailableFileTypes(): array
    {
        $labels = FileMimeTypes::getLabels();

        return collect($labels)
            ->map(function ($value, $key) {
                return [
                    'id' => $key,
                    'name' => $value
                ];
            })
            ->values()
            ->toArray();
    }
}
