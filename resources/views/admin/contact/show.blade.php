@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('admin.contact.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Messages
        </a>
        <h2 class="fw-bold">Message Details</h2>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>From: <strong>{{ $entry->name }}</strong> ({{ $entry->email }})</span>
        <span class="text-muted">{{ $entry->created_at->format('M d, Y H:i') }}</span>
    </div>
    <div class="card-body">
        <h5 class="card-title mb-4">Subject: {{ $entry->subject ?? 'No Subject' }}</h5>
        
        <div class="p-3 bg-dark rounded border border-secondary">
            <p class="mb-0" style="white-space: pre-wrap;">{{ $entry->message }}</p>
        </div>
        
        <div class="mt-4 d-flex justify-content-end">
            <form action="{{ route('admin.contact.destroy', $entry) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-trash me-1"></i> Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
