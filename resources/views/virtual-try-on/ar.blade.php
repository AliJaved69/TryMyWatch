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
        z-index: 0; display: none;
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

    <!-- The mediapipe/video setup -->
    <video id="video" playsinline></video>
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
    
    status.innerText = 'Loading 3D Model...';

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
    }

    if (isObj) {
        const loader = new OBJLoader();
        loader.load(
            CONFIG.modelUrl,
            (obj) => processLoadedModel(obj, 'OBJ'),
            undefined,
            (err) => {
                console.error(err);
                status.innerText = 'Error loading OBJ model (Check console)';
            }
        );
    } else {
        const loader = new GLTFLoader();
        loader.load(
            CONFIG.modelUrl,
            (gltf) => processLoadedModel(gltf.scene, 'GLTF'),
            undefined,
            (err) => {
                console.error(err);
                status.innerText = 'Error loading GLB/GLTF model (Check console)';
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
        width: 1280, height: 720
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
