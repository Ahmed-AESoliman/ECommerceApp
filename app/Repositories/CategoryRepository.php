<?php

namespace App\Repositories;

use App\Http\Requests\CategoryFilterRequest;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoriesResource;
use App\Http\Resources\SingelCategoryResource;
use App\Http\Responses\ApiResponse;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryRepository implements CategoryRepositoryInterface
{
    protected Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }
    public function index(Request|CategoryFilterRequest $request): CategoriesCollection
    {
        return new CategoriesCollection(
            $this->model->filter($request)
                ->paginate($request->input('page_size'))
        );
    }
    public function mainCategories(): JsonResponse
    {
        return ApiResponse::success($this->model->whereNull('parent_category')->select('id', 'category_name')->get());
    }
    public function subCategories($mainCategory): JsonResponse
    {
        return ApiResponse::success($this->model->whereNotNull('parent_category')->select('id', 'category_name')->get());
    }
    public function store(array $data): JsonResponse
    {
        try {
            $category = $this->model->create($data);
            foreach ($data['sub_category'] as $val) {
                $category->subCategory()->create(['category_name' => $val]);
            }
            return ApiResponse::success(null, 'success created', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function update(array $data, Model $model): JsonResponse
    {
        try {
            $model->update([
                'category_name' => $data['category_name']
            ]);
            foreach ($model->subCategory as $subCategory) {
                if (!in_array($subCategory->name, $data['sub_category'])) {
                    if (!$subCategory->productBysubCategory->count() > 0) {
                        $subCategory->forceDelete();
                    }
                }
            }
            foreach ($data['sub_category'] as $value) {
                $model->subCategory()->updateOrCreate(['category_name' => $value]);
            }
            return ApiResponse::success(null, 'success updated', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show(Model $model): JsonResponse
    {
        return ApiResponse::success(new SingelCategoryResource($model));
    }

    public function delete(Model $model): JsonResponse
    {
        $model->delete();
        return ApiResponse::success('success deleted');
    }

    public function restore(Model $model): bool
    {
        // TODO: Implement forceDelete() method.
        return false;
    }

    public function forceDelete(Model $model): bool
    {
        // TODO: Implement forceDelete() method.
        return false;
    }
}