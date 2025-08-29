<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class OrdersExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected Builder $query)
    {
    }

    public function query(): Builder
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Product',
            'Customer Name',
            'Phone',
            'Address',
            'Status',
            'Date',
            'UTM Source',
            'UTM Campaign',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->product?->name,
            $order->customer_name,
            $order->phone,
            $order->address,
            $order->status->value,
            $order->created_at->toDateTimeString(),
            $order->utm_source,
            $order->utm_campaign,
        ];
    }
}
