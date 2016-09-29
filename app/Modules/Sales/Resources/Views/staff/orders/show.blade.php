@extends('layouts.staff.dashboard')

@section('page-title')
    #{{ $order->publicId() }} | Orders
@endsection

@section('header')
    Order #{{ $order->publicId() }} (£{{ $order->totalPrice() }})
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2>Items</h2>
            <table class="table table-striped">
                <tbody>
                @if ($order->orderItems)
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                {{ $item->basketItem->productOption->product->name }}
                            </td>
                            <td>
                                {{ $item->basketItem->productOption->label }}
                            </td>
                            <td class="price">
                                £{{ $item->priceAsFloat() }}
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h2>Payment</h2>
            @if ($order->payment->settlement->type() === 'paypal')
                <p>PayPal</p>
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td>Payment ID:</td>
                            <td>
                                {{ $order->payment->settlement->payment_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>Payer ID:</td>
                            <td>
                                {{ $order->payment->settlement->payer_id }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <h2>Address</h2>
    <p>
        @if ($order->address)
            {{ $order->address->name }}<br>
            {{ $order->address->line_one }}<br>
            @if($order->address->line_two)
                {{ $order->address->line_two }}<br>
            @endif
            {{ $order->address->city }}<br>
            {{ $order->address->post_code }}<br>
            {{ $order->address->country_code }}
        @endif
    </p>
@endsection
