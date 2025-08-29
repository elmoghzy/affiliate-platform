<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'customer_name',
        'phone',
        'address',
        'email',
        'notes',
        'status',
        'utm_source',
        'utm_campaign',
        'utm_adset',
        'utm_ad',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
