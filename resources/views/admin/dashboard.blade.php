@extends('layouts.admin')

@section('page_title', 'Operational Intelligence')

@section('content')
<div class="row g-4 mb-5">
    <!-- Total Revenue -->
    <div class="col-xl-4 col-md-6">
        <div class="card h-100 border-silver-dim">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-silver-dim small text-uppercase fw-bold mb-1">Gross Revenue</p>
                        <h2 class="gradient-text fw-800 mb-0">${{ number_format($totalRevenue, 2) }}</h2>
                    </div>
                    <div class="glass-card p-3 rounded-3">
                        <i class="fas fa-coins text-accent fs-4"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="text-success small fw-bold me-2"><i class="fas fa-caret-up me-1"></i>System Active</span>
                    <span class="text-silver-dim small">Live Updates</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Total Orders -->
    <div class="col-xl-4 col-md-6">
        <div class="card h-100 border-silver-dim">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-silver-dim small text-uppercase fw-bold mb-1">Boutique Orders</p>
                        <h2 class="text-bright fw-800 mb-0">{{ $totalOrders }}</h2>
                    </div>
                    <div class="glass-card p-3 rounded-3">
                        <i class="fas fa-shopping-bag text-accent fs-4"></i>
                    </div>
                </div>
                <p class="text-silver-dim small mb-0">Total lifecycle conversions</p>
            </div>
        </div>
    </div>
    
    <!-- Total Products -->
    <div class="col-xl-4 col-md-12">
        <div class="card h-100 border-silver-dim">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <p class="text-silver-dim small text-uppercase fw-bold mb-1">Luxury Inventory</p>
                        <h2 class="text-bright fw-800 mb-0">{{ $totalProducts }}</h2>
                    </div>
                    <div class="glass-card p-3 rounded-3">
                        <i class="fas fa-gem text-accent fs-4"></i>
                    </div>
                </div>
                <p class="text-silver-dim small mb-0">Active curated pieces</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-silver-dim shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold"><i class="fas fa-clock me-2"></i>Recent Acquisitions</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                    Comprehensive View
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">Reference</th>
                                <th>Client</th>
                                <th>Timestamp</th>
                                <th>Investment</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr class="align-middle">
                                <td class="ps-4 fw-bold text-accent">#ORD-{{ $order->id }}</td>
                                <td class="text-bright">{{ $order->name }}</td>
                                <td class="small opacity-75">{{ $order->created_at->format('M d, H:i') }}</td>
                                <td class="fw-bold">${{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'completed' => 'bg-success bg-opacity-10 text-success border-success',
                                            'pending' => 'bg-warning bg-opacity-10 text-warning border-warning',
                                            'cancelled' => 'bg-danger bg-opacity-10 text-danger border-danger'
                                        ][$order->status] ?? 'bg-secondary bg-opacity-10 text-white border-secondary';
                                    @endphp
                                    <span class="badge border py-2 px-3 {{ $statusClass }} rounded-pill" style="font-size: 0.7rem; letter-spacing: 0.5px;">
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                        <i class="fas fa-eye me-1"></i> Review
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-silver-dim italic">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block opacity-25"></i>
                                    No recent activity detected in the boutique.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.4); }
    .border-silver-dim { border-color: rgba(241, 229, 172, 0.05) !important; }
</style>
@endsection
