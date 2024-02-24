<?php

namespace App\Repositories;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductListCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SingleProductResource;
use App\Http\Responses\ApiResponse;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductRepository implements ProductRepositoryInterface
{
    private Product $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index(Request|ProductFilterRequest $request): ProductCollection
    {
        return new ProductCollection(
            $this->model->with(['mainCategory', 'subCategory', 'attachments'])->filter($request)->paginate($request->input('page_size'))
        );
    }

    public function productList(ProductFilterRequest $request): ProductListCollection
    {
        return new ProductListCollection(
            $this->model->with(['mainCategory', 'subCategory', 'attachments'])->filter($request)->paginate($request->input('page_size'))
        );
    }

    public function productDetails(Product $product): JsonResponse
    {
        return ApiResponse::success(new ProductDetailsResource($product->with(['mainCategory', 'subCategory', 'attachments'])->first()));
    }
    public function store(array $data): JsonResponse
    {
        try {
            $data['available_colors'] = json_encode($data['available_colors']);
            $data['available_size'] = json_encode($data['available_size']);
            $product = $this->model->create($data);
            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $product->attachments()->create(['file_path' => $attachment]);
                }
            }
            return ApiResponse::success(null, 'success created', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function update(array $data, Model $model): JsonResponse
    {
        try {
            $data['available_colors'] = json_encode($data['available_colors']);
            $data['available_size'] = json_encode($data['available_size']);
            $model->update($data);

            if (isset($data['attachments'])) {
                foreach ($data['attachments'] as $attachment) {
                    $model->attachments()->create(['file_path' => $attachment]);
                }
            }
            return ApiResponse::success(null, 'success updated', 200);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
    public function show(Model $model): JsonResponse
    {
        return ApiResponse::success(new SingleProductResource($model->with(['mainCategory', 'subCategory', 'attachments'])->first()));
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

    public function uploadAttachments(Request $request): JsonResponse
    {
        $path = $request->file('image')->store('products', 'local');
        return ApiResponse::success($path, null, 201);
    }
}
