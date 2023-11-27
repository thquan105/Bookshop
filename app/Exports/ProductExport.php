<?php

namespace App\Exports;

use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orderItems = OrderItem::all();

        // Thêm tên cột trực tiếp vào mảng dữ liệu
        $data[] = ['Tên','Giá','Số lượng','Ngày bán','Tổng tiền'];

        foreach ($orderItems as $orderItem) {
            $data[] = [
                'Tên'=> $orderItem->name ,
                'Giá'=> $orderItem->base_price ,
                'Số lượng'=> $orderItem->qty ,
                'Ngày bán'=> $orderItem->created_at ,
                'Tổng tiền'=> $orderItem->base_price*$orderItem->qty ,
            ];
        }

        return collect($data);
    }
    
}
