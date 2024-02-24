<?php

namespace App\Interfaces;

use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductListCollection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function uploadAttachments(Request $request): JsonResponse;
    public function productList(ProductFilterRequest $request): ProductListCollection;
    public function productDetails(Product $product): JsonResponse;
}
