<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use Cart;

class OnlineCheckoutController extends Controller
{
    public function index()
    {
		// Cart::destroy();
		$items = Cart::instance('cart')->content();

		return view('frontend.carts.checkout', ['items'=>$items]);
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

    public function online_checkout(Request $request)
    {
        $Bill = new Bill();
        $Bill->FirstName = $request->input('FirstName');
        $Bill->LastName = $request->input('LastName');
        $Bill->Email = $request->input('Email');
        $Bill->MobileNo = $request->input('MobileNo');
        $Bill->Address1 = $request->input('Address1');
        $Bill->Address2 = $request->input('Address2');
        $selectedCountry = $request->input('country');
        $Bill->country = $selectedCountry;
        $Bill->City = $request->input('City');
        $Bill->State = $request->input('State');
        $Bill->ZipCode = $request->input('ZipCode');
        $Bill->total_amount = Cart::instance('cart')->subtotal() + 10000;
        $Bill->save();


        if($request->has('payLater')){
            echo 'Thanh toán khi nhận hàng';
        }elseif($request->has('payUrl')){

            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = 'MOMOBKUN20180529';
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

            $orderInfo = "Thanh toán qua MoMo";
            $amount = Cart::instance('cart')->subtotal() * 10000;
            $orderId = time() ."";
            $redirectUrl = env('APP_URL');
            $ipnUrl =  env('APP_URL');
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

            Cart::detroy();

            //Just a example, please check more in there
            return redirect()->away($jsonResult['payUrl']);


            // Test MOMO:
            // NGUYEN VAN A
            // 9704 0000 0000 0018
            // 03/07
            // OTP
        }
    }
}
