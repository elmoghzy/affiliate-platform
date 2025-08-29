<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$rules = (new \App\Http\Requests\OrderStoreRequest())->rules();
$data = ['phone' => '+201001234567'];
$validator = \Illuminate\Support\Facades\Validator::make($data, ['phone' => $rules['phone']]);
if ($validator->fails()) {
    echo "FAILED\n" . json_encode($validator->errors()->all());
} else {
    echo "PASSED\n";
}
