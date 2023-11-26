@extends('frontend.layout')

@section('title', 'Checkout')

@section('content')

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{ route('carts.index') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Shoping Cart
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Checkout
            </span>
        </div>
    </div>

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="mtext-109 cl2 p-b-30">
                        Billing Address
                    </h4>
                    <form id="myForm" action="{{ route('cart.confirmCheckout') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label >First Name</label>
                                <input class="form-control" type="text" name="FirstName" placeholder="John">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="LastName" placeholder="Doe">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" name="Email" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="MobileNo" placeholder="+123 456 789">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" name="Address1" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" type="text" name="Address2" placeholder="123 Street">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country">
                                    <option selected>United States</option>
                                    <option>Afghanistan</option>
                                    <option>Albania</option>
                                    <option>Algeria</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="City" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" name="State" placeholder="New York">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" name="ZipCode" placeholder="123">
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit" name="payUrl"  class="flex-c-m stext-101 cl0 size-116 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg3 border-0">
                        <h4 class="mtext-109 text-white cl2">
                            Order Total
                        </h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 1</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 2</p>
                            <p>$150</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <p>Colorful Stylish Shirt 3</p>
                            <p>$150</p>
                        </div>
                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 id="totalAmount" class="font-weight-bold">160</h5>
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg3 border-0">
                        <h4 class="mtext-109 text-white cl2">
                            Payment
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group ml-4">
                            <div class="form-check">
                                <input type="radio" class="form-check-input payUrl" name="payment" id="paypal" checked>
                                <label class="form-check-label" for="paypal">Momo</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check ml-4">
                                <input type="radio" class="form-check-input payLater" name="payment" id="directcheck">
                                <label class="form-check-label" for="directcheck">Thanh toán khi nhận hàng</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card-footer border-secondary bg-transparent">
                        <button type="submit" name="payUrl" onclick="submitForm()" class="flex-c-m stext-101 cl0 size-116 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Place Order
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Checkout End -->
    
@endsection


@push('script-alt')
<script>
    document.getElementById('placeOrderBtn').addEventListener('click', function() {
        // Lấy giá trị từ thẻ h5
        var totalAmount = document.getElementById('totalAmount').innerText;
        console.log('Total Amount:', totalAmount);
    });
</script>
@endpush