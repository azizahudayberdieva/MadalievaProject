<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        if (request()->with_children) {
            $category = Category::with(['posts', 'children'])
                ->where('parent_id', '=', NULL)
                ->get();
        }else {
            $category = Category::with(['posts'])->get();
        }

        return CategoryResource::collection($category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CategoryRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoryRequest $request)
    {
        Category::create($request->validated());

        return response()->json(['message' => 'Катеория добавлена'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
        $category->load('posts');
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryRequest $request
     * @param Category $category
     * @return Category
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->validated())->save();

        $category->load('posts');

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category Deleted'
        ]);
    }
}
