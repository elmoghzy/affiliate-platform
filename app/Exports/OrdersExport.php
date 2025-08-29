<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected $query)
    {
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return ['id','product','customer_name','phone','status','created_at','utm_source','utm_campaign','utm_adset','utm_ad'];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->product?->name,
            $order->customer_name,
            $order->phone,
            $order->status,
            $order->created_at?->toDateTimeString(),
            $order->utm_source,
            $order->utm_campaign,
            $order->utm_adset,
            $order->utm_ad,
        ];
    }
}
