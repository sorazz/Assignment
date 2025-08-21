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
        $filters = $request->only('keyword');
        $categories = $this->categoryRepo->all($filters, 10);

        return response()->json($categories, 200);
    }

    public function show($id)
    {
        $category = $this->categoryRepo->find($id, true);
        return response()->json($category, 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryRepo->create($request->all());
        return response()->json($category, 201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryRepo->update($id, $request->all());
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $this->categoryRepo->delete($id);
        return response()->json(null, 204);
    }
}
