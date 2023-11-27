<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

		return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('admin.orders.show', compact('order', 'orderItems'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {

        DB::transaction(
            function () use ($order) {
                OrderItem::where('order_id', $order->id)->delete();
                $order->forceDelete();

                return true;
            }
        );

        return redirect()->route('admin.orders.index')->with([
            'message' => 'Success deleted !',
            'alert-type' => 'danger'
        ]);    ;
    }
}
