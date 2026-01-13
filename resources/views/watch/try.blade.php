<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Try On</title>
    <style>
        body { margin: 0; overflow: hidden; background-color: #000; }
        
        /* UPDATED: Removed 'transform: scaleX(-1)' so back camera looks normal */
        video { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover; }
        
        canvas { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; pointer-events: none; z-index: 10; }
        
        #ui {
            position: fixed; top: 20px; left: 20px; z-index: 20;
            color: white; font-family: sans-serif;
            background: rgba(0, 0, 0, 0.7); padding: 15px; border-radius: 8px;
        }
    </style>
</head>
<body>

<div id="ui">
    <h3 style="margin: 0 0 5px 0;">{{ $watch->name }}</h3>
    <p id="status" style="margin: 0; color: #aaa;">Initializing...</p>
</div>

<video id="video" autoplay playsinline></video>
<canvas id="three-canvas"></canvas>

<script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands@0.4.1646424915/hands.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>

<script type="importmap">
{
  "imports": {
    "three": "https://unpkg.com/three@0.152.2/build/three.module.js",
    "three/addons/": "https://unpkg.com/three@0.152.2/examples/jsm/"
  }
}
</script>

<script>
    window.WATCH_CONFIG = {
        modelUrl: "{{ asset('storage/' . $watch->glb_model) }}"
    };
    console.log("Loading Model:", window.WATCH_CONFIG.modelUrl);
</script>

<script type="module" src="{{ asset('js/ar-watch.js') }}"></script>

</body>
</html>