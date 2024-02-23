<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function uploadAttachments(Request $request): JsonResponse;
}
