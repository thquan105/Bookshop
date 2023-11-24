<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    // public function index($slug = null)
    // {
        
    //     // Lấy tất cả các sản phẩm kèm theo danh mục
    //         $products = Product::with('category');
    //         // $products = Product::with('category')->get(['id','name', 'price','slug']);
    //         // dd($products);
    //         if (!is_null($slug)) {
    //             $category = Category::whereSlug($slug)->first();
    //             if (is_null($category->id)) {
    //                 $categoriesIds = Category::whereParent_id($category->id)->pluck('id')->toArray();
    //                 $categoriesIds[] = $category->id; 
    //                 $products =  product::whereHas('category', function($query) use ($categoriesIds) {
    //                     $query->whereIn('id', $categoriesIds); 
    //                 });
    //             } else {
    //                 $products =  product::whereHas('category', function ($query) use ($slug) {
    //                     $query->where('slug', $slug);
    //                 });

    //         }
            
    //     }
    //     // $products = $products->paginate(5);
    //     return view('frontend.products.index', compact('products'));
    // }
    
    public function index($slug  = "All product")
    {
        $products = Product::with('category');
        if (!is_null($slug)) {
            if ($slug === "All product") {
                // Nếu là "all product", lấy tất cả sản phẩm
                $products = Product::all();
                return view('frontend.products.index', compact('products'));
            } else {
                // Nếu không phải "all product", thực hiện lấy danh mục và sản phẩm thuộc danh mục
                if (Category::where('slug', $slug)->exists()) {
                    $category = Category::where('slug', $slug)->first();
                    $products = Product::where('category_id', $category->id)->get();
                    return view('frontend.products.index', compact('category', 'products'));
                } else {
                    return redirect('/')->with('status', "Slug does not exist");
                }
            }
        }
        
    }
}