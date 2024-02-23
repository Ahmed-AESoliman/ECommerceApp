<?php

namespace App\Repositories;

use App\Http\Responses\ApiResponse;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Nette\Schema\ValidationException;

class OrderRepository extends ShoppingCartRepository implements OrderRepositoryInterface
{
    public function createOrder(array $data): JsonResponse
    {
        $items = $this->checkoutCart($data['cart']);
        $amount = $this->getTotal($data['cart']);
        if (count($items)) {
            DB::beginTransaction();
            try {
                $data['amount'] = $amount;
                $order = Order::create($data);
                foreach ($items as $item) {
                    $product = Product::where('id', $item->id)->where('unit_in_stock', '>=', $item->quantity)->first();
                    if (!empty($product)) {
                        $order->orederItems()->create([
                            'product_id' => $item->id,
                            'quantity' => $item->quantity,
                            'price' => $item->price - $item->discount,
                        ]);
                        $product->update([
                            'unit_in_stock' => $product->unit_in_stock - $item->quantity,
                            'unit_on_order' => $product->unit_on_order + $item->quantity,
                        ]);
                    } else {
                        throw new ValidationException("The required quantity of {$item->product_name} is not available");
                    }
                }
                DB::commit();
                return ApiResponse::success(null, 'order created');
            } catch (\Exception $exception) {
                DB::rollBack();
                return ApiResponse::error($exception->getMessage());
            }
        }
        return ApiResponse::error(__('shopping cart is empty'));
    }
}
