<?php

namespace App\Repositories;

use App\Http\Responses\ApiResponse;
use App\Interfaces\ShoppingCartRepositoryInterface;
use App\Models\Product;


class ShoppingCartRepository implements ShoppingCartRepositoryInterface
{

    public function addProduct($oldCart, Product $product)
    {
        $cart = $oldCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        if (!empty($product)) {
            if ($product->unit_in_stock < 1) {
                return ApiResponse::error('quantity you need not found', 400);
            }
            if ($cart->has($product->id)) {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'discount' => $product->unit_discount,
                    'quantity' =>  $cart[$product->id]->quantity += 1,
                    'total' => ($product->unit_price - $product->unit_discount) * $cart[$product->id]->quantity,
                    'attachment' => $product->attachments->first()->file_path ?? null
                ];
            } else {
                $item = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'discount' => $product->unit_discount,
                    'quantity' => 1,
                    'total' => ($product->unit_price - $product->unit_discount),
                    'attachment' => $product->attachments->first()->file_path ?? null
                ];
                $cart->put($product->id, $item);
            }
            return ApiResponse::success(json_encode($cart), 'product add to cart');
        }
        return ApiResponse::error('not found', 404);
    }
    public function removeProduct($oldCart, Product $product)
    {
        $cart = $oldCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        if (!empty($product->id)) {
            if ($cart->has($product->id)) {
                $cart->forget($product->id);
            }
            return ApiResponse::success(json_encode($cart), 'product removed from cart');
        }
        return ApiResponse::error('not found', 404);
    }
    public function updateProductQuantity($oldCart, Product $product, $quantity)
    {
        $cart = $oldCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        if (!empty($product)) {
            if ($product->unit_in_stock < $quantity) {
                return ApiResponse::error('The quantity you need is not available', 400);
            }
            if ($cart->has($product->id)) {
                $cart[$product->id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'discount' => $product->unit_discount,
                    'quantity' => $quantity,
                    'total' => ($product->unit_price - $product->unit_discount) * $quantity,
                    'attachment' => $product->attachments->first()->file_path ?? null
                ];
            } else {
                $item = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->unit_price,
                    'discount' => $product->unit_discount,
                    'quantity' => $quantity,
                    'total' => ($product->unit_price - $product->unit_discount) * $quantity,
                    'attachment' => $product->attachments->first()->file_path ?? null
                ];
                $cart->put($product->id, $item);
            }
            return ApiResponse::success(json_encode($cart), 'product quantity updeted');
        }
        return ApiResponse::error('not found', 404);
    }
    public function getCart($oldCart)
    {
        $cart = $oldCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        return ApiResponse::success([
            'cart' => $cart->values(),
            'total' => $this->getTotal($cart)
        ]);
    }
    public function getTotal($currentCart)
    {
        $cart = $currentCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        $total = 0;
        foreach ($cart as $product) {
            if (Product::where('id', $product->id)->exists()) {
                $total += $product->total;
            }
        }
        return $total;
    }
    public function checkoutCart($currentCart)
    {
        $cart = $currentCart ?? collect();
        if (gettype($cart) == 'string') {
            $cart = json_decode($cart);
            $cart = collect($cart);
        }
        return $cart;
    }
}
