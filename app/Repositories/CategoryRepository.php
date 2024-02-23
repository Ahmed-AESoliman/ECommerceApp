<?php

namespace App\Repositories;

use App\Http\Requests\CategoryFilterRequest;
use App\Http\Resources\CategoriesCollection;
use App\Http\Resources\CategoriesResource;
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
            $this->model->filter($request)->paginate($request->input('page_size'))
        );
    }

    public function store(array $data): JsonResponse
    {
        try {
            $this->model->create($data);
            return ApiResponse::success(null, 'success created', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function update(array $data, Model $model): JsonResponse
    {
        try {
            $model->update($data);
            return ApiResponse::success(null, 'success updated', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function show(Model $model): JsonResponse
    {
        return ApiResponse::success(new CategoriesResource($model));
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
