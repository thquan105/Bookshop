@extends('frontend.layout')

@section('title', 'Cart')

@section('content')

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Shoping Cart
            </span>
        </div>
    </div>

    <!-- ?num-product1=1&num-product2=1&coupon=&time=USA&state=VN&postcode=123 -->
    <!-- Shoping Cart -->
    <form action="{{ route('carts.checkout') }}" method="" class="bg0 p-t-75 p-b-85">
        <div class="container">
            @if($items->count()>0)
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Product</th>
                                    <th class="column-2">Name</th>
                                    <th class="column-3">Price</th>
                                    <th class="column-4" style="text-align: center;">Quantity</th>
                                    <th class="column-5">Total</th>
                                    <th class="column-6">Remove</th>
                                </tr>
                                @foreach ($items as $item)
                                    <tr class="table_row">
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="images/item-cart-04.jpg" alt="IMG">
                                            </div>
                                        </td>                                        
                                        <td class="column-2">{{$item->model->name}}</td>
                                        <td class="column-3">${{$item->price}}</td>
                                        <td class="column-4">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                onclick="updateQuantity('change', {{$item->id}})">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                onchange="updateQuantity('change', {{$item->id}})"
                                                    name="num-product1" value="{{$item->qty}}" data-productId="{{$item->rowId}}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                onclick="updateQuantity('change', {{$item->id}})">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-5">{{$item->subtotal()}}</td>
                                        <td class="product-remove">
                                        <div class="remove">
                                            <a href="{{ url('carts/remove/'. $item->rowId)}}" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Remove
                                            </a>
                                        </div>												
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w flex-m m-r-20 m-tb-5">
                                <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                    name="coupon" placeholder="Coupon Code">

                                <div
                                    class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                    Apply coupon
                                </div>
                            </div>

                            <div
                                class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Update Cart
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Cart Totals
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
                                <span class="stext-110 cl2">
                                    Subtotal:
                                </span>
                            </div>

                            <div class="size-209">
                                <span class="mtext-110 cl2">
                                    ${{Cart::instance('cart')->subtotal()}}
                                </span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
                                <span class="stext-110 cl2">
                                    Shipping:
                                </span>
                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2">
                                    There are no shipping methods available. Please double check your address, or contact us
                                    if you need any help.
                                </p>

                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
                                        Calculate Shipping
                                    </span>

                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="time">
                                            <option>Select a country...</option>
                                            <option>USA</option>
                                            <option>UK</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>

                                    <div class="bor8 bg0 m-b-12">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="state"
                                            placeholder="State /  country">
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode"
                                            placeholder="Postcode / Zip">
                                    </div>

                                    <div class="flex-w">
                                        <div
                                            class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                            Update Totals
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    ${{Cart::instance('cart')->total()}}
                                </span>
                            </div>
                        </div>

                        <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
                        </button>
                    </div>
                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Giỏ hàng trống!</h2>
                </div>
            </div>
            @endif
        </div>
    </form>
    <form id="updateCartQty" action="{{route('carts.update')}}" method="POST">
        @csrf
        @method('put')
        <input type="hidden" id="rowId" name="rowId">
        <input type="hidden" id="quantity" name="quantity">
    </form>
@endsection
@push('script-alt')
<script>	
    // function updateQuantity(qty)
    // {
    //     $('#rowId').val($(qty).data('rowid'));
    //     $('#quantity').val($(qty).val());
    //     $('#updateCartQty').submit();
    // }

    function updateQuantity(action, itemId) {
        var inputElement = document.getElementById('quantity_' + itemId);
        var currentValue = parseInt(inputElement.value);

        // if (action === 'increase') {
        //     inputElement.value = currentValue + 1;
        // } else if (action === 'decrease') {
        //     if (currentValue > 1) {
        //         inputElement.value = currentValue - 1;
        //     }
        // }

        // Call a function to update the cart on the server (you need to implement this in your Laravel application)
        updateCartOnServer(itemId, inputElement.value);
    }

    function updateCartOnServer(itemId, newQuantity) {
        // Use AJAX or other methods to send the updated quantity to the server
        // For example, you can use Axios or jQuery.ajax to send a request to your Laravel route/controller

        // Example using Axios
        axios.post('/carts/update', {
            itemId: itemId,
            newQuantity: newQuantity
        })
        .then(function (response) {
            // Handle success, e.g., display a success message
            console.log(response.data);
        })
        .catch(function (error) {
            // Handle error, e.g., display an error message
            console.error(error);
        });
    }
</script>
@endpush