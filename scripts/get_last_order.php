<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $order = \App\Models\Order::with('product')->latest()->first();
    $out = [];
    if ($order) {
        $out = [
            'id' => $order->id,
            'product' => $order->product?->name,
            'customer_name' => $order->customer_name,
            'phone' => $order->phone,
            'status' => $order->status,
            'created_at' => $order->created_at?->toDateTimeString(),
            'utm_source' => $order->utm_source,
            'utm_campaign' => $order->utm_campaign,
            'utm_adset' => $order->utm_adset,
            'utm_ad' => $order->utm_ad,
        ];
    }
    $path = __DIR__ . '/../storage/tmp_last_order.json';
    file_put_contents($path, json_encode($out, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "WROTE:" . $path;
} catch (\Throwable $e) {
    echo 'ERROR: ' . $e->getMessage();
}
