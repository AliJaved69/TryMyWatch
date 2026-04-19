{{-- <!DOCTYPE html>
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
            color: var(--text-bright); font-family: 'Outfit', sans-serif;
            background: var(--glass); padding: 15px; border-radius: 8px;
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
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Watch VTO - Fixed</title>
    <style>
        body { margin: 0; overflow: hidden; background: #000; }
        #video {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transform: scaleX(-1); /* Mirror effect */
            z-index: 0; display: none; /* Hidden, we render to texture or background */
        }
        #three-canvas {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1;
        }
        #status {
            position: absolute; top: 20px; left: 20px;
            color: var(--accent); font-family: 'Outfit', sans-serif; font-size: 16px; z-index: 2;
            background: var(--glass); padding: 5px 10px;
        }
    </style>
    <!-- MediaPipe Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/control_utils/control_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
    
    <!-- Three.js Import Map -->
    <script type="importmap">
        {
            "imports": {
                "three": "https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js",
                "three/addons/": "https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/"
            }
        }
    </script>
</head>
<body>

    <video id="video" playsinline></video>
    <canvas id="three-canvas"></canvas>
    <div id="status">Initializing...</div>

    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

        // CONFIGURATION
        const CONFIG = {
            // Replace with your GLB/GLTF URL
            modelUrl: 'https://raw.githubusercontent.com/KhronosGroup/glTF-Sample-Models/master/2.0/SheenChair/glTF-Binary/SheenChair.glb', 
            // NOTE: I'm using a placeholder chair because I don't have your watch URL. 
            // REPLACE the URL above with your watch model.
            
            scaleMultiplier: 5.0, // Adjust this to make watch bigger/smaller
            zOffset: 0.2, // Pushes watch 'out' of the wrist (Visual wrap fix)
            smoothFactor: 0.15 // 0.1 = slow/smooth, 0.9 = fast/jittery
        };

        const video = document.getElementById('video');
        const canvas = document.getElementById('three-canvas');
        const status = document.getElementById('status');

        /* ---------------- SCENE SETUP ---------------- */
        const scene = new THREE.Scene();
        
        // Use video as background texture
        const videoTexture = new THREE.VideoTexture(video);
        scene.background = videoTexture;

        const camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 100);
        camera.position.z = 10; // moved back a bit for better perspective

        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio);

        /* ---------------- LIGHTING ---------------- */
        const hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444, 2.0);
        scene.add(hemiLight);
        const dirLight = new THREE.DirectionalLight(0xffffff, 2.0);
        dirLight.position.set(0, 5, 5);
        scene.add(dirLight);

        /* ---------------- MODEL LOADING ---------------- */
        // We use a Group to handle the tracking position/rotation
        const watchGroup = new THREE.Group();
        scene.add(watchGroup);
        
        let watchModel = null;
        const loader = new GLTFLoader();

        status.innerText = 'Loading model...';

        loader.load(
            CONFIG.modelUrl,
            (gltf) => {
                watchModel = gltf.scene;

                // Center the geometry
                const box = new THREE.Box3().setFromObject(watchModel);
                const center = box.getCenter(new THREE.Vector3());
                watchModel.position.sub(center);

                // --- FIX 1: THE 90 DEGREE TILT ---
                // We rotate the MODEL inside the GROUP.
                // Adjust these axes if it tilts the wrong way.
                // Typically: Rotate X or Z to flip it 90 degrees.
                watchModel.rotation.z = -Math.PI / 2; // Tilt 90 degrees Right
                // watchModel.rotation.x = -Math.PI / 2; // Uncomment if face is pointing wrong way
                
                watchGroup.add(watchModel);
                watchGroup.visible = false;

                status.innerText = 'Point camera at your wrist';
            },
            undefined,
            (err) => {
                console.error(err);
                status.innerText = 'Error loading model';
            }
        );

        /* ---------------- MEDIAPIPE LOGIC ---------------- */
        const hands = new Hands({
            locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
        });

        hands.setOptions({
            maxNumHands: 1,
            modelComplexity: 1,
            minDetectionConfidence: 0.5,
            minTrackingConfidence: 0.5
        });

        const targetPos = new THREE.Vector3();
        const targetQuat = new THREE.Quaternion();
        const targetScale = new THREE.Vector3(1, 1, 1);
        let isHandDetected = false;

        hands.onResults((results) => {
            if (!watchModel || !watchGroup) return;

            if (!results.multiHandLandmarks?.length) {
                isHandDetected = false;
                watchGroup.visible = false;
                status.innerText = 'Show your wrist';
                return;
            }

            isHandDetected = true;
            watchGroup.visible = true;
            status.innerText = 'Tracking';

            const lm = results.multiHandLandmarks[0];

            // Key Landmarks
            const wrist = lm[0];       // Center of wrist
            const indexMCP = lm[5];    // Base of index finger
            const middleMCP = lm[9];   // Base of middle finger (Best for arm direction)
            const pinkyMCP = lm[17];   // Base of pinky

            /* ---------- 1. POSITION & DEPTH ---------- */
            // Calculate hand width in 2D to estimate Depth (Z)
            const p1 = new THREE.Vector2(indexMCP.x, indexMCP.y);
            const p2 = new THREE.Vector2(pinkyMCP.x, pinkyMCP.y);
            const handWidth2D = p1.distanceTo(p2);

            // Estimate depth: The larger the hand is on screen, the smaller the Z value.
            // This magic number (0.8) might need tweaking depending on FOV
            const estimatedDepth = 0.8 / handWidth2D; 

            // Convert normalized coordinates (0-1) to NDC (-1 to 1)
            const ndc = new THREE.Vector3(
                (wrist.x - 0.5) * -2, // Invert X because camera is mirrored
                -(wrist.y - 0.5) * 2,
                0.5 // Arbitrary unproject depth
            );

            // Unproject allows us to get a ray direction
            ndc.unproject(camera);
            ndc.sub(camera.position).normalize(); // Direction vector from camera
            
            // Place object along that ray at estimated depth
            const finalPos = camera.position.clone().add(ndc.multiplyScalar(estimatedDepth));
            targetPos.copy(finalPos);

            /* ---------- 2. ORIENTATION (BASIS VECTORS) ---------- */
            // We construct a matrix based on the hand's natural axes
            
            // Y-Axis: Arm Direction (Wrist -> Middle Finger)
            const vWrist = new THREE.Vector3(wrist.x, wrist.y, wrist.z);
            const vMiddle = new THREE.Vector3(middleMCP.x, middleMCP.y, middleMCP.z);
            const yAxis = new THREE.Vector3().subVectors(vMiddle, vWrist).normalize();

            // X-Axis: Across Hand (Index -> Pinky)
            const vIndex = new THREE.Vector3(indexMCP.x, indexMCP.y, indexMCP.z);
            const vPinky = new THREE.Vector3(pinkyMCP.x, pinkyMCP.y, pinkyMCP.z);
            const xAxis = new THREE.Vector3().subVectors(vPinky, vIndex).normalize();

            // Z-Axis: Surface Normal (Face of the watch) - Cross Product
            // Note: We might need to negate this depending on coordinate system
            const zAxis = new THREE.Vector3().crossVectors(xAxis, yAxis).normalize();

            // Re-orthogonalize X to ensure perfect 90 degree angles
            xAxis.crossVectors(yAxis, zAxis).normalize();

            // Create Rotation Matrix
            const matrix = new THREE.Matrix4().makeBasis(xAxis, yAxis.negate(), zAxis);
            targetQuat.setFromRotationMatrix(matrix);

            // --- FIX 2: WRAP AROUND (Visual Offset) ---
            // Move the watch slightly 'up' the Z-axis (normal) so it sits ON the skin
            const zOffsetVec = zAxis.clone().multiplyScalar(CONFIG.zOffset);
            targetPos.add(zOffsetVec);

            /* ---------- 3. SCALE ---------- */
            // Scale based on hand size
            const dist = Math.hypot(indexMCP.x - pinkyMCP.x, indexMCP.y - pinkyMCP.y);
            const s = dist * CONFIG.scaleMultiplier * estimatedDepth; // Scale needs to grow with depth
            targetScale.setScalar(s);
        });

        /* ---------------- ANIMATION LOOP ---------------- */
        function animate() {
            requestAnimationFrame(animate);

            if (isHandDetected) {
                // Smooth interpolation (Lerp/Slerp) to reduce jitter
                watchGroup.position.lerp(targetPos, CONFIG.smoothFactor);
                watchGroup.quaternion.slerp(targetQuat, CONFIG.smoothFactor);
                watchGroup.scale.lerp(targetScale, CONFIG.smoothFactor);
            }

            renderer.render(scene, camera);
        }
        
        /* ---------------- CAMERA SETUP ---------------- */
        const cameraUtils = new Camera(video, {
            onFrame: async () => {
                await hands.send({ image: video });
            },
            width: 1280,
            height: 720
        });
        cameraUtils.start();

        /* ---------------- RESIZE HANDLER ---------------- */
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

    </script>
</body>
</html>