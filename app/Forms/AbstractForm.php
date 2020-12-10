<?php


namespace App\Forms;


use App\Queries\CategoriesQueryInterface;
use Saodat\FormBase\Contracts\FormBuilderInterface;

abstract class AbstractForm
{
    /**
     * @var FormBuilderInterface
     */
    protected $formBuilder;
    /**
     * @var FormBuilderInterface
     */
    protected $form;
    /**
     * @var CategoriesQueryInterface
     */
    private $categoriesQuery;


    public function __construct(FormBuilderInterface $formBuilder, CategoriesQueryInterface $categoriesQuery)
    {
        $this->categoriesQuery = $categoriesQuery;
        $this->formBuilder = $formBuilder;
        $this->buildForm();
    }

    abstract protected function buildForm();

    public function get()
    {
        return $this->formBuilder->getSchema();
    }

    protected function getCategoriesWithChildren() : array
    {
        return $this->categoriesQuery->setWithChildren(true)->execute(100000)
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
}
