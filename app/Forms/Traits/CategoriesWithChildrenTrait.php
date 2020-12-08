<?php


namespace App\Forms\Traits;


use App\Models\Category;

trait CategoriesWithChildrenTrait
{
    public function getCategoriesWithChildren()
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
}
