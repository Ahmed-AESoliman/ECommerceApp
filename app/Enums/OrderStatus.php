<?php

namespace App\Enums;

enum OrderStatus: int
{
    case Processing = 0;
    case Rejected = 1;
    case Shipping = 2;
    case Shipped = 4;
}
