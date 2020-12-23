<?php

namespace App\Forms;

use App\Enums\AccessTypes;
use App\Forms\Traits\LocaleTrait;
use App\Models\Post;

class PostForm extends AbstractForm
{
    use LocaleTrait;

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.posts.name'),
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'outlined' => true,
                    ]
                ]);

        $this->formBuilder->add('treeselect', 'category_id', trans('admin_panel.categories.single'),
            [
                'validationRule' => 'required',
                'options' => $this->getCategoriesWithChildren(),
                'attributes' => [
                    'placeholder' => trans('admin_panel.categories.single'),
                    'outlined' => true,
                    'cols' => 6,
                    'no-options-text' => trans('admin_panel.no_options'),
                    'no-results-text' => trans('admin_panel.no_results')
                ]
            ]);

        $this->formBuilder->add('select', 'access_type', trans('admin_panel.access_type.label'),
            [
                'validationRule' => 'required',
                'options' => collect(AccessTypes::getTypes())->map(function($value) {
                    return [
                        'id' => $value,
                        'name' => trans("admin_panel.access_type.$value")
                    ];
                }),
                'attributes' => [
                    'outlined' => true,
                    'cols' => 6
                ],
                'value' => AccessTypes::ALL
            ]);

        $this->formBuilder->add('textarea', 'excerpt', trans('admin_panel.posts.short_description'), [
            'validationRule' => 'required',
            'attributes' => [
                'outlined' => true
            ]
        ]);

        $this->formBuilder->add('textarea', 'full_description', trans('admin_panel.posts.full_description'), [
            'validationRule' => 'required',
            'attributes' => [
                'outlined' => true
            ]
        ]);

        $this->formBuilder->add('file', 'attachment', trans('admin_panel.posts.file'), [
            //'validationRule' => 'required',
            'attributes' => [
                'cols' => 12,
                'helpText' => trans('admin_panel.attachments.drag_files_here'),
            ]
        ]);
    }

    public function fill(Post $post)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $field->setValue($post->{$field->getName()});
        }

        return $this;
    }
}
