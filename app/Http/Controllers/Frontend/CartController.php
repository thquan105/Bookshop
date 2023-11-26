<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;

class CartController extends Controller
{
    public function index()
    {
		// Cart::destroy();
		$items = Cart::instance('cart')->content();

		return view('frontend.carts.index', ['items'=>$items]);
    }

	public function addToCart(Request $request)
	{
		$product = Product::find($request->id);
		
		Cart::instance('cart')->add($product->id, $product->name, $request->quantity,$product->price)->associate('App\Models\Product');
		return redirect()->back()->with([
			'message' => 'Đã thêm sản phẩm thành công !',
			'alert-type' => 'success'
		]);
	}

	public function update(Request $request)
	{
		// Cart::instance('cart')->update($request->rowId,$request->quantity);
		// $params = $request->except('_token');
		
		// Cart::instance('cart')->update($request->productId, $request->qty);

		$itemId = $request->input('itemId');
        $newQuantity = $request->input('newQuantity');

        // Your logic to update the cart in the database based on $itemId and $newQuantity		
		Cart::instance('cart')->update($itemId, $newQuantity);

        // Return a response (you can customize this based on your needs)
        // return response()->json(['message' => 'Cart updated successfully']);
		return redirect()->route('carts.index');
	}
	
	public function destroy($id)
	{
		Cart::instance('cart')->remove($id);

		return redirect()->back()->with([
			'message' => 'Sản phẩm đã được xóa thành công !',
			'alert-type' => 'danger'
		]);
	}
}
