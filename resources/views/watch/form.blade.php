<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Watch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 600px;">
        <h2 class="mb-4">Upload New Watch</h2>
        
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('watch.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">Watch Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Thumbnail Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label class="form-label">3D Model (.glb)</label>
                <input type="file" name="glb_model" class="form-control" accept=".glb" required>
                <div class="form-text">Upload a single .glb file (Max 100MB)</div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>
    </div>
</body>
</html>