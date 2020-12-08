<?php

namespace App\Forms;

use App\Enums\FileMimeTypes;
use App\Forms\Traits\CategoriesWithChildrenTrait;
use Saodat\FormBase\Contracts\FormBuilderInterface;

class PostsSearchForm extends AbstractForm
{
    use CategoriesWithChildrenTrait;

    public function __construct(FormBuilderInterface $formBuilder)
    {
        parent::__construct($formBuilder);
    }

    protected function buildForm()
    {
        $this->formBuilder->add('treeselect', 'category_id', trans('admin_panel.categories.single'), [
            'options' => $this->getCategoriesWithChildren(),
            'attributes' => [
                'cols' => 4,
                'outlined' => true,
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

    protected function getAvailableFileTypes()
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
