<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'ship_date',
        'shipper_name',
        'is_paid',
        'status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
        'customer_city',
        'customer_country',
    ];

    public function orederItems()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }
}
