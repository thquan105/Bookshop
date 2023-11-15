<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function cities(Request $request)
	{
		$cities = $this->getCities($request->province_id);
		// dd($cities);
		return response()->json(['cities' => $cities]);
	}
}
