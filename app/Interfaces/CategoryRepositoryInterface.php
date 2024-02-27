<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function mainCategories(): JsonResponse;
    public function subCategories($mainCategory): JsonResponse;
}