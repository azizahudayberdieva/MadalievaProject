<?php

namespace App\Http\Controllers;

use App\Forms\CategoryForm;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Queries\CategoriesQueryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, CategoriesQueryInterface $categoriesQuery)
    {
        $categories = $categoriesQuery
            ->setWithChildren(boolval($request->with_children))
            ->setWithPosts(boolval($request->with_posts))
            ->setQuerySearch($request->query_search)
            ->execute($request->per_page, $request->page);

        return CategoryResource::collection($categories);
    }

    public function create(CategoryForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return response()->json(['message' => trans('crud.category_created')], 200);
    }

    public function show(Category $category)
    {
        $category->load('posts');
        return new CategoryResource($category);
    }

    public function edit(Category $category, CategoryForm $form)
    {
        return response()->json(['form' => $form->fill($category)->get()]);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->validated())->save();

        return response()->json([
            'message' => trans('crud.category_updated')
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => trans('crud.category_deleted')
        ]);
    }
}
