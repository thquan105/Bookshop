<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ImageUploadingTrait;
use App\Models\Category;
use App\Http\Requests\Admin\ProductRequest;
class ProductController extends Controller
{
    use ImageUploadingTrait;
    /**
     * Display a listing of the resource. 
     */
    public function index()
    {
        $products = Product::all();

        return view ('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.products.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
      

        foreach ($request->input('gallery', []) as $file) {
            $product->addMedia(storage_path('tmp/uploads/'. $file))->toMediaCollection('gallery');
        }

        return redirect()->route('admin.products.index')->with([
            'message' => 'Success Created !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.products.edit', compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request,Product $product)
    {
        $product->update($request->validated());
        

        if (count($product->gallery) > 0) {
            foreach ($product->gallery as $media) {
                if (!in_array($media->file_name, $request->input('gallery', []))) {
                    $media->delete();
                }
            }
        }

        $media = $product->gallery->pluck('file_name')->toArray();
        
        foreach ($request->input('gallery', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $product->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('gallery');
            }
        }

        return redirect()->route('admin.products.index')->with([
            'message' => 'Success Updated !',
            'alert-type' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->back()->with([
            'message' => 'Success Deleted !',
            'alert-type' => 'danger'
        ]);
    }
}
