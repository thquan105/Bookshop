@extends('frontend.layout')

@section('title', 'Thank you')

@section('content')


    <div class="jumbotron text-center container m-t-30">
        <img alt="" src="{{ asset('images/thanks.png') }}"
            style="width: 100%; max-width: 223px; max-height: 294px;">
        <h1 class="display-3">Thank you for your order!</h1>
        <br>
        <p class="lead"><strong>Your order will be delivered in 2-3 working days!</strong></p>
        <hr>
        <br>
        <p>
            Having trouble? <a href="">Contact us</a>
        </p>
        <p class="lead">
            <a class="btn btn-primary btn-sm" href="{{ route('home') }}" role="button">Continue to homepage</a>
        </p>
    </div>

@endsection
