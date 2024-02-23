<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ShoppingCartRepositoryInterface;
use App\Models\BusinessAccount;
use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    private ShoppingCartRepositoryInterface $shoppingCart;

    public function __construct(ShoppingCartRepositoryInterface $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
    }
    public function index()
    {
        return $this->shoppingCart->getcart(request()->get('cart'));
    }


    public function addProduct(Request $request, Product $product)
    {
        return $this->shoppingCart->addProduct($request->cart, $product);
    }


    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        return $this->shoppingCart->updateProductQuantity($request->cart, $product, $request->quantity);
    }

    public function removeProduct(Request $request, Product $product)
    {
        return $this->shoppingCart->removeProduct($request->cart, $product);
    }
}
