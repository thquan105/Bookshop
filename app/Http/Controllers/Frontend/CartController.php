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
		$items = Cart::instance('cart')->content();

		if ($items->isNotEmpty()) {
			$firstItem = $items->first();

			if ($firstItem->model && $firstItem->model->name) {
				return view('frontend.carts.index', ['items' => $items]);
			} else {
				$items->each(function ($item, $rowId) {
					Cart::instance('cart')->remove($rowId);
				});
				return view('frontend.carts.index', ['items' => $items]);
			}
		} else {
			$items->each(function ($item, $rowId) {
				Cart::instance('cart')->remove($rowId);
			});
			return view('frontend.carts.index', ['items' => $items]);
		}
	}

	
	public function addToCart(Request $request)
	{
		$product = Product::find($request->id);
		
		Cart::instance('cart')->add($product->id, $product->name, $request->quantity,$product->price)->associate('App\Models\Product');
		return redirect()->back()->with([
            'message' => 'Thêm thành công !',
            'alert-type' => 'success'
        ]);
	}

	public function update(Request $request)
	{
		Cart::instance('cart')->update($request->rowId,$request->quantity);
		
		return redirect()->route('carts.index');
	}
	
	public function destroy($id)
	{
		Cart::instance('cart')->remove($id);

		return redirect()->route('carts.index')->with([
			'message' => 'Sản phẩm đã được xóa thành công !',
			'alert-type' => 'danger'
		]);
	}
}
