<?php

namespace App\Forms;

use App\Models\Category;

class CategoryForm extends AbstractForm
{
    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.categories.name'),
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'outlined' => true,
                        'cols' => 6
                    ],
                ]);

        $this->formBuilder->add('treeselect', 'parent_id', trans('admin_panel.categories.parent_cat'),
            [
                'options' => $this->getParentCategories(),
                'attributes' => [
                    'outlined' => true,
                    'cols' => 6
                ],
            ]);

        $this->formBuilder->add('number', 'order', trans('admin_panel.order'), [
            'attributes' => [
                'outlined' => true,
            ]
        ]);
    }

    private function getParentCategories()
    {
        return Category::with('parent')->get()
            ->map(function ($cat) {
                return [
                  'id' => $cat->id,
                  'name' => $cat->name
                ];
            });
    }

    public function fill(Category $category)
    {
        foreach ($this->formBuilder->getFields() as $field) {
            $field->setValue($category->{$field->getName()});
        }

        return $this;
    }
}
