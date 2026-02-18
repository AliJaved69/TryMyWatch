@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to Products
        </a>
        <h2 class="fw-bold">Edit Product: {{ $product->title }}</h2>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="title" class="form-label">Product Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $product->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="price" class="form-label">Price ($)</label>
                    <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ old('category', $product->category) == $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="brand" class="form-label">Brand</label>
                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                    @error('brand')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail Image</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail" accept="image/*">
                @if($product->thumbnail)
                    <div class="mt-2">
                        <img src="{{ $product->thumbnail }}" alt="Current Thumbnail" width="100" class="rounded">
                        <small class="d-block text-secondary">Current Thumbnail</small>
                    </div>
                @endif
                @error('thumbnail')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gallery" class="form-label">Gallery Images (Multiple)</label>
                <input type="file" class="form-control @error('gallery') is-invalid @enderror" id="gallery" name="gallery[]" accept="image/*" multiple>
                @if($product->gallery)
                    <div class="mt-2 d-flex gap-2">
                        @foreach($product->gallery as $img)
                            <img src="{{ $img }}" alt="Gallery Image" width="60" class="rounded">
                        @endforeach
                    </div>
                    <small class="d-block text-secondary">Current Gallery</small>
                @endif
                @error('gallery')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="model_3d" class="form-label">3D Model (.glb/.gltf)</label>
                <input type="file" class="form-control @error('model_3d') is-invalid @enderror" id="model_3d" name="model_3d" accept=".glb,.gltf">
                @if($product->model_3d)
                    <div class="mt-2 text-secondary">
                        <i class="fas fa-cube me-1"></i> Current Model: {{ basename($product->model_3d) }}
                    </div>
                @endif
                @error('model_3d')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection
