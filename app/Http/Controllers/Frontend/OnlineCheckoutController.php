<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Session;

class OnlineCheckoutController extends Controller
{
    public function index()
    {
		// Cart::destroy();
		$items = Cart::instance('cart')->content();
        $provinces = $this->getProvinces();
		//dd($provinces);
		$cities = isset(auth()->user()->province_id) ? $this->getCities(auth()->user()->province_id) : [];

		return view('frontend.carts.checkout', ['items'=>$items, 'provinces'=>$provinces, 'cities'=>$cities]);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }

    public function online_checkout(CheckoutRequest $request)
    {
        $params = $request->except('_token');

        $baseTotalPrice = Cart::instance('cart')->subtotal(0, '', '');
        $shippingCost = 10000;
        $grandTotal = $baseTotalPrice + $shippingCost;

        $orderDate = date('Y-m-d H:i:s');
        $paymentDue = (new \DateTime($orderDate))->modify('+7 day')->format('Y-m-d H:i:s');

        $user_profile = [
            'first_name' => $params['first_name'],
            'last_name' => $params['last_name'],
            'address1' => $params['address1'],
            'address2' => $params['address2'],
            'province_id' => $params['province_id'],
            'city_id' => $params['city_id'],
            'postcode' => $params['postcode'],
            'phone' => $params['phone'],
            'email' => $params['email'],
        ];

        auth()->user()->update($user_profile);

        $orderParams = [
            'user_id' => auth()->id(),
            'status' => 'CREATED',
            'order_date' => $orderDate,
            'payment_due' => $paymentDue,
            'payment_status' => Order::UNPAID,
            'base_total_price' => $baseTotalPrice,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
            'customer_first_name' => $params['first_name'],
            'customer_last_name' => $params['last_name'],
            'customer_address1' => $params['address1'],
            'customer_address2' => $params['address2'],
            'customer_phone' => $params['phone'],
            'customer_email' => $params['email'],
            'customer_city_id' => $params['city_id'],
            'customer_province_id' => $params['province_id'],
            'customer_postcode' => $params['postcode'],
        ];

        $order = Order::create($orderParams);

        $cartItems = Cart::instance('cart')->content();

        if ($order && $cartItems) {
            foreach ($cartItems as $item) {
                $itemSubTotal = $item->quantity * $item->price;

                $product = $item->model;

                $orderItemParams = [
                    'order_id' => $order->id,
                    'product_id' => $item->model->id,
                    'qty' => $item->qty,
                    'base_price' => $item->price,
                    'sub_total' => $itemSubTotal,
                    'name' => $item->name,
                ];

                $orderItem = OrderItem::create($orderItemParams);
                
                if ($orderItem) {
                    $product = Product::findOrFail($product->id);
                    $product->quantity -= $item->quantity;
                    $product->save();
                }
            }
        }
        if (!isset($order)) {
			return redirect()->back()->with([
				'message' => 'Something went wrong !',
				'alert-type' => 'danger'
			]);
		}


        if($request->has('payLater')){
            Session::forget('cart');
            return view('frontend.carts.thanks');
        }elseif($request->has('payUrl')){
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán qua MoMo";
            $amount = $grandTotal;
            $orderId = time() ."";
            $redirectUrl = env('APP_URL')."/result";
            $ipnUrl =  env('APP_URL')."/result";
            // $ipnUrl = "http://127.0.0.1:8000";
            $extraData = "";

            $partnerCode = $partnerCode;
            $accessKey = $accessKey;
            $serectkey = $secretKey;
            $orderId = $orderId; // Mã đơn hàng
            $orderInfo = $orderInfo;
            $amount = $amount;
            $ipnUrl = $ipnUrl;
            $redirectUrl = $redirectUrl;
            $extraData = $extraData;

            $requestId = time() . "";
            $requestType = "payWithATM";
            // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
            //before sign HMAC SHA256 signature
            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
            $signature = hash_hmac("sha256", $rawHash, $serectkey);
            $data = array('partnerCode' => $partnerCode,
                'partnerName' => "Test",
                "storeId" => "MomoTestStore",
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);  // decode json

            //Just a example, please check more in there
            return redirect()->away($jsonResult['payUrl']);


            // Test MOMO:
            // 9704 0000 0000 0018
            // NGUYEN VAN A
            // 03/07
            // OTP
        }

        
    }
}
