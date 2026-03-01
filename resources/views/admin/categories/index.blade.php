@extends('layouts.admin')

@section('page_title', 'Boutique Taxonomies')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <p class="text-silver-dim small text-uppercase fw-bold mb-0">Classification</p>
        <h4 class="text-bright fw-bold mb-0">Collection Categories</h4>
    </div>
    <div class="col-md-6 text-end">
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-accent-glow">
            <i class="fas fa-plus me-2"></i> Define New Category
        </a>
    </div>
</div>

<div class="card border-silver-dim shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Identifier</th>
                        <th>Category Name</th>
                        <th>Hierarchy</th>
                        <th>Slug</th>
                        <th>Insights</th>
                        <th class="text-end pe-4">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="align-middle">
                        <td class="ps-4 text-silver-dim small">#CAT-{{ $category->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($category->image)
                                    <div class="glass-card p-1 me-3 border border-silver-dim" style="width: 40px; height: 40px;">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-cover rounded-circle">
                                    </div>
                                @else
                                    <div class="glass-card d-flex align-items-center justify-content-center me-3 border border-silver-dim opacity-50" style="width: 40px; height: 40px;">
                                        <i class="fas fa-layer-group text-accent small"></i>
                                    </div>
                                @endif
                                <span class="text-bright fw-bold">{{ $category->name }}</span>
                            </div>
                        </td>
                        <td>
                            @if($category->parent)
                                <span class="badge bg-dark border border-silver-dim py-2 px-3 rounded-pill text-silver small">
                                    <i class="fas fa-level-up-alt fa-flip-horizontal me-1 opacity-50"></i> {{ $category->parent->name }}
                                </span>
                            @else
                                <span class="text-silver-dim small">— Master</span>
                            @endif
                        </td>
                        <td class="text-silver-dim small font-monospace">{{ $category->slug }}</td>
                        <td class="text-silver opacity-75 small">
                            {{ \Illuminate\Support\Str::limit($category->description, 60) }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this classification? This may affect linked assets.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash me-1"></i> Purge
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-silver-dim italic">
                            <i class="fas fa-folder-open fa-2x mb-3 d-block opacity-25"></i>
                            No boutique categories defined yet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
        <div class="p-4 border-top border-silver-dim">
            <div class="admin-pagination">
                {{ $categories->links() }}
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
