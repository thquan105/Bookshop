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
    @if (isset($message))
        <div class="alert alert-danger">
            <div class="container">
                {{ $message }}
            </div>
        </div>
    @endif

    <!-- Checkout Start -->
    <div class="container-fluid pt-5">
        <form id="myForm" action="{{ route('cart.confirmCheckout') }}" method="POST">
            @csrf
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Billing Address
                        </h4>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" type="text" name="first_name" value="{{ auth()->user()->first_name }}">
                                @error('first_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" type="text" name="last_name" value="{{ auth()->user()->last_name }}">
                                @error('last_name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" name="email" value="{{ auth()->user()->email }}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="phone" value="{{ auth()->user()->phone }}">
                                @error('phone')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <textarea class="form-control" name="address1" rows="5">{{ auth()->user()->address1 }}</textarea>
                                @error('address1')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <textarea class="form-control" name="address2" rows="5">{{ auth()->user()->address2 }}</textarea>
                                @error('address2')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Province <span class="required">*</label>
                                    <select class="form-control" name="province_id" id="province-id"
                                    value="{{ auth()->user()->province_id }}">
                                    <option value="">Select Province</option>
                                    @foreach ($provinces as $province => $pro)
                                        <option {{ auth()->user()->province_id == $province ? 'selected' : null }}
                                            value="{{ $province }}">{{ $pro }}</option>
                                    @endforeach
                                </select>
                                @error('province_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City <span class="required">*</span></label>
                                <select class="form-control" name="city_id" id="city-id" value="{{ auth()->user()->city_id }}">
                                    <option value="">Select City</option>
                                    @foreach ($cities as $city => $ty)
                                        <option {{ auth()->user()->city_id == $city ? 'selected' : null }}
                                            value="{{ $city }}">{{ $ty }}</option>
                                    @endforeach
                                </select>
                                @error('city_id')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" name="postcode" value="{{ auth()->user()->postcode }}">
                                @error('postcode')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                            @foreach ($items as $item)
                                <div class="d-flex justify-content-between">
                                    <p>{{ $item->model->name }}</p>
                                    <p>{{ $item->price }} vnđ x {{ $item->qty }}</p>
                                    <p>{{ $item->subtotal(0,'','') }} vnđ</p>
                                </div>
                            @endforeach

                            <hr class="mt-0">
                            <div class="d-flex justify-content-between mb-3 pt-1">
                                <h6 class="font-weight-medium">Subtotal</h6>
                                <h6 class="font-weight-medium">{{ Cart::instance('cart')->subtotal(0, '', '') }} vnđ</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Shipping</h6>
                                <h6 class="font-weight-medium">10000 vnđ</h6>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <div class="d-flex justify-content-between mt-2">
                                <h5 class="font-weight-bold">Total</h5>
                                <h5 id="totalAmount" class="font-weight-bold form-group">{{ Cart::instance('cart')->subtotal( 0, '','' )+10000 }} vnđ</h5>
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
                                    <input type="radio" class="form-check-input payUrl" name="payment" id="paypal"
                                        checked onchange="updatePlaceOrderButtonName()">
                                    <label class="form-check-label" for="paypal">Momo</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="form-check ml-4">
                                    <input type="radio" class="form-check-input payLater" name="payment"
                                        id="directcheck" onchange="updatePlaceOrderButtonName()">
                                    <label class="form-check-label" for="directcheck">Thanh toán khi nhận hàng</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <button type="submit" name="payUrl" id="placeOrderButton"
                                class="flex-c-m stext-101 cl0 size-116 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->

@endsection
@push('script-alt')
    <script>
        $('#province-id').on('change', function() {
            var province_id = this.value;
            $('#city-id').html('<option value="">Select City</option>');
            if (province_id == null || province_id == '') {
                return;
            } else {
                $.ajax({
                    url: "{{ url('get-cities') }}",
                    type: "POST",
                    data: {
                        province_id: province_id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#city-id').html('<option value="">Select City</option>');
                        $.each(result.cities, function(key, value) {
                            //console.log(value);
                            $("#city-id").append('<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            }
        });
    </script>
    <script>
        function updatePlaceOrderButtonName() {
            var payUrlRadio = document.getElementById("paypal");
            var placeOrderButton = document.getElementById("placeOrderButton");

            if (payUrlRadio.checked) {
                placeOrderButton.name = "payUrl";
            } else {
                placeOrderButton.name = "payLater";
            }
        }
    </script>
@endpush
