@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        <div class="invoice-wrapper rounded border bg-white py-5 px-3 px-md-4 px-lg-5">
            <div class="d-flex justify-content-between">
                <h2 class="text-dark font-weight-medium">Order ID #{{ $order->id }}</h2>
                <div class="btn-group">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-success">
                     Go Back</a>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-xl-5 col-lg-5">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:24px; text-transform: uppercase;">Billing Address</p>
                    <address>
                        Customer: {{ $order->customer_first_name }} {{ $order->customer_last_name }}
                        <br> Address1: {{ $order->customer_address1 }}
                        <br> Address1: {{ $order->customer_address2 }}
                        <br> Email: {{ $order->customer_email }}
                        <br> Phone: {{ $order->customer_phone }}
                        <br> Postcode: {{ $order->customer_postcode }}
                    </address>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <p class="text-dark mb-2" style="font-weight: normal; font-size:24px; text-transform: uppercase;">Details</p>
                    <address>
                        ID: <span class="text-dark">#{{ $order->id }}</span>
                        <br> DATE: <span>{{ $order->order_date }}</span>
                        <br>
                        <br> Status: {{ $order->status }} 
                        <br> Payment Status: {{ $order->payment_status }}
                    </address>
                </div>
            </div>
            <table class="table mt-3 table-striped table-responsive table-responsive-large" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orderItems as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>Rp.{{ number_format($item->base_price) }}</td>
                            <td>Rp.{{ number_format($item->sub_total) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">Order item not found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="row justify-content-end">
                <div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">
                    <ul class="list-unstyled mt-4">
                        <li class="mid pb-3 text-dark">Subtotal
                            <span class="d-inline-block float-right text-default">{{ $order->base_total_price }}</span>
                        </li>
                        <li class="mid pb-3 text-dark">Shipping Cost
                            <span class="d-inline-block float-right text-default">{{ $order->shipping_cost }}</span>
                        </li>
                        <li class="pb-3 text-dark">Total
                            <span class="d-inline-block float-right">{{ $order->grand_total }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection