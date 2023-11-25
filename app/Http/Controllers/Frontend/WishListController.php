<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlists = WishList::where('user_id', auth()->id())
			->orderBy('created_at', 'desc')->get();
        //dd($wishlists);
		return view('frontend.wishlists.index', compact('wishlists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!auth()->check()){
            return response()->json([
                'status' => 401
            ]);
        }
        $request->validate(
			[
				'product_slug' => 'required',
			]
		);

		$product = Product::where('slug', $request->get('product_slug'))->firstOrFail();
		
		$wishlists = WishList::where('user_id', auth()->id())
			->where('product_id', $product->id)
            ->first();
            
		if ($wishlists) {
			return response('The product already exists !', 422);
		}

		WishList::create(
			[
				'user_id' => auth()->id(),
				'product_id' => $product->id,
			]
		);

		return response($product->name);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WishList $wishlist)
    {
        $wishlist->delete();
        
		return redirect('wishlists')->with([
            'message' => 'Successfully deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
