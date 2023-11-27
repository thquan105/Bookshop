@extends('frontend.layout')

@section('title', 'Wishlist')

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                My Wishlist
            </span>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="container p-t-30">
            <div class="mb-0 alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert">
                <strong>{{ session()->get('message') }}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Wishlist -->
    <div class="container p-t-30">
        <div class="row">
            <div class="col-lg-10 col-xl-12 m-lr-auto m-b-50">
                <div class="m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <thead>
                                <tr class="table_head">
                                    <th class="column-1">Image</th>
                                    <th class="column-2">Name</th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4">Add to Cart</th>
                                    <th class="column-5">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wishlists as $wishlist)
                                    @php
                                        $product = $wishlist->product;
                                    @endphp
                                    <tr class="table_row">
                                        <td class="column-1">
                                            @if ($product->getMedia('gallery'))
                                                <img src="{{ $product->getMedia('gallery')->first()->getUrl() }}"
                                                    alt="{{ $product->name }}" style="width:100px">
                                            @else
                                                <span class="badge badge-danger">no image</span>
                                            @endif
                                        </td>
                                        <td class="column-2">{{ $product->name }}</td>
                                        <td class="column-3"><span class="amount">{{ $product->price }} vnđ</span>
                                        </td>
                                        <td class="column-4">
                                            <form id="addtocart" method="post" action="{{route('carts.store')}}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1" id="quantityInput">
                                                <input type="hidden" name="id" value="{{$product->id}}">
                                                <a href="javascript:void(0)" id="cartEffect" class="btn" 
                                                onclick="event.preventDefault();document.getElementById('addtocart').submit();">                                        
                                                    <button>Add to Cart</button>
                                                </a>
                                            </form>
                                        </td>
                                        <td class="column-5">
                                            <div class="remove">
                                                <form action="{{ route('wishlists.destroy', $wishlist->id) }}"
                                                    method="post" class="delete d-inline-block">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-t-30 p-b-30">You have no wishlist product
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
