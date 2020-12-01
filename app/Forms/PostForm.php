<?php

namespace App\Forms;

use App\Models\Post;

class PostForm extends AbstractForm
{
    protected $fieldsDefinitions = [];

    protected function buildForm()
    {
        $this->formBuilder
            ->add('text', 'name', 'Заголовок',
                [
                    'validationRule' => 'required',
                    'attributes' => [
                        'outlined' => true,
                        'cols' => 6,
                    ]
                ]);

        $this->formBuilder->add('treeselect', 'category_id', 'Категория',
            [
                'options' => $this->getParentCategories(),
                'attributes' => [
                    'outlined' => true,
                    'cols' => 6,
                ]
            ]);
        $this->formBuilder->add('textarea', 'excerpt', 'Краткое описание', [
            'attributes' => [
                'outlined' => true
            ]
        ]);

        $this->formBuilder->add('textarea', 'full_description', 'Полное описание', [
            'attributes' => [
                'outlined' => true
            ]
        ]);

        $this->formBuilder->add('file', 'attachment', 'Файлы', [
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
