@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        <h2 class="fw-bold">Order #{{ $order->id }} Details <span class="fs-5 text-muted">({{ $order->order_number }})</span></h2>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Order Items -->
        <div class="card mb-4">
            <div class="card-header">
                Order Items
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                             @php
                                $items = json_decode($order->items, true);
                            @endphp
                            
                            @if(is_array($items))
                                @foreach($items as $item)
                                @php
                                    $itemData = is_string($item) ? json_decode($item, true) : $item;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($itemData['thumbnail']) || isset($itemData['image']))
                                                <img src="{{ $itemData['thumbnail'] ?? $itemData['image'] }}" alt="{{ $itemData['title'] ?? $itemData['name'] ?? 'Product' }}" width="50" class="rounded me-3 border border-secondary" style="object-fit: cover; height: 50px;">
                                            @endif
                                            <div>
                                                <div class="text-white fw-bold">{{ $itemData['title'] ?? $itemData['name'] ?? 'Product' }}</div>
                                                <small class="text-accent">${{ number_format($itemData['price'] ?? 0, 2) }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center text-white">x{{ $itemData['quantity'] ?? 1 }}</td>
                                    <td class="text-end text-white">${{ number_format(($itemData['price'] ?? 0) * ($itemData['quantity'] ?? 1), 2) }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-white">{{ $order->items }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <!-- Customer Details -->
        <div class="card mb-4">
            <div class="card-header">
                Customer Information
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $order->name }}</h5>
                <p class="card-text">
                    <strong>Email:</strong> {{ $order->email }}<br>
                    <strong>Phone:</strong> {{ $order->phone }}
                </p>
                <hr>
                <h6>Shipping Address</h6>
                <p class="card-text">{{ $order->address }}</p>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="card mb-4">
            <div class="card-header">
                Order Summary
            </div>
            <div class="card-body">
                 <div class="d-flex justify-content-between mb-2">
                    <span>Payment Method:</span>
                    <span class="text-uppercase">{{ $order->payment_method }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Total:</span>
                    <span class="fw-bold">${{ number_format($order->total_price, 2) }}</span>
                </div>
                
                <hr>
                
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Update Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" id="status">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
