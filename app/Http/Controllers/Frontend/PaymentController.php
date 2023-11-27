<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Order;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        if (isset($_GET['partnerCode'])) {
            //Thành Công
            if ($_GET['resultCode'] == 0) {
                $latestId = Order::max('id');
                $order = Order::find($latestId);
                $order->payment_status = Order::PAID;
                $order->save();
                Cart::destroy();
                return view('frontend.carts.thanks');
            } else {
                //Thất Bại
                $message = $_GET['message'];
                $items = Cart::instance('cart')->content();
                $provinces = $this->getProvinces();
                $cities = isset(auth()->user()->province_id) ? $this->getCities(auth()->user()->province_id) : [];
                return view('frontend.carts.checkout', compact('items', 'provinces', 'cities', 'message'));
            }
        }
    }
}
