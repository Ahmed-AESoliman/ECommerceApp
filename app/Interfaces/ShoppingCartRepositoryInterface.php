<?php

namespace App\Interfaces;

use App\Models\Product;

interface ShoppingCartRepositoryInterface
{
    public function addProduct($oldCart, Product $product);
    public function removeProduct($oldCart, Product $product);
    public function updateProductQuantity($oldCart, Product $product, $quantity);
    public function getCart($cart);
    public function checkoutCart($currentCart);
}
