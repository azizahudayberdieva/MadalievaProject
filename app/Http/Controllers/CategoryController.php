<?php

namespace App\Http\Controllers;

use App\Forms\CategoryForm;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        //Todo implement pagination
        if (request()->with_children) {
            $category = Category::with(['posts', 'children'])
                ->where('parent_id', '=', NULL)
                ->get();
        }else {
            $category = Category::with(['posts'])->get();
        }

        return CategoryResource::collection($category);
    }

    public function create(CategoryForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return response()->json(['message' => 'Катеория добавлена'], 200);
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

        $category->load('posts');

        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category Deleted'
        ]);
    }
}
