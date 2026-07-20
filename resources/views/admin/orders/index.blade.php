@extends('layouts.admin')

@section('page_title', 'Boutique Acquisitions')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <p class="text-silver-dim small text-uppercase fw-bold mb-0">Financial Oversight</p>
        <h4 class="text-bright fw-bold mb-0">Order Historique</h4>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-inline-block" style="max-width: 350px;">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-sm bg-transparent border-secondary text-white font-monospace" placeholder="Search Tracking ID, name, email..." value="{{ request('search') }}" style="font-size: 0.85rem; border-color: rgba(197, 198, 199, 0.2) !important;">
                <button class="btn class-button btn-sm btn-outline-light" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="card border-silver-dim shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Reference</th>
                        <th>Timestamp</th>
                        <th>Client</th>
                        <th>Investment</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="align-middle">
                        <td class="ps-4 fw-bold text-accent font-monospace">{{ $order->order_number }}</td>
                        <td class="text-silver-dim small">{{ $order->created_at->format('M d, Y • H:i') }}</td>
                        <td class="text-bright fw-600">{{ $order->name }}</td>
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
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-light rounded-pill px-4">
                                <i class="fas fa-eye me-1"></i> Review
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-silver-dim italic">
                            <i class="fas fa-receipt fa-2x mb-3 d-block opacity-25"></i>
                            No acquisitions recorded in the boutique yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
        <div class="p-4 border-top border-silver-dim">
            <div class="admin-pagination">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.4); }
    .border-silver-dim { border-color: rgba(241, 229, 172, 0.05) !important; }
    
    .admin-pagination .pagination { margin-bottom: 0; }
    .admin-pagination .page-link {
        background: transparent;
        border-color: rgba(197, 198, 199, 0.1);
        color: var(--text);
    }
    .admin-pagination .page-item.active .page-link {
        background: var(--accent);
        border-color: var(--accent);
        color: #0b0c10;
        font-weight: bold;
    }
</style>
@endsection
