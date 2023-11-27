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
    <form action="{{ route('carts.checkout') }}" method="GET" class="bg0 p-t-75 p-b-85">
        <div class="container">
            @if ($items->count() > 0)
                <div class="row">
                    <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                        <div class="m-l-25 m-r--38 m-lr-0-xl">
                            <div class="wrap-table-shopping-cart">
                                <table class="table-shopping-cart">
                                    <tr class="table_head">
                                        <th class="column-1">Product</th>
                                        <th class="column-2" style="text-align: center;">Name</th>
                                        <th class="column-3">Price</th>
                                        <th class="column-4" style="text-align: center;">Quantity</th>
                                        <th class="column-5">Total</th>
                                        <th class="column-3">Remove</th>
                                    </tr>
                                    @foreach ($items as $item)
                                        <tr class="table_row">
                                            <td class="column-1">
                                                @if ($item->model->getMedia('gallery'))
                                                    <img src="{{ $item->model->getMedia('gallery')->first()->getUrl() }}"
                                                        alt="{{ $item->model->name }}" style="width:100px">
                                                @else
                                                    <span class="badge badge-danger">no image</span>
                                                @endif
                                            </td>
                                            <td class="column-2" style="text-align: center;">{{ $item->model->name }}</td>
                                            <td class="column-3">{{ $item->price }}đ</td>
                                            <td class="column-4">
                                                <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                        onclick="updateQuantity(this)" data-rowid="{{ $item->rowId }}"
                                                        data-act="down">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </div>

                                                    <input class="mtext-104 cl3 txt-center num-product updateQty"
                                                        type="number" id="productQty_{{ $item->rowId }}"
                                                        onchange="updateQuantity(this)" data-rowid="{{ $item->rowId }}"
                                                        name="num-product1" value="{{ $item->qty }}">

                                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                        onclick="updateQuantity(this)" data-rowid="{{ $item->rowId }}"
                                                        data-act="up">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="column-5">{{ $item->subtotal(0, '', '') }}đ</td>
                                            <td class="column-3 product-remove">
                                                <div class="remove">
                                                    <a href="{{ url('carts/remove/' . $item->rowId) }}"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
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

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                        <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                            <h4 class="mtext-109 cl2 p-b-30">
                                Cart Totals
                            </h4>

                            
                            <div class="flex-w flex-t p-t-27 p-b-33">
                                <div class="size-208">
                                    <span class="mtext-101 cl2">
                                        Total:
                                    </span>
                                </div>

                                <div class="size-209 p-t-1">
                                    <span class="mtext-110 cl2">
                                        {{ Cart::instance('cart')->subtotal(0, '', '') }} vnđ
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
    <form id="updateCartQty" action="{{ route('carts.update') }}" method="POST">
        @csrf
        @method('put')
        <input type="hidden" id="rowId" name="rowId">
        <input type="hidden" id="quantity" name="quantity">
    </form>
@endsection
<script>
    function updateQuantity(element) {
        rowId = element.getAttribute('data-rowid');
        var inputElement = document.getElementById('productQty_' + rowId);
        if (element.getAttribute('data-act') === "down") {
            var quantity = parseInt(inputElement.value) - 1;
        } else if (element.getAttribute('data-act') === "up") {
            var quantity = parseInt(inputElement.value) + 1;
        } else {
            var quantity = parseInt(inputElement.value);
        }
        $('#rowId').val(rowId);
        $('#quantity').val(quantity);
        $('#updateCartQty').submit();
    }
</script>
