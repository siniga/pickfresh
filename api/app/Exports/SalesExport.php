<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order;

class SalesExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Order::with('products')->get();
    }

    public function map($order): array
    {
        return [
            $order->order_id,
            $order->device_time,
            $order->location,
            $order->products["name"]
       
        ];
    }

    public function headings(): array
    {
        return ['Order ID', 'Time of purchase', 'Location'];
    }
}

