@extends('layouts.app')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex">
            <h6 class="m-0 font-weight-bold text-primary">
                {{ __('Report Product') }}
            </h6>
        </div>
        <div class="table-responsive">
        <a href="{{ route('admin.exportProducts') }}" class="btn btn-success shadow-sm " style="margin-left: 5px; margin-top: 5px;margin-bottom: 5px;"> <i
                                    class="fa">Export</i></a>
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date sold</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $orderItem)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $orderItem->name }} <br />
                            </td>
                            <td>{{ $orderItem->qty }}</td>
                            <td>{{ $orderItem->base_price }}</td>
                            <td>
                                {{ $orderItem->created_at }} 
                            </td>
                            <td>{{ $orderItem->qty * $orderItem->base_price }}</td>                          
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="12">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
