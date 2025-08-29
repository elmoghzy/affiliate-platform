<?php

namespace App\Services\Notifications;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class TelegramNotifier
{
    public function orderCreated(Order $order): void
    {
        $token = config('services.telegram.bot_token') ?: env('TELEGRAM_BOT_TOKEN');
        $chatId = config('services.telegram.chat_id') ?: env('TELEGRAM_CHAT_ID');

        if (empty($token) || empty($chatId)) {
            // not configured — don't break the flow
            return;
        }

        $text = sprintf(
            "طلب جديد\nID: %s\nمنتج: %s\nالعميل: %s\nهاتف: %s\nالحالة: %s\nوقت: %s",
            $order->id,
            $order->product?->name ?? 'N/A',
            $order->customer_name,
            $order->phone,
            is_object($order->status) ? ($order->status->value ?? (string)$order->status) : (string)$order->status,
            $order->created_at?->toDateTimeString() ?? now()->toDateTimeString()
        );

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
            ]);
        } catch (\Throwable $e) {
            // swallow errors — notifier must not block user flow
        }
    }
}
