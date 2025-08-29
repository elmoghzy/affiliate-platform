<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Services\Notifications\TelegramNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(OrderStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['status'] = OrderStatus::New->value;
        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        $order = Order::create($data);

        app(TelegramNotifier::class)->orderCreated($order);

        return redirect()->route('thanks');
    }
}
