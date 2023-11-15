@extends('frontend.layout')

@section('title', 'Profile')

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                Profile
            </span>
        </div>
    </div>

    <div class="container-xl px-4 mt-4">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2"
                            src="http://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                        <!-- Profile picture help block-->
                        <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                        <!-- Profile picture upload button-->
                        <button class="btn btn-primary" type="button">Upload new image</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="post">
                            @csrf
                            @method('put')
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Username (how your name will appear to other
                                    users on the site)</label>
                                <input class="form-control" id="name" type="text" name="name"
                                    value="{{ auth()->user()->name }}">
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="first_name">First Name</label>
                                    <input class="form-control" type="text" name="first_name" id="first_name"
                                        value="{{ auth()->user()->first_name }}">
                                    @error('first_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="last_name">Last Name</label>
                                    <input class="form-control" type="text" name="last_name" id="last_name"
                                        value="{{ auth()->user()->last_name }}">
                                    @error('last_name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="email">Email address</label>
                                <input class="form-control" type="text" name="email" id="email"
                                    value="{{ auth()->user()->email }}">
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Form Row-->
                            <!-- Form Row        -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Province <span class="required">*</span></label>
                                    <select class="form-control" name="province_id" id="province-id"
                                        value="{{ auth()->user()->province_id }}">
                                        <option value="">- Please Select -</option>
                                        @foreach ($provinces as $province => $pro)
                                            <option {{ auth()->user()->province_id == $province ? 'selected' : null }}
                                                value="{{ $province }}">{{ $pro }}</option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">City <span class="required">*</span></label>
                                    <select class="form-control" name="city_id" id="city-id"  value="{{ auth()->user()->city_id }}" >
                                        <option value="">Select City</option>
                                        @foreach($cities as $city => $ty)
                                            <option {{ auth()->user()->city_id == $city ? 'selected' : null }} value="{{ $city }}">{{ $ty }}</option>
                                        @endforeach
                                    </select> 
                                    @error('city_id')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Form Group (address)-->
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="small mb-1" for="address1">Address1</label>
                                    <textarea class="form-control" name="address1" rows="5">{{ auth()->user()->address1 }}</textarea>
                                    @error('address1')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="small mb-1" for="address2">Address2</label>
                                    <textarea class="form-control" name="address2" rows="5">{{ auth()->user()->address2 }}</textarea>
                                    @error('address2')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <!-- Form Group (phone number)-->
                                    <label class="small mb-1" for="phone">Phone <span
                                            class="required">*</span></label>
                                    <input class="form-control" type="phone" name="phone" id="phone"
                                        value="{{ auth()->user()->phone }}">
                                    @error('phone')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="postcode">Postcode / Zip <span
                                            class="required">*</span></label>
                                    <input class="form-control" type="number" name="postcode" id="postcode"
                                        value="{{ auth()->user()->postcode }}">
                                    @error('postcode')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <a class="btn btn-link" href="{{ route('passwords.index') }}">
                                <button class="btn btn-primary" type="button">Change Password</button>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script-alt')
    <script>
        $('#province-id').on('change', function() {
            var province_id = this.value;
            $("#city-id").html('');
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
                        $("#city-id").append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        });
    </script>
@endpush
