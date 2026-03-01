@extends('layouts.admin')

@section('page_title', 'Client Concierge')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <p class="text-silver-dim small text-uppercase fw-bold mb-0">Communication</p>
        <h4 class="text-bright fw-bold mb-0">Inquiry Registry</h4>
    </div>
</div>

<div class="card border-silver-dim shadow-lg">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Status</th>
                        <th>Client</th>
                        <th>Coordinate</th>
                        <th>Subject</th>
                        <th>Received</th>
                        <th class="text-end pe-4">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                    <tr class="align-middle {{ $entry->is_read ? 'opacity-75' : 'fw-bold bg-accent bg-opacity-5' }}">
                        <td class="ps-4">
                            @if($entry->is_read)
                                <span class="badge bg-dark border border-silver-dim text-silver-dim py-2 px-3 rounded-pill" style="font-size: 0.65rem;">
                                    ARCHIVED
                                </span>
                            @else
                                <span class="badge bg-accent bg-opacity-10 text-accent border border-accent py-2 px-3 rounded-pill animate-pulse" style="font-size: 0.65rem; letter-spacing: 1px;">
                                    UNREAD
                                </span>
                            @endif
                        </td>
                        <td class="text-bright">{{ $entry->name }}</td>
                        <td class="text-silver-dim small">{{ $entry->email }}</td>
                        <td class="text-silver">
                            <span class="d-inline-block text-truncate" style="max-width: 250px;">
                                {{ $entry->subject ?? 'General Inquiry' }}
                            </span>
                        </td>
                        <td class="small text-silver-dim">{{ $entry->created_at->diffForHumans() }}</td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.contact.show', $entry) }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Open
                                </a>
                                <form action="{{ route('admin.contact.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Permanently remove this correspondence?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash me-1"></i> Erase
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-silver-dim italic">
                            <i class="fas fa-comment-slash fa-2x mb-3 d-block opacity-25"></i>
                            No client inquiries detected in the registry.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($entries->hasPages())
        <div class="p-4 border-top border-silver-dim">
            <div class="admin-pagination">
                {{ $entries->links() }}
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

    @keyframes pulse {
        0% { opacity: 0.8; }
        50% { opacity: 1; transform: scale(1.02); }
        100% { opacity: 0.8; }
    }
    .animate-pulse {
        animation: pulse 2s infinite ease-in-out;
    }
</style>
@endsection
