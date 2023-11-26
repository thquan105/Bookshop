<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slide;


class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::active()->orderBy('position', 'ASC')->get();
        $products = Product::with('category')->get(['id','name', 'price','slug']);
        $category = Category::all();
        return view('frontend.home', compact('products', 'category','slides'));
    }

    public function showProduct($slug  = "All product")
    {
        $products = Product::with('category');
        if (!is_null($slug)) {
            if ($slug === "All product") {
                // Nếu là "all product", lấy tất cả sản phẩm
                $products = Product::all();
                return view('frontend.home', compact('products'));
            } else {
                // Nếu không phải "all product", thực hiện lấy danh mục và sản phẩm thuộc danh mục
                if (Category::where('slug', $slug)->exists()) {
                    $category = Category::where('slug', $slug)->first();
                    $products = Product::where('category_id', $category->id)->get();
                    return view('frontend.home', compact('category', 'products'));
                } else {
                    return redirect('/')->with('status', "Slug does not exist");
                }
            }
        }
    }

}
