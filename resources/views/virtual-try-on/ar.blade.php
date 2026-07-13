@extends('layouts.app')

@section('title', 'AR Try On - ' . $product->title)

@section('content')
<style>
    .ar-container {
        position: relative;
        width: 100%;
        height: max(100vh - 80px, 600px);
        background: #000;
        overflow: hidden;
        margin-top: 80px; /* offset for navbar if fixed, or just to push it down */
        border-radius: 0;
    }
    #video {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        object-fit: cover; transform: scaleX(-1);
        z-index: 0; opacity: 0; pointer-events: none;
    }
    #three-canvas {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1;
    }
    #ar-ui {
        position: absolute; top: 20px; left: 20px; z-index: 20; color: var(--text-bright);
        background: var(--glass); backdrop-filter: blur(10px); 
        padding: 20px; border-radius: 12px; font-family: inherit;
        border: 1px solid rgba(241, 229, 172, 0.2); width: 280px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }
    .tuning-row { margin-bottom: 15px; }
    .tuning-row label { display: block; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--accent); margin-bottom: 6px; }
    .tuning-row input { width: 100%; accent-color: var(--accent); cursor: pointer; }
    .tuning-val { float: right; font-family: monospace; color: white; opacity: 0.7; }

    /* Loading Overlay Styles */
    #loading-overlay {
        position: absolute;
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

<div class="ar-container d-flex justify-content-center align-items-center">
    <div id="ar-ui">
        <h4 class="mb-1">{{ $product->title }}</h4>
        <div id="status" class="mb-3 badge bg-onyx text-accent border border-silver-dim">Initializing AR...</div>
        
        <div class="tuning-panel pt-3 border-top border-silver-dim">
            <div class="tuning-row">
                <label>Rotation X <span class="tuning-val" id="val-rx">0</span></label>
                <input type="range" id="tune-rx" min="-180" max="180" value="0">
            </div>
            <div class="tuning-row">
                <label>Rotation Y <span class="tuning-val" id="val-ry">0</span></label>
                <input type="range" id="tune-ry" min="-180" max="180" value="0">
            </div>
            <div class="tuning-row">
                <label>Rotation Z <span class="tuning-val" id="val-rz">0</span></label>
                <input type="range" id="tune-rz" min="-180" max="180" value="-90">
            </div>
            <div class="tuning-row">
                <label>Scale <span class="tuning-val" id="val-scale">5.0</span></label>
                <input type="range" id="tune-scale" min="1" max="20" step="0.5" value="5">
            </div>
            <div class="tuning-row">
                <label>Z-Offset <span class="tuning-val" id="val-z">0.2</span></label>
                <input type="range" id="tune-z" min="-1" max="1" step="0.05" value="0.2">
            </div>
        </div>

        <div class="d-grid mt-3">
            <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-custom text-white btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Back to Product
            </a>
        </div>
    </div>

    <!-- Premium Loading Overlay -->
    <div id="loading-overlay">
        <div class="loader-content">
            <div class="watch-skeleton">
                <div class="watch-skeleton-hand hour"></div>
                <div class="watch-skeleton-hand minute"></div>
                <div class="center-pin"></div>
            </div>
            <h2 class="brand-title">TRY MY WATCH</h2>
            <p class="brand-subtitle">Trying On: {{ $product->title }}</p>
            
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

    <!-- The mediapipe/video setup -->
    <video id="video" autoplay playsinline muted></video>
    <canvas id="three-canvas"></canvas>
</div>
@endsection

@section('scripts')
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

<script type="module">
    import * as THREE from 'three';
    import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
    import { OBJLoader } from 'three/addons/loaders/OBJLoader.js';
    import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

    // CONFIGURATION
    const CONFIG = {
        modelUrl: "{{ $product->model_3d }}", 
        scaleMultiplier: 5.0,
        zOffset: 0.2,
        smoothFactor: 0.15,
        rotationOffset: new THREE.Euler(0, 0, -Math.PI / 2) // Default orientation fix
    };

    // TUNING HANDLERS
    const tuning = {
        rx: document.getElementById('tune-rx'),
        ry: document.getElementById('tune-ry'),
        rz: document.getElementById('tune-rz'),
        s: document.getElementById('tune-scale'),
        z: document.getElementById('tune-z')
    };

    function updateTuning() {
        CONFIG.rotationOffset.set(
            THREE.MathUtils.degToRad(parseFloat(tuning.rx.value)),
            THREE.MathUtils.degToRad(parseFloat(tuning.ry.value)),
            THREE.MathUtils.degToRad(parseFloat(tuning.rz.value))
        );
        CONFIG.scaleMultiplier = parseFloat(tuning.s.value);
        CONFIG.zOffset = parseFloat(tuning.z.value);

        document.getElementById('val-rx').innerText = tuning.rx.value;
        document.getElementById('val-ry').innerText = tuning.ry.value;
        document.getElementById('val-rz').innerText = tuning.rz.value;
        document.getElementById('val-scale').innerText = tuning.s.value;
        document.getElementById('val-z').innerText = tuning.z.value;
    }

    Object.values(tuning).forEach(input => input.addEventListener('input', updateTuning));
    updateTuning();

    const container = document.querySelector('.ar-container');
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

    let width = container.clientWidth;
    let height = container.clientHeight;

    /* ---------------- SCENE SETUP ---------------- */
    const scene = new THREE.Scene();
    const videoTexture = new THREE.VideoTexture(video);
    scene.background = videoTexture;

    const camera = new THREE.PerspectiveCamera(50, width / height, 0.1, 100);
    camera.position.z = 10;

    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(window.devicePixelRatio);

    /* ---------------- LIGHTING ---------------- */
    const hemiLight = new THREE.HemisphereLight(0xffffff, 0x444444, 2.0);
    scene.add(hemiLight);
    const dirLight = new THREE.DirectionalLight(0xffffff, 2.0);
    dirLight.position.set(0, 5, 5);
    scene.add(dirLight);

    const watchGroup = new THREE.Group();
    scene.add(watchGroup);

    // Create a cylindrical occluder representing the wrist (hides strap parts that go behind wrist)
    const occluderGeom = new THREE.CylinderGeometry(0.43, 0.43, 1.5, 32);
    const occluderMat = new THREE.MeshBasicMaterial({ colorWrite: false });
    const occluder = new THREE.Mesh(occluderGeom, occluderMat);
    occluder.position.set(0, 0, -0.42);
    watchGroup.add(occluder);
    
    status.innerText = 'Loading 3D Model...';
    if (statusText) statusText.innerText = 'Downloading 3D watch assets...';

    const isObj = CONFIG.modelUrl.toLowerCase().includes('.obj');
    console.log("Model URL loaded inside AR module:", CONFIG.modelUrl);
    console.log("Evaluated isObj as:", isObj);

    function processLoadedModel(model, loaderType) {
        // 1. Assign Default Material (Crucial for .obj without .mtl)
        model.traverse((child) => {
            if (child.isMesh) {
                // If it's an OBJ, enforce a material so it's not invisible/black
                if (loaderType === 'OBJ' || !child.material) {
                    child.material = new THREE.MeshStandardMaterial({
                        color: 0xe0e0e0,
                        metalness: 0.5,
                        roughness: 0.5
                    });
                }
            }
        });

        // 2. Normalize Scale to exactly 1 unit
        const box = new THREE.Box3().setFromObject(model);
        const size = box.getSize(new THREE.Vector3());
        const maxDim = Math.max(size.x, size.y, size.z);
        
        if (maxDim > 0) {
            model.scale.setScalar(1.0 / maxDim);
        }

        // 3. Re-calculate bounding box after scaling to center perfectly
        const newBox = new THREE.Box3().setFromObject(model);
        const center = newBox.getCenter(new THREE.Vector3());
        model.position.sub(center);
        
        // 4. Adjust Default Rotation is now handled in CONFIG.rotationOffset in the loop
        
        watchGroup.add(model);
        watchGroup.visible = false;
        status.innerText = 'Show your wrist to camera';

        isModelLoaded = true;
        updateProgress(100);
        if (statusText) statusText.innerText = 'Assets loaded! Calibrating wrist space...';
        setTimeout(checkInitComplete, 400);
    }

    if (isObj) {
        const loader = new OBJLoader();
        loader.load(
            CONFIG.modelUrl,
            (obj) => processLoadedModel(obj, 'OBJ'),
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
    } else {
        const dracoLoader = new DRACOLoader();
        dracoLoader.setDecoderPath('https://www.gstatic.com/draco/versioned/decoders/1.5.6/');

        const loader = new GLTFLoader();
        loader.setDRACOLoader(dracoLoader);
        loader.load(
            CONFIG.modelUrl,
            (gltf) => processLoadedModel(gltf.scene, 'GLTF'),
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
    }

    /* ---------------- MEDIAPIPE LOGIC ---------------- */
    const hands = new Hands({ locateFile: (file) => 'https://cdn.jsdelivr.net/npm/@mediapipe/hands/' + file });
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
        if (!watchGroup) return;

        if (!results.multiHandLandmarks?.length) {
            isHandDetected = false;
            watchGroup.visible = false;
            status.innerText = 'Show your wrist';
            return;
        }

        isHandDetected = true;
        watchGroup.visible = true;
        status.innerText = 'Tracking...';

        const lm = results.multiHandLandmarks[0];
        const wrist = lm[0];
        const indexMCP = lm[5];
        const middleMCP = lm[9];
        const pinkyMCP = lm[17];

        // 1. Position & Depth
        const p1 = new THREE.Vector2(indexMCP.x, indexMCP.y);
        const p2 = new THREE.Vector2(pinkyMCP.x, pinkyMCP.y);
        const handWidth2D = p1.distanceTo(p2);
        const estimatedDepth = 0.8 / handWidth2D; 

        const ndc = new THREE.Vector3((wrist.x - 0.5) * -2, -(wrist.y - 0.5) * 2, 0.5);
        ndc.unproject(camera);
        ndc.sub(camera.position).normalize();
        const finalPos = camera.position.clone().add(ndc.multiplyScalar(estimatedDepth));
        targetPos.copy(finalPos);

        // 2. Orientation
        const vWrist = new THREE.Vector3(wrist.x, wrist.y, wrist.z);
        const vMiddle = new THREE.Vector3(middleMCP.x, middleMCP.y, middleMCP.z);
        const yAxis = new THREE.Vector3().subVectors(vMiddle, vWrist).normalize();
        
        const vIndex = new THREE.Vector3(indexMCP.x, indexMCP.y, indexMCP.z);
        const vPinky = new THREE.Vector3(pinkyMCP.x, pinkyMCP.y, pinkyMCP.z);
        const xAxis = new THREE.Vector3().subVectors(vPinky, vIndex).normalize();
        
        const zAxis = new THREE.Vector3().crossVectors(xAxis, yAxis).normalize();
        xAxis.crossVectors(yAxis, zAxis).normalize();

        const matrix = new THREE.Matrix4().makeBasis(xAxis, yAxis.negate(), zAxis);
        targetQuat.setFromRotationMatrix(matrix);

        // Apply Custom Rotation Tuning
        const tuneQuat = new THREE.Quaternion().setFromEuler(CONFIG.rotationOffset);
        targetQuat.multiply(tuneQuat);

        // Z Adjustment
        const zOffsetVec = zAxis.clone().multiplyScalar(CONFIG.zOffset);
        targetPos.add(zOffsetVec);

        // 3. Scale
        const dist = Math.hypot(indexMCP.x - pinkyMCP.x, indexMCP.y - pinkyMCP.y);
        const s = dist * CONFIG.scaleMultiplier * estimatedDepth;
        targetScale.setScalar(s);
    });

    /* ---------------- ANIMATION LOOP ---------------- */
    function animate() {
        requestAnimationFrame(animate);
        if (isHandDetected) {
            watchGroup.position.lerp(targetPos, CONFIG.smoothFactor);
            watchGroup.quaternion.slerp(targetQuat, CONFIG.smoothFactor);
            watchGroup.scale.lerp(targetScale, CONFIG.smoothFactor);
        }
        renderer.render(scene, camera);
    }
    animate(); // Start animation loop
    
    /* ---------------- CAMERA SETUP ---------------- */
    const cameraUtils = new Camera(video, {
        onFrame: async () => { await hands.send({ image: video }); },
        width: 640, height: 480
    });
    cameraUtils.start();

    window.addEventListener('resize', () => {
        width = container.clientWidth;
        height = container.clientHeight;
        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });
</script>
@endsection
