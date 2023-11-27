    <!-- Modal1 -->

    <div class="col-md-6 col-lg-7 p-b-30">
        <div class="p-l-25 p-r-30 p-lr-0-lg">
            <div class="wrap-slick3 flex-sb flex-w">
                <div class="wrap-slick3-dots"></div>
                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                <div class="slick3 gallery-lb">
                    <div class="item-slick3" data-thumb="{{ $product->getMedia('gallery')->first()->getUrl() }}">
                        <div class="wrap-pic-w pos-relative">
                            <img src="{{ $product->getMedia('gallery')->first()->getUrl() }}" alt="{{ $product->name }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-5 p-b-30">
        <div class="p-r-50 p-t-5 p-lr-0-lg">
            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                Sách: {{ $product->name }}
            </h4>

            <span class="mtext-106 cl2">
                Giá: ${{ $product->price }}
            </span>

            <p class="stext-102 cl3 p-t-23">
                Mô tả: {{ $product->description }}
            </p>

            <!--  -->
            <div class="p-t-33">
                <form id="addtocart" method="post" action="{{ route('carts.store') }}">
                    @csrf

                    <div class="flex-w flex-r-m p-b-10">
                        <div class="size-204 flex-w flex-m respon6-next">
                            <div style="width: 90px" class="wrap-num-product flex-w m-r-20 m-tb-10">
                                <input class="mtext-104 cl3 txt-center" min="0" max="100" type="number"
                                    name="quantity" id="quantityInput" value="1">
                            </div>
                            <a href="javascript:void(0)" id="cartEffect" class="btn"
                                onclick="event.preventDefault();document.getElementById('addtocart').submit();">
                                <button
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Add to cart
                                </button>
                            </a>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
