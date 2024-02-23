<?php

namespace App\Interfaces;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface OrderRepositoryInterface
{
    public function createOrder(array $data): JsonResponse;
}
