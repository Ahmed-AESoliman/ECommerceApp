<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductListCollection;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of Products.
     */
    public function index(ProductFilterRequest $request)
    {
        return $this->productRepository->index($request);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAttachments(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg'
        ]);
        return $this->productRepository->uploadAttachments($request);
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function store(StoreProductRequest $request): JsonResponse
    {
        return $this->productRepository->store($request->validated());
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        return $this->productRepository->update($request->validated(), $product);
    }
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return $this->productRepository->show($product);
    }
    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function delete(Product $product): JsonResponse
    {
        return $this->productRepository->delete($product);
    }

    /**
     * @param ProductFilterRequest $prorequestduct
     * @return ProductListCollection
     */
    public function productList(ProductFilterRequest $request): ProductListCollection
    {
        return $this->productRepository->productList($request);
    }

    public function singleProduct(Product $product): JsonResponse
    {
        return $this->productRepository->productDetails($product);
    }
}
