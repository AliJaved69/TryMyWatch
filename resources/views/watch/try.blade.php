<!DOCTYPE html>
<html>
<head>
    <title>AR Watch Try On</title>
    <style>
        body { margin: 0; overflow: hidden; }
        video { position: fixed; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
        canvas { position: fixed; top: 0; left: 0; }
    </style>
</head>
<body>

<video id="video" autoplay playsinline></video>
<canvas id="three-canvas"></canvas>

<!-- MediaPipe -->
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>

<!-- Three.js -->
<script src="https://cdn.jsdelivr.net/npm/three@0.158.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.158.0/examples/js/loaders/GLTFLoader.js"></script>

<script>
const MODEL_URL = "{{ asset('storage/watches/'.$watch->glb_model) }}";
</script>

<script src="{{ asset('js/ar-watch.js') }}"></script>

</body>
</html>
