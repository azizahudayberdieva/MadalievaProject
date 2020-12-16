<?php

namespace App\Forms;

use App\Forms\Traits\LocaleTrait;
use App\Models\Category;

class CategoryForm extends AbstractForm
{
    use LocaleTrait;

    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.categories.name'),
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'outlined' => true,
                        'cols' => 12
                    ],
                ]);

        $this->formBuilder->add('select', 'parent_id', trans('admin_panel.categories.parent_cat'),
            [
                'options' => $this->getParentCategories(),
                'attributes' => [
                    'outlined' => true,
                    'cols' => 12
                ],
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
