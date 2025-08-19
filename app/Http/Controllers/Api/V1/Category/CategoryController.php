<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Category\StoreCategoryRequest;
use App\Http\Requests\Api\V1\Category\UpdateCategoryRequest;
use App\Http\Resources\Api\V1\Category\CategoryResource;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $this->authorize('viewAny', Category::class);

            $categories = auth()->user()->categories()->with('tasks')->get();

            return CategoryResource::collection($categories)->additional([
                'message' => 'Categories Retrieved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to retrieve categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        try {
            $this->authorize('create', Category::class);

            $category = Category::create([
                'name' => $request->validated()['name'],
                // 'name' => $request->name,
                'user_id' => auth()->id(),
            ]);

            return (new CategoryResource($category))->additional([
                'message' => 'category created successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to create categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        try {
            $this->authorize('view', $category);

            return (new CategoryResource($category))->additional([
                'message' => 'category retrieved successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to retrieve category',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        try {
            $this->authorize('update', $category);

            $category->update($request->validated());

            return (new CategoryResource($category))->additional([
                'message' => 'category updated successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'failed to update categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        try {
            $this->authorize('delete', $category);

            $category->delete();

            return response()->json([
                'message' => 'category deleted successfully'
            ]);
        } catch (Exception $e) {

            return response()->json([
                'message' => 'failed to delete categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
