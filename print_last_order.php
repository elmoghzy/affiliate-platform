<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

try {
    require __DIR__ . '/vendor/autoload.php';

    $app = require_once __DIR__ . '/bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    // Use the Order model (fully-qualified)
    $order = \App\Models\Order::latest()->first();
    if ($order) {
        echo 'LAST_ORDER_ID:' . $order->id;
    } else {
        echo 'NO_ORDER';
    }
} catch (\Throwable $e) {
    echo 'ERROR: ' . $e->getMessage();
}
