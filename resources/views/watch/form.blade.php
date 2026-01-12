<!DOCTYPE html>
<html>
<head>
    <title>Add Watch</title>
    <style>
        body { font-family: Arial; padding: 30px; }
        input, button { display: block; margin-bottom: 15px; padding: 8px; width: 300px; }
    </style>
</head>
<body>

<h2>Add New Watch</h2>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<form action="{{ route('watch.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Watch Name</label>
    <input type="text" name="name" required>

    <label>Price</label>
    <input type="number" step="0.01" name="price" required>

    <label>Watch Image (PNG/JPG)</label>
    <input type="file" name="image" required>

    <label>3D Model (.glb)</label>
    <input type="file" name="glb_model" accept=".glb,.gltf" required>

    <button type="submit">Add Watch</button>
</form>

</body>
</html>
