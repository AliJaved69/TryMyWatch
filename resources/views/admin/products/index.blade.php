@extends('layouts.admin')

@section('page_title', 'Curated Inventory')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <p class="text-silver-dim small text-uppercase fw-bold mb-0">Management</p>
        <h4 class="text-bright fw-bold mb-0">Product Catalog</h4>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary shadow-accent-glow">
            <i class="fas fa-plus me-2"></i> Register New Piece
        </a>
    </div>
</div>

<div class="card border-silver-dim shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Ref ID</th>
                        <th>Piece</th>
                        <th>Boutique Price</th>
                        <th>Category</th>
                        <th>Collection</th>
                        <th class="text-end pe-4">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="align-middle">
                        <td class="ps-4 text-silver-dim small">#PRD-{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="glass-card p-1 me-3 border border-silver-dim" style="width: 55px; height: 55px;">
                                    <img src="{{ $product->thumbnail }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover rounded">
                                </div>
                                <div>
                                    <span class="text-bright fw-bold d-block">{{ \Illuminate\Support\Str::limit($product->title, 40) }}</span>
                                    <span class="text-silver-dim small">{{ $product->brand }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="fw-bold text-accent">${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge bg-dark border border-silver-dim py-2 px-3 rounded-pill text-silver small">
                                {{ $product->category }}
                            </span>
                        </td>
                        <td class="text-silver-dim">{{ $product->brand }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this piece from the catalog?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash me-1"></i> Archive
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-silver-dim italic">
                            <i class="fas fa-gem fa-2x mb-3 d-block opacity-25"></i>
                            No curated pieces found in the inventory.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="p-4 border-top border-silver-dim">
            <div class="admin-pagination">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.4); }
    .border-silver-dim { border-color: rgba(241, 229, 172, 0.05) !important; }
    .object-fit-cover { object-fit: cover; }
    
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
