<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case Confirmed = 'confirmed';
    case Shipped = 'shipped';
    case Canceled = 'canceled';
}
