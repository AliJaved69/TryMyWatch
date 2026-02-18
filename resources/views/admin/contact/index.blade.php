@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="fw-bold">Contact Messages</h2>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="bg-dark">
                    <tr>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                    <tr class="{{ $entry->is_read ? '' : 'fw-bold bg-dark bg-opacity-10' }}">
                        <td>
                            @if($entry->is_read)
                                <span class="badge bg-secondary">Read</span>
                            @else
                                <span class="badge bg-success">New</span>
                            @endif
                        </td>
                        <td>{{ $entry->name }}</td>
                        <td>{{ $entry->email }}</td>
                        <td>{{ $entry->subject ?? 'No Subject' }}</td>
                        <td>{{ $entry->created_at->diffForHumans() }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.contact.show', $entry) }}" class="btn btn-sm btn-primary">
                                    View
                                </a>
                                <form action="{{ route('admin.contact.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No messages found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-3">
            {{ $entries->links() }}
        </div>
    </div>
</div>
@endsection
