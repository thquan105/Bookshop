@extends('frontend.layout')

@section('title', 'Change Password')

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <a href="{{ route('profile.index') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Profile
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4">
                Change Password
            </span>
        </div>
    </div>

    <!-- form card change password -->
    <div class="bg0 p-t-75 p-b-85">
        <div class="bg3 card-header container pt-3">
            <h3 class="mb-0 text-white">Change Password</h3>
        </div>
        @if (session()->has('error'))
            <div class="alert alert-danger container">
                {{ session()->get('error') }}
            </div>
        @endif
        @if (session()->has('success'))
            <div class="alert alert-success container">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="container pt-3 boder card-body">
            <form class="form" action="{{ route('passwords.change') }}" method="post">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="inputPasswordOld">
                        <h5>Current Password</h5>
                    </label>
                    <input type="password" name="old_password" class="form-control" placeholder="{{ __('Current password') }}" required>
                </div>
                <div class="form-group">
                    <label for="inputPasswordNew">
                        <h5>New Password</h5>
                    </label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('New password') }}" required>
                    <span class="form-text small text-muted">
                        The password must be 8-20 characters, and must <em>not</em> contain spaces.
                    </span>
                    @error('password')
                        <span class="error invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPasswordNewVerify">
                        <h5>Verify</h5>
                    </label>
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="{{ __('New password confirmation') }}" autocomplete="new-password" required>
                    <span class="form-text small text-muted">
                        To confirm, type the new password again.
                    </span>
                </div>
                <div class="form-group d-flex justify-content-center">
                    <button type="submit" class="btn btn-success btn-lg float-right">Save</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /form card change password -->

@endsection
