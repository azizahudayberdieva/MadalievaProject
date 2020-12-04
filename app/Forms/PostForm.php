<?php

namespace App\Forms;

use App\Models\Category;
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
                'options' => $this->getCategoriesWithChildren(),
                'attributes' => [
                    'placeholder' => trans('admin_panel.categories.single'),
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

    private function getCategoriesWithChildren()
    {
        return Category::with('children')->where('parent_id', '=', null)->get()
            ->map(function ($cat) {
                $data = [
                    'id' => $cat->id,
                    'name' => $cat->name
                ];

                if ($cat->children->isNotEmpty()) {
                    $data['children'] = $cat->children->map(function ($childCat) {
                        return [
                            'id' => $childCat->id,
                            'name' => $childCat->name
                        ];
                    });
                }

                return $data;
            })
            ->toArray();
    }

    public function fill(Post $post)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $field->setValue($post->{$field->getName()});
        }

        return $this;
    }
}
