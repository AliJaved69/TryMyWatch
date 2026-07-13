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
    <title>Watch VTO - {{ $watch->name }}</title>
    
    <!-- Google Fonts & FontAwesome -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --primary: #0B0C10;
            --secondary: #1F2833;
            --accent: #F1E5AC;
            --accent-light: #F9F1D2;
            --text: #C5C6C7;
            --text-bright: #FFFFFF;
            --text-secondary: #9BA4B4;
            --glass: rgba(31, 40, 51, 0.7);
        }

        body { margin: 0; overflow: hidden; background: #000; font-family: 'Outfit', sans-serif; }
        #video {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transform: scaleX(-1); /* Mirror effect */
            z-index: 0; opacity: 0; pointer-events: none; /* Hidden, we render to texture or background */
        }
        #three-canvas {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1;
        }
        #status {
            position: absolute; top: 20px; left: 20px;
            color: var(--accent); font-family: 'Outfit', sans-serif; font-size: 16px; z-index: 2;
            background: var(--glass); padding: 8px 15px; border-radius: 8px;
            border: 1px solid rgba(241, 229, 172, 0.15); backdrop-filter: blur(5px);
        }

        /* Loading Overlay Styles */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at center, #1F2833 0%, #0B0C10 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            transition: opacity 0.8s cubic-bezier(0.25, 1, 0.5, 1);
            font-family: 'Outfit', sans-serif;
        }

        #loading-overlay.fade-out {
            opacity: 0;
            pointer-events: none;
        }

        .loader-content {
            text-align: center;
            max-width: 450px;
            width: 90%;
            padding: 30px;
            background: rgba(11, 12, 16, 0.4);
            border-radius: 24px;
            border: 1px solid rgba(241, 229, 172, 0.15);
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .watch-skeleton {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto 25px auto;
            border: 3px solid var(--accent);
            border-radius: 50%;
            box-shadow: 0 0 30px rgba(241, 229, 172, 0.15), inset 0 0 15px rgba(241, 229, 172, 0.05);
            background: rgba(11, 12, 16, 0.6);
        }

        /* Watch ticks */
        .watch-skeleton::before {
            content: '';
            position: absolute;
            top: 5px;
            bottom: 5px;
            left: 50%;
            width: 2px;
            background: linear-gradient(to bottom, var(--accent) 8px, transparent 8px, transparent calc(100% - 8px), var(--accent) calc(100% - 8px));
            transform: translateX(-50%);
        }

        .watch-skeleton::after {
            content: '';
            position: absolute;
            left: 5px;
            right: 5px;
            top: 50%;
            height: 2px;
            background: linear-gradient(to right, var(--accent) 8px, transparent 8px, transparent calc(100% - 8px), var(--accent) calc(100% - 8px));
            transform: translateY(-50%);
        }

        .watch-skeleton-hand {
            position: absolute;
            background: var(--accent-light);
            border-radius: 4px;
            transform-origin: bottom center;
            left: 50%;
            bottom: 50%;
            box-shadow: 0 0 5px rgba(249, 241, 210, 0.5);
        }

        .watch-skeleton-hand.hour {
            width: 4px;
            height: 32px;
            margin-left: -2px;
            animation: spin-hand 12s linear infinite;
        }

        .watch-skeleton-hand.minute {
            width: 2.5px;
            height: 48px;
            margin-left: -1.25px;
            animation: spin-hand 1.5s linear infinite;
        }

        .center-pin {
            position: absolute;
            width: 10px;
            height: 10px;
            background: var(--accent);
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-shadow: 0 0 8px var(--accent);
            z-index: 5;
        }

        @keyframes spin-hand {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .brand-title {
            color: #FFFFFF;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 4px;
            margin: 0 0 5px 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        }

        .brand-subtitle {
            color: var(--accent);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 1px;
            margin: 0 0 35px 0;
            opacity: 0.9;
        }

        .progress-bar-wrapper {
            width: 100%;
            height: 6px;
            background: rgba(197, 198, 199, 0.15);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .progress-bar-fill {
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, var(--accent) 0%, var(--accent-light) 100%);
            border-radius: 3px;
            transition: width 0.3s ease-out;
            box-shadow: 0 0 10px rgba(241, 229, 172, 0.6);
        }

        .status-text {
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 8px;
            min-height: 20px;
            letter-spacing: 0.5px;
        }

        .percentage-text {
            color: var(--accent-light);
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.5px;
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

    <video id="video" autoplay playsinline muted></video>
    <canvas id="three-canvas"></canvas>
    <div id="status">Initializing...</div>

    <!-- Premium Loading Overlay -->
    <div id="loading-overlay">
        <div class="loader-content">
            <div class="watch-skeleton">
                <div class="watch-skeleton-hand hour"></div>
                <div class="watch-skeleton-hand minute"></div>
                <div class="center-pin"></div>
            </div>
            <h2 class="brand-title">TRY MY WATCH</h2>
            <p class="brand-subtitle">Trying On: {{ $watch->name }}</p>
            
            <div class="progress-bar-wrapper">
                <div class="progress-bar-fill" id="progress-fill" style="width: 0%"></div>
            </div>
            
            <div class="status-text" id="status-text">Initializing Camera & Assets...</div>
            <div class="percentage-text" id="percentage-text">0%</div>
            <div id="retry-button-container" style="display: none; margin-top: 20px;">
                <button onclick="window.location.reload()" style="background: var(--accent); color: var(--primary); border: none; padding: 10px 20px; border-radius: 20px; font-family: 'Outfit', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 0 15px rgba(241, 229, 172, 0.4);">
                    <i class="fas fa-redo-alt" style="margin-right: 8px;"></i>Try Again
                </button>
            </div>
        </div>
    </div>

    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
        import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

        // CONFIGURATION
        const CONFIG = {
            // Replace with your GLB/GLTF URL
            modelUrl: "{{ filter_var($watch->glb_model, FILTER_VALIDATE_URL) ? $watch->glb_model : '/storage/' . $watch->glb_model }}",
            
            scaleMultiplier: 5.0, // Adjust this to make watch bigger/smaller
            zOffset: 0.2, // Pushes watch 'out' of the wrist (Visual wrap fix)
            smoothFactor: 0.15 // 0.1 = slow/smooth, 0.9 = fast/jittery
        };

        const video = document.getElementById('video');
        const canvas = document.getElementById('three-canvas');
        const status = document.getElementById('status');

        /* ---------------- LOADING STATE MANAGEMENT ---------------- */
        let isModelLoaded = false;
        let isCameraReady = false;

        const progressFill = document.getElementById('progress-fill');
        const statusText = document.getElementById('status-text');
        const percentageText = document.getElementById('percentage-text');
        const overlay = document.getElementById('loading-overlay');
        const retryContainer = document.getElementById('retry-button-container');

        function updateProgress(percent) {
            if (progressFill) progressFill.style.width = percent + '%';
            if (percentageText) percentageText.innerText = percent + '%';
        }

        function checkInitComplete() {
            if (isModelLoaded && isCameraReady) {
                if (overlay) {
                    overlay.classList.add('fade-out');
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 800);
                }
            }
        }

        // Safety timeout (8 seconds) to prevent permanent loading loop if camera permissions hang
        setTimeout(() => {
            if (!isCameraReady && isModelLoaded) {
                console.warn("Camera ready state timed out, resolving to start session.");
                isCameraReady = true;
                checkInitComplete();
            }
        }, 8000);

        // Listen for video playing to confirm camera stream is active
        video.addEventListener('playing', () => {
            console.log("Camera feed active.");
            isCameraReady = true;
            if (statusText && !isModelLoaded) {
                statusText.innerText = "Camera ready. Downloading 3D watch assets...";
            }
            checkInitComplete();
        });

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

        // Create a cylindrical occluder representing the wrist (hides strap parts that go behind wrist)
        const occluderGeom = new THREE.CylinderGeometry(0.43, 0.43, 1.5, 32);
        const occluderMat = new THREE.MeshBasicMaterial({ colorWrite: false });
        const occluder = new THREE.Mesh(occluderGeom, occluderMat);
        occluder.position.set(0, 0, -0.42);
        watchGroup.add(occluder);
        
        let watchModel = null;
        
        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');

        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);

        status.innerText = 'Loading model...';
        if (statusText) statusText.innerText = 'Downloading 3D watch assets...';

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
                watchModel.rotation.z = -Math.PI / 2; // Tilt 90 degrees Right
                
                watchGroup.add(watchModel);
                watchGroup.visible = false;

                status.innerText = 'Point camera at your wrist';
                if (statusText) statusText.innerText = 'Assets loaded! Calibrating wrist space...';
                isModelLoaded = true;
                updateProgress(100);
                setTimeout(checkInitComplete, 400);
            },
            (xhr) => {
                if (xhr.lengthComputable) {
                    const percentComplete = Math.round((xhr.loaded / xhr.total) * 100);
                    updateProgress(percentComplete);
                    if (statusText) statusText.innerText = `Downloading 3D model: ${percentComplete}%`;
                } else {
                    const loadedMB = (xhr.loaded / (1024 * 1024)).toFixed(1);
                    if (statusText) statusText.innerText = `Downloading 3D model: ${loadedMB} MB loaded`;
                    const simulatedPercent = Math.min(Math.round(xhr.loaded / 150000), 95);
                    updateProgress(simulatedPercent);
                }
            },
            (err) => {
                console.error(err);
                status.innerText = 'Error loading model';
                if (statusText) statusText.innerText = 'Failed to load the 3D model.';
                if (retryContainer) retryContainer.style.display = 'block';
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
            width: 640,
            height: 480
        });
        cameraUtils.start();

        // Start the Three.js rendering loop
        animate();

        /* ---------------- RESIZE HANDLER ---------------- */
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

    </script>
</body>
</html>