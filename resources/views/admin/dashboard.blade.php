@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">Dashboard</h2>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Total Orders -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary pb-2">Total Orders</h6>
                <h3 class="fw-bold">{{ $totalOrders }}</h3>
            </div>
        </div>
    </div>
    
    <!-- Total Sales -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary pb-2">Total Sales</h6>
                <h3 class="fw-bold text-accent">${{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>
    
    <!-- Total Products -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-secondary pb-2">Total Products</h6>
                <h3 class="fw-bold">{{ $totalProducts }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Recent Orders</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-light">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-dark">
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>${{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->status == 'completed' ? 'bg-success' : ($order->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No recent orders found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
