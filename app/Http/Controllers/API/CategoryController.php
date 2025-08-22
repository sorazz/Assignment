<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Repositories\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function index(Request $request)
    {
        try {
            $filters = $request->only('keyword');
            $categories = $this->categoryRepo->all($filters, 10);

            return response()->json($categories, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function show($id)
    {
        try {
            $category = $this->categoryRepo->find($id, true);
            return response()->json($category, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = $this->categoryRepo->create($request->all());
            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Category created successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $category = $this->categoryRepo->update($id, $request->all());
            return response()->json([
                'success' => true,
                'data' => $category,
                'message' => 'Category updated successfully.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    public function destroy($id)
    {
        try {
            $this->categoryRepo->delete($id);
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
