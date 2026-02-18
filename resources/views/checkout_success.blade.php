@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="container py-5" style="margin-top: 80px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-5">
                <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                <h1 class="fw-bold mt-3">Thank you for your order!</h1>
                <p class="lead text-secondary">Your order has been placed successfully.</p>
            </div>

            <div class="card bg-dark border-secondary shadow-lg mb-4">
                <div class="card-header border-secondary bg-transparent">
                    <h5 class="mb-0 text-white">Order Details <span class="text-accent">#{{ $order->id }}</span></h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-secondary">Customer Info</h6>
                            <p class="text-white mb-0">
                                <strong>{{ $order->name }}</strong><br>
                                {{ $order->email }}<br>
                                {{ $order->phone }}
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h6 class="text-secondary">Shipping Address</h6>
                            <p class="text-white mb-0">
                                {{ $order->address }}
                            </p>
                        </div>
                    </div>

                    <hr class="border-secondary">

                    <h6 class="text-secondary mb-3">Order Summary</h6>
                    <div class="table-responsive">
                        <table class="table table-dark table-borderless">
                            <tbody>
                                @php
                                    $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                                @endphp
                                @foreach($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($item['image']))
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" width="50" class="rounded me-3">
                                            @endif
                                            <div>
                                                <div class="text-white">{{ $item['name'] }}</div>
                                                <small class="text-secondary">Price: ${{ number_format($item['price'], 2) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end text-white">x{{ $item['quantity'] }}</td>
                                    <td class="text-end text-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                </tr>
                                @endforeach
                                <tr class="border-top border-secondary">
                                    <td colspan="2" class="text-end fw-bold text-white">Total</td>
                                    <td class="text-end fw-bold text-accent fs-5">${{ number_format($order->total_price, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ url('/shop') }}" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-shopping-bag me-1"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    localStorage.removeItem('cart');
</script>
@endsection
