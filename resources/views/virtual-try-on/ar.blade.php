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
            margin-top: 80px;
            /* offset for navbar if fixed, or just to push it down */
            border-radius: 0;
        }

        #video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scaleX(-1);
            z-index: 0;
            opacity: 0;
            pointer-events: none;
        }

        #three-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        #ar-ui {
            position: absolute;
            top: 20px;
            left: 20px;
            z-index: 20;
            color: var(--text-bright);
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 12px;
            font-family: inherit;
            border: 1px solid rgba(241, 229, 172, 0.2);
            width: 320px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.3s ease;
        }

        #ar-ui.hidden-ui {
            transform: translateX(-340px);
            opacity: 0;
            pointer-events: none;
        }

        .btn-toggle-ui {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: var(--glass);
            border: 1px solid rgba(241, 229, 172, 0.3);
            color: var(--accent);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            transition: background 0.3s, color 0.3s;
        }

        .btn-toggle-ui:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .tuning-row {
            margin-bottom: 15px;
        }

        .tuning-row label {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--accent);
            margin-bottom: 6px;
        }

        .tuning-row input {
            width: 100%;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .tuning-val {
            font-family: monospace;
            color: white;
            opacity: 0.7;
            font-size: 0.85rem;
        }

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
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
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
        <!-- UI Toggle Button -->
        <button id="toggle-ui-btn" class="btn-toggle-ui" title="Toggle Controls">
            <i class="fas fa-sliders-h"></i>
        </button>

        <div id="ar-ui">
            <h4 class="mb-1">{{ $product->title }}</h4>
            <div id="status" class="mb-3 badge bg-onyx text-accent border border-silver-dim">Initializing AR...</div>

            <div class="tuning-panel pt-3 border-top border-silver-dim">
                <div class="tuning-row">
                    <label><span>Rotation X</span> <span class="tuning-val" id="val-rx">90</span></label>
                    <input type="range" id="tune-rx" min="-180" max="180" value="90">
                </div>
                <div class="tuning-row">
                    <label><span>Rotation Y</span> <span class="tuning-val" id="val-ry">0</span></label>
                    <input type="range" id="tune-ry" min="-180" max="180" value="0">
                </div>
                <div class="tuning-row">
                    <label><span>Rotation Z</span> <span class="tuning-val" id="val-rz">-90</span></label>
                    <input type="range" id="tune-rz" min="-180" max="180" value="-90">
                </div>
                <div class="tuning-row">
                    <label><span>Scale</span> <span class="tuning-val" id="val-scale">12</span></label>
                    <input type="range" id="tune-scale" min="0.5" max="50" step="0.5" value="12">
                </div>
                <div class="tuning-row">
                    <label><span>X-Offset (Side)</span> <span class="tuning-val" id="val-x">0</span></label>
                    <input type="range" id="tune-x" min="-0.5" max="0.5" step="0.005" value="0">
                </div>
                <div class="tuning-row">
                    <label><span>Y-Offset (Arm)</span> <span class="tuning-val" id="val-y">-0.15</span></label>
                    <input type="range" id="tune-y" min="-0.5" max="0.5" step="0.005" value="-0.15">
                </div>
                <div class="tuning-row">
                    <label><span>Z-Offset (Depth)</span> <span class="tuning-val" id="val-z">-0.2</span></label>
                    <input type="range" id="tune-z" min="-0.5" max="0.5" step="0.005" value="-0.2">
                </div>
                <div class="tuning-row">
                    <label><span>Smoothing (minCutoff)</span> <span class="tuning-val" id="val-mincutoff">1.0</span></label>
                    <input type="range" id="tune-mincutoff" min="0.1" max="5.0" step="0.1" value="1.0">
                </div>
                <div class="tuning-row">
                    <label><span>Speed Adapt (beta)</span> <span class="tuning-val" id="val-beta">0.007</span></label>
                    <input type="range" id="tune-beta" min="0.0" max="0.1" step="0.001" value="0.007">
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
                    <button onclick="window.location.reload()"
                        style="background: var(--accent); color: var(--primary); border: none; padding: 10px 20px; border-radius: 20px; font-family: 'Outfit', sans-serif; font-weight: 600; cursor: pointer; box-shadow: 0 0 15px rgba(241, 229, 172, 0.4);">
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
        import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

        // CONFIGURATION
        const CONFIG = {
            modelUrl: "{{ str_starts_with($product->model_3d, 'http') ? $product->model_3d : (str_starts_with(ltrim($product->model_3d, '/'), 'storage/') ? asset(ltrim($product->model_3d, '/')) : asset('storage/' . ltrim($product->model_3d, '/'))) }}",
            scaleMultiplier: 12.0,
            xOffset: 0,
            yOffset: -0.15,
            zOffset: -0.2,
            // Animation loop lerp/slerp factors (downstream of One Euro)
            smoothFactorPosition: 0.25,
            smoothFactorRotation: 0.15,
            smoothFactorScale: 0.20,
            // One Euro Filter parameters
            oneEuroMinCutoff: 1.0,
            oneEuroBeta: 0.007,
            oneEuroDCutoff: 1.0,
            rotationOffset: new THREE.Euler(THREE.MathUtils.degToRad(90), 0, THREE.MathUtils.degToRad(-90))
        };

        // TUNING HANDLERS
        const tuning = {
            rx: document.getElementById('tune-rx'),
            ry: document.getElementById('tune-ry'),
            rz: document.getElementById('tune-rz'),
            s: document.getElementById('tune-scale'),
            x: document.getElementById('tune-x'),
            y: document.getElementById('tune-y'),
            z: document.getElementById('tune-z'),
            mincutoff: document.getElementById('tune-mincutoff'),
            beta: document.getElementById('tune-beta')
        };

        function updateTuning() {
            CONFIG.rotationOffset.set(
                THREE.MathUtils.degToRad(parseFloat(tuning.rx.value)),
                THREE.MathUtils.degToRad(parseFloat(tuning.ry.value)),
                THREE.MathUtils.degToRad(parseFloat(tuning.rz.value))
            );
            CONFIG.scaleMultiplier = parseFloat(tuning.s.value);
            CONFIG.xOffset = parseFloat(tuning.x.value);
            CONFIG.yOffset = parseFloat(tuning.y.value);
            CONFIG.zOffset = parseFloat(tuning.z.value);
            CONFIG.oneEuroMinCutoff = parseFloat(tuning.mincutoff.value);
            CONFIG.oneEuroBeta = parseFloat(tuning.beta.value);

            document.getElementById('val-rx').innerText = tuning.rx.value;
            document.getElementById('val-ry').innerText = tuning.ry.value;
            document.getElementById('val-rz').innerText = tuning.rz.value;
            document.getElementById('val-scale').innerText = tuning.s.value;
            document.getElementById('val-x').innerText = tuning.x.value;
            document.getElementById('val-y').innerText = tuning.y.value;
            document.getElementById('val-z').innerText = tuning.z.value;
            document.getElementById('val-mincutoff').innerText = tuning.mincutoff.value;
            document.getElementById('val-beta').innerText = tuning.beta.value;
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

            // Auto-detect mirroring based on camera facingMode
            if (video.srcObject) {
                const track = video.srcObject.getVideoTracks()[0];
                if (track) {
                    const settings = track.getSettings();
                    if (settings && settings.facingMode === 'environment') {
                        isMirrored = false;
                        console.log("Back camera detected. Mirroring disabled.");
                    } else {
                        isMirrored = true;
                        console.log("Front camera/webcam detected. Mirroring enabled.");
                    }
                }
            }

            updateCameraAndBackground();

            if (statusText && !isModelLoaded) {
                statusText.innerText = "Camera ready. Downloading 3D watch assets...";
            }
            checkInitComplete();
        });

        let isMirrored = true;
        const PHYSICAL_FOV = 50; // Approximated vertical FOV of the webcam

        function updateCameraAndBackground() {
            if (!video.videoWidth || !video.videoHeight) return;

            width = container.clientWidth;
            height = container.clientHeight;

            const videoAspect = video.videoWidth / video.videoHeight;
            const canvasAspect = width / height;

            // 1. Update Video Texture for "object-fit: cover"
            videoTexture.matrixAutoUpdate = false;

            let scaleX = 1;
            let scaleY = 1;

            if (canvasAspect < videoAspect) {
                // Portrait (mobile): crop left/right
                scaleX = canvasAspect / videoAspect;
            } else {
                // Landscape (laptop): crop top/bottom
                scaleY = videoAspect / canvasAspect;
            }

            // Apply mirroring to scaleX if isMirrored is true
            const textureScaleX = isMirrored ? -scaleX : scaleX;

            // setUvTransform(tx, ty, sx, sy, rotation, cx, cy)
            videoTexture.matrix.setUvTransform(0, 0, textureScaleX, scaleY, 0, 0.5, 0.5);

            // 2. Adjust Camera projection matrix and FOV
            camera.aspect = canvasAspect;
            if (canvasAspect < videoAspect) {
                // Portrait: height is not cropped, vertical FOV matches physical camera vertical FOV
                camera.fov = PHYSICAL_FOV;
            } else {
                // Landscape: height is cropped, vertical FOV must be increased to match the canvas aspect ratio
                const radAngle = 2 * Math.atan(Math.tan(THREE.MathUtils.degToRad(PHYSICAL_FOV) / 2) * (canvasAspect / videoAspect));
                camera.fov = THREE.MathUtils.radToDeg(radAngle);
            }
            camera.updateProjectionMatrix();

            // 3. Update Renderer size
            renderer.setSize(width, height);
        }

        let width = container.clientWidth;
        let height = container.clientHeight;

        /* ---------------- SCENE SETUP ---------------- */
        const scene = new THREE.Scene();
        const videoTexture = new THREE.VideoTexture(video);
        scene.background = videoTexture;

        const camera = new THREE.PerspectiveCamera(PHYSICAL_FOV, width / height, 0.1, 100);
        camera.position.z = 10;

        const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
        renderer.setSize(width, height);
        renderer.setPixelRatio(window.devicePixelRatio);
        // Photorealistic tone mapping — maps HDR lighting values to screen colors
        // the way a real camera sensor would, preventing washed-out highlights
        renderer.toneMapping = THREE.ACESFilmicToneMapping;
        renderer.toneMappingExposure = 1.0;
        renderer.outputColorSpace = THREE.SRGBColorSpace;

        // Environment Map for photorealistic reflections on metallic surfaces
        const pmremGenerator = new THREE.PMREMGenerator(renderer);
        scene.environment = pmremGenerator.fromScene(new RoomEnvironment(), 0.04).texture;

        /* ---------------- LIGHTING ---------------- */
        // Key light — warm directional from upper-right to simulate indoor/outdoor light
        const keyLight = new THREE.DirectionalLight(0xfff5e6, 2.2);
        keyLight.position.set(2, 4, 5);
        scene.add(keyLight);

        // Fill light — soft hemisphere from below to simulate skin light bounce
        const hemiLight = new THREE.HemisphereLight(
            0xffffff,  // sky color (cool white)
            0xd4a574,  // ground color (warm skin-tone bounce)
            1.2
        );
        scene.add(hemiLight);

        // Rim light — subtle backlight to separate watch from wrist
        const rimLight = new THREE.DirectionalLight(0xc8d8ff, 0.6);
        rimLight.position.set(-3, 1, -4);
        scene.add(rimLight);

        // Ambient fill — very subtle to avoid washing out
        const ambientLight = new THREE.AmbientLight(0xffffff, 0.3);
        scene.add(ambientLight);

        const watchGroup = new THREE.Group();
        scene.add(watchGroup);

        const modelGroup = new THREE.Group();
        watchGroup.add(modelGroup);

        // --- CONTACT SHADOW ---
        // A soft, dark ellipse that sits just below the watch case on the skin.
        // Uses NormalBlending and alpha so it doesn't render as a solid black box.
        const shadowGeom = new THREE.PlaneGeometry(1.2, 1.2);
        const shadowCanvas = document.createElement('canvas');
        shadowCanvas.width = 128;
        shadowCanvas.height = 128;
        const shadowCtx = shadowCanvas.getContext('2d');
        const grad = shadowCtx.createRadialGradient(64, 64, 0, 64, 64, 64);
        grad.addColorStop(0, 'rgba(0, 0, 0, 0.6)');
        grad.addColorStop(0.4, 'rgba(0, 0, 0, 0.2)');
        grad.addColorStop(1, 'rgba(0, 0, 0, 0)');
        shadowCtx.fillStyle = grad;
        shadowCtx.fillRect(0, 0, 128, 128);
        const shadowTex = new THREE.CanvasTexture(shadowCanvas);
        const shadowMat = new THREE.MeshBasicMaterial({
            map: shadowTex,
            transparent: true,
            depthWrite: false,
            toneMapped: false // Prevents ACES tone mapping from turning black transparent pixels into grey blocks
        });
        const contactShadow = new THREE.Mesh(shadowGeom, shadowMat);
        contactShadow.renderOrder = 0;
        watchGroup.add(contactShadow);

        // --- WRIST OCCLUDER ---
        // Invisible cylinder that writes to the depth buffer only, hiding any
        // strap geometry that should be "behind" the wrist.
        const occluderGeom = new THREE.CylinderGeometry(0.38, 0.40, 1.4, 32);
        const occluderMat = new THREE.MeshBasicMaterial({ 
            colorWrite: false,
            depthWrite: true
        });
        const occluder = new THREE.Mesh(occluderGeom, occluderMat);
        occluder.renderOrder = 1;
        watchGroup.add(occluder);

        status.innerText = 'Loading 3D Model...';
        if (statusText) statusText.innerText = 'Downloading 3D watch assets...';

        const isObj = CONFIG.modelUrl.toLowerCase().includes('.obj');
        console.log("Model URL loaded inside AR module:", CONFIG.modelUrl);
        console.log("Evaluated isObj as:", isObj);

        function processLoadedModel(model, loaderType) {
            // 1. Assign / enhance materials for photorealistic rendering
            model.traverse((child) => {
                if (child.isMesh) {
                    if (loaderType === 'OBJ' || !child.material) {
                        // OBJ fallback: metallic watch material
                        child.material = new THREE.MeshStandardMaterial({
                            color: 0xd0d0d0,
                            metalness: 0.8,
                            roughness: 0.25
                        });
                    } else {
                        // GLTF models: ensure proper env-map and tone-mapping response
                        if (child.material.isMeshStandardMaterial || child.material.isMeshPhysicalMaterial) {
                            child.material.envMapIntensity = 1.0;
                            child.material.needsUpdate = true;
                        }
                    }
                    child.renderOrder = 2; // Render after occluder
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

            modelGroup.add(model);
            watchGroup.visible = false;
            status.innerText = 'Show your wrist to camera';

            isModelLoaded = true;
            updateProgress(100);
            if (statusText) statusText.innerText = 'Assets loaded! Calibrating wrist space...';
            setTimeout(checkInitComplete, 400);
        }

        if (isObj) {
            const loader = new OBJLoader();
            if (CONFIG.modelUrl.includes(window.location.hostname) || !CONFIG.modelUrl.startsWith('http')) {
                loader.setRequestHeader({ 'ngrok-skip-browser-warning': 'true' });
            }
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
            if (CONFIG.modelUrl.includes(window.location.hostname) || !CONFIG.modelUrl.startsWith('http')) {
                loader.setRequestHeader({ 'ngrok-skip-browser-warning': 'true' });
            }
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

        // FIX #1: Quaternion double-cover tracking.
        let prevTargetQuat = new THREE.Quaternion();
        let hasPrevQuat = false;

        // FIX #5/#6 state: robust orientation basis (Newell-normal)
        const smoothedYAxis = new THREE.Vector3();
        const smoothedZAxis = new THREE.Vector3();
        let hasSmoothedAxes = false;

        /* ================================================================
         * ONE EURO FILTER — Géry Casiez et al. (2012)
         * "1€ Filter: A Simple Speed-based Low-pass Filter for Noisy Input"
         *
         * Key insight: when the signal moves slowly, jitter dominates and
         * we want heavy smoothing (low cutoff). When it moves fast, lag
         * dominates and we want light smoothing (high cutoff). The filter
         * adapts its cutoff frequency every frame based on the estimated
         * speed of the signal.
         *
         * Parameters:
         *   minCutoff — minimum cutoff frequency in Hz (lower = smoother
         *               when stationary, but more lag). Good range: 0.3–3.0
         *   beta      — speed coefficient (higher = faster adaptation,
         *               meaning fast movements bypass smoothing more
         *               aggressively). Good range: 0.0–0.1
         *   dCutoff   — cutoff for the derivative (speed) estimation.
         *               Almost never needs tuning. Default 1.0 Hz.
         * ================================================================ */
        class LowPassFilter {
            constructor(alpha, initval = 0) {
                this.y = this.s = initval;
                this.setAlpha(alpha);
                this.initialized = false;
            }
            setAlpha(alpha) {
                this.alpha = Math.max(0, Math.min(1, alpha));
            }
            filter(value) {
                if (!this.initialized) {
                    this.y = this.s = value;
                    this.initialized = true;
                    return value;
                }
                this.y = value;
                this.s = this.alpha * value + (1 - this.alpha) * this.s;
                return this.s;
            }
            lastValue() { return this.y; }
            hatValue() { return this.s; }
            reset(value) { this.y = this.s = value; this.initialized = false; }
        }

        class OneEuroFilter {
            constructor(freq, minCutoff = 1.0, beta = 0.0, dCutoff = 1.0) {
                this.freq = freq;
                this.minCutoff = minCutoff;
                this.beta = beta;
                this.dCutoff = dCutoff;
                this.x = new LowPassFilter(this._alpha(minCutoff));
                this.dx = new LowPassFilter(this._alpha(dCutoff), 0.0);
                this.lastTime = null;
            }
            _alpha(cutoff) {
                const te = 1.0 / this.freq;
                const tau = 1.0 / (2 * Math.PI * cutoff);
                return 1.0 / (1.0 + tau / te);
            }
            filter(value, timestamp = null) {
                // Update frequency from timestamp if available
                if (timestamp !== null && this.lastTime !== null) {
                    const dt = timestamp - this.lastTime;
                    if (dt > 0) this.freq = 1.0 / dt;
                }
                if (timestamp !== null) this.lastTime = timestamp;

                // Estimate derivative (speed)
                const prevX = this.x.hatValue();
                const dx = this.x.initialized ? (value - prevX) * this.freq : 0.0;
                const edx = this.dx.filter(dx);
                this.dx.setAlpha(this._alpha(this.dCutoff));

                // Adaptive cutoff: faster motion → higher cutoff → less smoothing
                const cutoff = this.minCutoff + this.beta * Math.abs(edx);
                this.x.setAlpha(this._alpha(cutoff));
                return this.x.filter(value);
            }
            reset() {
                this.x.reset(0);
                this.dx.reset(0);
                this.lastTime = null;
            }
        }

        // Per-landmark One Euro filter banks (3 axes each: x, y, z)
        // We use separate banks for screen (2D) and world (3D) landmarks.
        const screenFilters = {};  // { landmarkId: { x: OneEuroFilter, y: OneEuroFilter, z: OneEuroFilter } }
        const worldFilters = {};   // { landmarkId: { x: OneEuroFilter, y: OneEuroFilter, z: OneEuroFilter } }
        // Orientation basis axis filters (6 total: yAxis.xyz, zAxis.xyz)
        const axisFilters = {
            yx: null, yy: null, yz: null,
            zx: null, zy: null, zz: null
        };

        const ASSUMED_FPS = 30; // Initial frequency estimate; auto-corrected by timestamps

        function getOrCreateFilters(bank, id) {
            if (!bank[id]) {
                bank[id] = {
                    x: new OneEuroFilter(ASSUMED_FPS, CONFIG.oneEuroMinCutoff, CONFIG.oneEuroBeta, CONFIG.oneEuroDCutoff),
                    y: new OneEuroFilter(ASSUMED_FPS, CONFIG.oneEuroMinCutoff, CONFIG.oneEuroBeta, CONFIG.oneEuroDCutoff),
                    z: new OneEuroFilter(ASSUMED_FPS, CONFIG.oneEuroMinCutoff, CONFIG.oneEuroBeta, CONFIG.oneEuroDCutoff)
                };
            }
            return bank[id];
        }

        function applyOneEuroParams(filterBank) {
            for (const id in filterBank) {
                const f = filterBank[id];
                if (f.x) { f.x.minCutoff = CONFIG.oneEuroMinCutoff; f.x.beta = CONFIG.oneEuroBeta; }
                if (f.y) { f.y.minCutoff = CONFIG.oneEuroMinCutoff; f.y.beta = CONFIG.oneEuroBeta; }
                if (f.z) { f.z.minCutoff = CONFIG.oneEuroMinCutoff; f.z.beta = CONFIG.oneEuroBeta; }
            }
        }

        function getSmoothedScreen(id, raw) {
            const f = getOrCreateFilters(screenFilters, id);
            // Live-update filter params from CONFIG (tuning sliders)
            f.x.minCutoff = CONFIG.oneEuroMinCutoff; f.x.beta = CONFIG.oneEuroBeta;
            f.y.minCutoff = CONFIG.oneEuroMinCutoff; f.y.beta = CONFIG.oneEuroBeta;
            f.z.minCutoff = CONFIG.oneEuroMinCutoff; f.z.beta = CONFIG.oneEuroBeta;
            const t = performance.now() / 1000; // seconds
            return new THREE.Vector3(
                f.x.filter(raw.x, t),
                f.y.filter(raw.y, t),
                f.z.filter(raw.z, t)
            );
        }

        function getSmoothedWorld(id, raw) {
            const f = getOrCreateFilters(worldFilters, id);
            f.x.minCutoff = CONFIG.oneEuroMinCutoff; f.x.beta = CONFIG.oneEuroBeta;
            f.y.minCutoff = CONFIG.oneEuroMinCutoff; f.y.beta = CONFIG.oneEuroBeta;
            f.z.minCutoff = CONFIG.oneEuroMinCutoff; f.z.beta = CONFIG.oneEuroBeta;
            const t = performance.now() / 1000;
            return new THREE.Vector3(
                f.x.filter(raw.x, t),
                f.y.filter(raw.y, t),
                f.z.filter(raw.z, t)
            );
        }

        function initAxisFilters() {
            for (const key of ['yx', 'yy', 'yz', 'zx', 'zy', 'zz']) {
                axisFilters[key] = new OneEuroFilter(ASSUMED_FPS, CONFIG.oneEuroMinCutoff, CONFIG.oneEuroBeta, CONFIG.oneEuroDCutoff);
            }
        }
        initAxisFilters();

        function filterAxis(prefix, vec) {
            const t = performance.now() / 1000;
            const fx = axisFilters[prefix + 'x'];
            const fy = axisFilters[prefix + 'y'];
            const fz = axisFilters[prefix + 'z'];
            fx.minCutoff = CONFIG.oneEuroMinCutoff; fx.beta = CONFIG.oneEuroBeta;
            fy.minCutoff = CONFIG.oneEuroMinCutoff; fy.beta = CONFIG.oneEuroBeta;
            fz.minCutoff = CONFIG.oneEuroMinCutoff; fz.beta = CONFIG.oneEuroBeta;
            return new THREE.Vector3(
                fx.filter(vec.x, t),
                fy.filter(vec.y, t),
                fz.filter(vec.z, t)
            ).normalize();
        }

        function resetAllFilters() {
            for (const id in screenFilters) {
                screenFilters[id].x.reset(); screenFilters[id].y.reset(); screenFilters[id].z.reset();
            }
            for (const id in worldFilters) {
                worldFilters[id].x.reset(); worldFilters[id].y.reset(); worldFilters[id].z.reset();
            }
            initAxisFilters();
        }

        hands.onResults((results) => {
            if (!watchGroup) return;

            if (!results.multiHandLandmarks?.length || !results.multiHandWorldLandmarks?.length) {
                isHandDetected = false;
                watchGroup.visible = false;
                status.innerText = 'Show your wrist';
                // Reset all One Euro filters to prevent jumping when hand reappears
                resetAllFilters();
                hasPrevQuat = false;     // reset quaternion continuity on hand loss
                hasSmoothedAxes = false; // reset basis smoothing on hand loss
                return;
            }

            isHandDetected = true;
            watchGroup.visible = true;
            status.innerText = 'Tracking...';

            const lm = results.multiHandLandmarks[0];
            const wlm = results.multiHandWorldLandmarks[0];

            // FIX #4: correct MediaPipe's handedness label.
            // MediaPipe's Hands solution determines "Left"/"Right" assuming the input
            // image is mirrored (i.e. a front-facing/selfie camera with the frame
            // flipped horizontally) — see the official docs. We feed it `video`
            // directly, which is the RAW, unmirrored frame (the CSS scaleX(-1) on
            // #video is a display-only effect and doesn't affect what MediaPipe sees).
            // On a front camera this means the label comes back inverted: your real
            // right hand is reported as "Left" and vice versa. Every downstream
            // calculation (rawTransverse direction, zAxis cross-product order) branches
            // on isLeft, so the inverted label flips the watch's Z-axis (the axis meant
            // to point out of the back of the hand, toward the camera) for one real
            // hand. That flip pushes the invisible occluder mesh in FRONT of the watch
            // instead of behind it, and since the occluder still writes to the depth
            // buffer, it blocks the watch from rendering at all on that hand — exactly
            // the "not showing on right hand" / tiny-sliver symptom.
            // On a back/"environment" camera the raw frame is already true-to-life, so
            // the label needs no correction there.
            const rawHandednessLabel = results.multiHandedness[0].label;
            const isLeft = isMirrored ? (rawHandednessLabel === 'Right') : (rawHandednessLabel === 'Left');

            // Retrieve and smooth 3D world coordinates (meters)
            const wWrist = getSmoothedWorld(0, wlm[0]);
            const wIndex = getSmoothedWorld(5, wlm[5]);
            const wMiddle = getSmoothedWorld(9, wlm[9]);
            const wRing = getSmoothedWorld(13, wlm[13]);
            const wPinky = getSmoothedWorld(17, wlm[17]);

            // Retrieve and smooth 2D screen coordinates
            const sWrist = getSmoothedScreen(0, lm[0]);
            const sIndex = getSmoothedScreen(5, lm[5]);
            const sMiddle = getSmoothedScreen(9, lm[9]);
            const sPinky = getSmoothedScreen(17, lm[17]);

            // Map MediaPipe world coordinates (Y-down, Z-forward) to ThreeJS camera space (Y-up, Z-backward)
            const toCameraSpace = (v) => new THREE.Vector3(v.x, -v.y, -v.z);
            const cWrist = toCameraSpace(wWrist);
            const cIndex = toCameraSpace(wIndex);
            const cMiddle = toCameraSpace(wMiddle);
            const cRing = toCameraSpace(wRing);
            const cPinky = toCameraSpace(wPinky);

            // 1. POSITION & DEPTH ESTIMATION
            const focalLength = 1.0729; // Vertical focal length for ~50 degree FOV

            // Get dynamic video aspect ratio for isotropic screen spacing
            const videoAspect = (video.videoWidth && video.videoHeight) ? (video.videoWidth / video.videoHeight) : (640 / 480);

            // Forearm axis (wrist to middle MCP)
            const dScreenForearm = Math.hypot((sMiddle.x - sWrist.x) * videoAspect, sMiddle.y - sWrist.y);
            const dWorldForearm = cMiddle.distanceTo(cWrist); 
            const dFlatForearm = Math.sqrt(Math.pow(cMiddle.x - cWrist.x, 2) + Math.pow(cMiddle.y - cWrist.y, 2));

            // Transverse axis (index MCP to pinky MCP)
            const dScreenTransverse = Math.hypot((sIndex.x - sPinky.x) * videoAspect, sIndex.y - sPinky.y);
            const dWorldTransverse = cIndex.distanceTo(cPinky);
            const dFlatTransverse = Math.sqrt(Math.pow(cIndex.x - cPinky.x, 2) + Math.pow(cIndex.y - cPinky.y, 2));

            // Depth estimates from both axes
            const zForearm = (focalLength * dFlatForearm) / Math.max(dScreenForearm, 0.001);
            const zTransverse = (focalLength * dFlatTransverse) / Math.max(dScreenTransverse, 0.001);

            // Compute weights based on how aligned the axis is with the camera plane
            const wForearmWeight = dFlatForearm / Math.max(dWorldForearm, 0.001);
            const wTransverseWeight = dFlatTransverse / Math.max(dWorldTransverse, 0.001);

            // Weighted depth estimation (meters)
            let estimatedDepth = (wForearmWeight * zForearm + wTransverseWeight * zTransverse) / Math.max(wForearmWeight + wTransverseWeight, 0.001);
            estimatedDepth = Math.max(0.2, Math.min(estimatedDepth, 2.0)); // Clamp depth

            // Compute 3D position of wrist joint in camera space
            let xc = sWrist.x;
            let yc = sWrist.y;

            if (video.videoWidth && video.videoHeight) {
                const videoAspect = video.videoWidth / video.videoHeight;
                const canvasAspect = width / height;

                if (canvasAspect < videoAspect) {
                    // Portrait (mobile): crop left/right
                    xc = (sWrist.x - 0.5) * (videoAspect / canvasAspect) + 0.5;
                } else {
                    // Landscape (laptop): crop top/bottom
                    yc = (sWrist.y - 0.5) * (canvasAspect / videoAspect) + 0.5;
                }
            }

            const signX = isMirrored ? -2 : 2;
            const ndc = new THREE.Vector3((xc - 0.5) * signX, -(yc - 0.5) * 2, 0.5);
            ndc.unproject(camera);
            ndc.sub(camera.position).normalize();
            const wristPos3D = camera.position.clone().add(ndc.multiplyScalar(estimatedDepth));

            targetPos.copy(wristPos3D);

            // 2. ORIENTATION
            //
            // FIX #5: robust orientation from ALL FOUR knuckles instead of two points.
            // The previous approach derived the watch's face-normal (Z-axis) from a
            // single cross product of (index MCP -> pinky MCP) and (wrist -> middle
            // MCP). That's only two landmarks feeding the most rotation-sensitive
            // calculation in the whole pipeline — any noise, self-occlusion, or a
            // closed/curled hand (fist) degrades those two points fastest, which is
            // exactly when you saw the watch flip to an edge-on / sideways orientation.
            //
            // The knuckle (MCP) joints stay in a roughly stable, planar arrangement on
            // the back of the hand REGARDLESS of whether the fingers are curled into a
            // fist or held open — curling happens at the MCP joint, not before it, so
            // the knuckle positions themselves barely move. That makes the plane
            // through wrist + all 4 MCPs a much steadier reference for "which way is
            // the back of the hand facing" than any single pair of points.
            //
            // We fit that plane's normal using Newell's method across the 5-point palm
            // loop (wrist, index MCP, middle MCP, ring MCP, pinky MCP). Newell's method
            // averages contributions from every edge of the loop, so noise in any one
            // landmark gets diluted instead of directly corrupting the result.
            function newellNormal(pts) {
                const n = new THREE.Vector3(0, 0, 0);
                for (let i = 0; i < pts.length; i++) {
                    const curr = pts[i];
                    const next = pts[(i + 1) % pts.length];
                    n.x += (curr.y - next.y) * (curr.z + next.z);
                    n.y += (curr.z - next.z) * (curr.x + next.x);
                    n.z += (curr.x - next.x) * (curr.y + next.y);
                }
                return n;
            }

            // Forearm direction (raw Y-axis) - points from wrist to middle MCP (fingers direction)
            const rawYAxis = new THREE.Vector3().subVectors(cMiddle, cWrist).normalize();

            // Palm loop in winding order: wrist -> index -> middle -> ring -> pinky -> (back to wrist)
            const palmLoop = [cWrist, cIndex, cMiddle, cRing, cPinky];
            const rawNormal = newellNormal(palmLoop);

            // Cheap reference cross product (old method) purely to disambiguate sign —
            // Newell's method gives a normal but not which of the two directions along
            // it is "out of the back of the hand," so we use the handedness-corrected
            // cross product order to pick the right one.
            const referenceTransverse = isLeft
                ? new THREE.Vector3().subVectors(cPinky, cIndex)
                : new THREE.Vector3().subVectors(cIndex, cPinky);
            const referenceNormal = isLeft
                ? new THREE.Vector3().crossVectors(rawYAxis, referenceTransverse)
                : new THREE.Vector3().crossVectors(referenceTransverse, rawYAxis);

            const MIN_NORMAL_MAGNITUDE = 0.0004; // tune empirically if needed

            if (rawNormal.length() < MIN_NORMAL_MAGNITUDE) {
                // Palm points are too close to collinear/degenerate this frame
                // (extreme edge-on angle). Hold the last good orientation rather
                // than feed noise into the quaternion.
            } else {
                if (rawNormal.dot(referenceNormal) < 0) rawNormal.negate();
                const rawZAxis = rawNormal.normalize();

                // FIX #6: smooth basis vectors with One Euro Filter instead of
                // fixed-alpha nlerp. One Euro adapts: slow rotations get heavy
                // smoothing (kills wobble), fast rotations get light smoothing
                // (preserves responsiveness).
                const filteredY = filterAxis('y', rawYAxis);
                const filteredZ = filterAxis('z', rawZAxis);
                smoothedYAxis.copy(filteredY);
                smoothedZAxis.copy(filteredZ);
                hasSmoothedAxes = true;

                // Gram-Schmidt: re-orthogonalize so Y and Z are exactly perpendicular,
                // then derive X from them. This is the standard trick to build a clean
                // right-handed orthonormal basis from two independently-smoothed axes.
                const zAxis = smoothedZAxis.clone();
                const yAxis = new THREE.Vector3()
                    .copy(smoothedYAxis)
                    .sub(zAxis.clone().multiplyScalar(smoothedYAxis.dot(zAxis)))
                    .normalize();
                const xAxis = new THREE.Vector3().crossVectors(yAxis, zAxis).normalize();

                // Construct standard right-handed orthonormal basis
                const watchY = yAxis; // 12 o'clock points towards fingers
                const watchZ = zAxis; // Watch face points out of back of hand
                const watchX = xAxis;

                const matrix = new THREE.Matrix4();
                matrix.makeBasis(watchX, watchY, watchZ);
                targetQuat.setFromRotationMatrix(matrix);

                // Apply the custom rotation tuning offset on top of the arm-tracking quaternion.
                // This rotates the watch model (and occluder together) to orient the dial correctly.
                const tuneQuat = new THREE.Quaternion().setFromEuler(CONFIG.rotationOffset);
                targetQuat.multiply(tuneQuat);

                // Auto-flip for the right hand so the watch doesn't appear upside down
                if (!isLeft) {
                    const rightHandFlip = new THREE.Quaternion().setFromEuler(new THREE.Euler(THREE.MathUtils.degToRad(-180), 0, 0));
                    targetQuat.multiply(rightHandFlip);
                }

                // FIX #1 (cont.): enforce quaternion continuity (shortest-path) so
                // slerp never takes the "long way around" during wrist rotation.
                if (hasPrevQuat && prevTargetQuat.dot(targetQuat) < 0) {
                    targetQuat.set(-targetQuat.x, -targetQuat.y, -targetQuat.z, -targetQuat.w);
                }
                prevTargetQuat.copy(targetQuat);
                hasPrevQuat = true;
            }

            // Position the watch model, shadow and occluder inside watchGroup
            // X offset = side-to-side, Y offset = down the arm, Z offset = above skin
            modelGroup.position.set(CONFIG.xOffset, CONFIG.yOffset, CONFIG.zOffset);
            contactShadow.position.set(CONFIG.xOffset, CONFIG.yOffset, CONFIG.zOffset - 0.05);
            occluder.position.set(CONFIG.xOffset, CONFIG.yOffset, CONFIG.zOffset - 0.38);

            // 3. PHYSICAL SCALE & MIRRORING
            const baseHandWidth = 0.075; // average hand width (7.5 cm)
            const watchDiameter = 0.042; // physical watch scale (42mm)
            const s = watchDiameter * (dWorldTransverse / baseHandWidth) * CONFIG.scaleMultiplier;

            // Mirror the X-axis scale of the group to automatically flip geometry and rotation if mirrored
            targetScale.set(isMirrored ? -s : s, s, s);
        });

        /* ---------------- ANIMATION LOOP ---------------- */
        function animate() {
            requestAnimationFrame(animate);
            if (isHandDetected) {
                // FIX #3: independent smoothing rates. Rotation gets heavier damping
                // than position/scale since rotational noise from wrist-twist is far
                // spikier than positional noise.
                watchGroup.position.lerp(targetPos, CONFIG.smoothFactorPosition);
                watchGroup.quaternion.slerp(targetQuat, CONFIG.smoothFactorRotation);
                watchGroup.scale.lerp(targetScale, CONFIG.smoothFactorScale);
            }
            renderer.render(scene, camera);
        }
        animate(); // Start animation loop

        /* ---------------- CAMERA SETUP ---------------- */
        const cameraUtils = new Camera(video, {
            onFrame: async () => { await hands.send({ image: video }); },
            width: 1280, height: 720,
            facingMode: 'environment'
        });
        cameraUtils.start();

        window.addEventListener('resize', () => {
            updateCameraAndBackground();
        });

        /* ---------------- UI TOGGLE LOGIC ---------------- */
        const toggleBtn = document.getElementById('toggle-ui-btn');
        const arUi = document.getElementById('ar-ui');
        if (toggleBtn && arUi) {
            toggleBtn.addEventListener('click', () => {
                arUi.classList.toggle('hidden-ui');
                if (arUi.classList.contains('hidden-ui')) {
                    toggleBtn.style.color = '#ffffff';
                    toggleBtn.style.background = 'rgba(255, 255, 255, 0.15)';
                } else {
                    toggleBtn.style.color = 'var(--accent)';
                    toggleBtn.style.background = 'var(--glass)';
                }
            });
        }
    </script>
@endsection