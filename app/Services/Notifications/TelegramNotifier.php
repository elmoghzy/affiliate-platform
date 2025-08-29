<?php

namespace App\Services\Notifications;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Throwable;

class TelegramNotifier
{
    public function orderCreated(Order $order): void
    {
        $token = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (! $token || ! $chatId) {
            return;
        }

        $productName = $order->product?->getTranslation('name', 'ar');
        $statusValue = $order->status->value;

        $text = <<<TEXT
        **طلب جديد!** 🚀
        ------------------------
        **رقم الطلب:** {$order->id}
        **المنتج:** {$productName}
        **العميل:** {$order->customer_name}
        **الهاتف:** {$order->phone}
        **الحالة:** {$statusValue}
        **الوقت:** {$order->created_at->toDateTimeString()}
        ------------------------
        TEXT;

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'Markdown',
            ]);
        } catch (Throwable $e) {
            // Log the error but don't block the user flow
            report($e);
        }
    }
}
