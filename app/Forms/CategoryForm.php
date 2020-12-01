<?php

namespace App\Forms;

use App\Models\Category;

class CategoryForm extends AbstractForm
{
    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', 'Имя',
                [
                    'validationRule' => 'required',
                ]);

        $this->formBuilder->add('treeselect', 'parent_id', 'Родительская категория',
            [
                'options' => $this->getParentCategories()
            ]);

        $this->formBuilder->add('number', 'order', 'Порядок');
    }

    private function getParentCategories()
    {
        // Todo implement getParentCategories method
        return [];
    }

    public function fill(Category $category)
    {
        // Todo implement fill method
        return $this;
    }
}
