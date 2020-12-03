<?php

namespace App\Forms;

use App\Models\Category;

class CategoryForm extends AbstractForm
{
    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', trans('admin_panel.categories.title'),
                [
                    'validationRule' => 'required',
                ]);

        $this->formBuilder->add('treeselect', 'parent_id', trans('admin_panel.categories.parent_cat'),
            [
                'options' => $this->getParentCategories()
            ]);

        $this->formBuilder->add('number', 'order', trans('admin_panel.order'));
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
