<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;
use App\Enums\OrderStatus;

class TestOrderSeeder extends Seeder
{
    public function run(): void
    {
        $p = Product::first();
        if (!$p) return;

        Order::create([
            'product_id' => $p->id,
            'customer_name' => 'اختبار',
            'phone' => '+201001234567',
            'address' => 'عنوان تجريبي 123',
            'email' => null,
            'notes' => 'test',
            'status' => OrderStatus::New->value,
            'utm_source' => null,
            'utm_campaign' => null,
            'utm_adset' => null,
            'utm_ad' => null,
            'ip' => '127.0.0.1',
            'user_agent' => 'test-agent',
        ]);
    }
}
