<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Enums\OrderStatus;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request)
    {
        $data = $request->validated();
        $data['status'] = OrderStatus::New->value;
        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        // UTM fields are already nullable and will be included if present

    $order = Order::create($data);

    // Notify via Telegram
    app(\App\Services\Notifications\TelegramNotifier::class)->orderCreated($order);

    return redirect()->route('thanks')->with('o', true);
    }
}
