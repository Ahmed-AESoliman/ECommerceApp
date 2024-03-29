<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFilterRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of Sub Categories.
     */
    public function index(CategoryFilterRequest $request)
    {
        return $this->categoryRepository->index($request);
    }

    /**
     * Display a listing of Categories.
     */
    public function mainCategories()
    {
        return $this->categoryRepository->mainCategories();
    }
    /**
     * Display a listing of sub Categories.
     */
    public function subCategories(Request $request)
    {
        $request->validate([
            'main_category' => 'required|exists:categories,id'
        ]);
        return $this->categoryRepository->subCategories($request->main_category);
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        return $this->categoryRepository->store($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->categoryRepository->update($validatedData, $category);
    }

    public function show(Category $category)
    {
        return $this->categoryRepository->show($category);
    }
}