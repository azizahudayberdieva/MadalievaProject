<?php

namespace App\Forms;

use App\Models\Post;

class PostForm extends AbstractForm
{
    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.posts.name'),
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'outlined' => true,
                        'cols' => 6,
                    ]
                ]);

        $this->formBuilder->add('treeselect', 'category_id', trans('admin_panel.categories.single'),
            [
                'validationRule' => 'required',
                'options' => $this->getParentCategories(),
                'attributes' => [
                    'placeholder' => '',
                    'outlined' => true,
                    'cols' => 6,
                ]
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
            'validationRule' => 'required',
            'attributes' => [
                'cols' => 6
            ]
        ]);
    }

    private function getParentCategories()
    {
        // Todo implement getParentCategories method
        return [];
    }

    public function fill(Post $post)
    {
        // Todo implement fill method
        return $this;
    }
}
