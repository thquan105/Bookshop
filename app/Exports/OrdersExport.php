<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orders = Order::select('customer_first_name', 'customer_last_name', 'order_date', 'payment_status', 'grand_total')->get();

        // Thêm tên cột trực tiếp vào mảng dữ liệu
        $data[] = ['Họ','Tên','Ngày đặt hàng','Tình trạng thanh toán','Tổng tiền'];

        foreach ($orders as $order) {
            $data[] = [
                'Họ'=> $order->customer_first_name ,
                'Tên'=> $order->customer_last_name ,
                'Ngày đặt hàng'=> $order->order_date ,
                'Tình trạng thanh toán'=> $order->payment_status ,
                'Tổng tiền'=> $order->grand_total ,
            ];
        }

        return collect($data);
    }
}
