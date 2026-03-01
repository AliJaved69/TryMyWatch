<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Try On - {{ $product->title }}</title>
    <style>
        body { margin: 0; overflow: hidden; background: #000; }
        #video {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transform: scaleX(-1);
            z-index: 0; display: none;
        }
        #three-canvas {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1;
        }
        #ui {
            position: fixed; top: 20px; left: 20px; z-index: 20; color: white;
            background: rgba(0,0,0,0.6); padding: 15px; border-radius: 8px; font-family: sans-serif;
        }
        .btn-back {
            display: inline-block; margin-top: 10px; padding: 5px 10px;
            background: #c9a96e; color: black; text-decoration: none; border-radius: 4px;
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

    <div id="ui">
        <h3>{{ $product->title }}</h3>
        <div id="status">Initializing AR...</div>
        <a href="{{ route('product.show', $product->id) }}" class="btn-back">Back to Product</a>
    </div>

    <video id="video" playsinline></video>
    <canvas id="three-canvas"></canvas>

    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

        // CONFIGURATION
        const CONFIG = {
            modelUrl: "{{ $product->model_3d }}", // Uses Product Accessor URL
            scaleMultiplier: 5.0,
            zOffset: 0.2,
            smoothFactor: 0.1
        };

        const video = document.getElementById('video');
        const canvas = document.getElementById('three-canvas');
        const status = document.getElementById('status');

        /* ---------------- SCENE SETUP ---------------- */
        const scene = new THREE.Scene();
        const videoTexture = new THREE.VideoTexture(video);
        scene.background = videoTexture;

        const camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 0.1, 100);
        camera.position.z = 10;

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
        const watchGroup = new THREE.Group();
        scene.add(watchGroup);
        
        const loader = new GLTFLoader();
        status.innerText = 'Loading 3D Model...';

        loader.load(
            CONFIG.modelUrl,
            (gltf) => {
                const model = gltf.scene;
                // Center model
                const box = new THREE.Box3().setFromObject(model);
                const center = box.getCenter(new THREE.Vector3());
                model.position.sub(center);
                
                // Adjust Rotation (Depends on specific model orientation)
                model.rotation.z = -Math.PI / 2; 

                watchGroup.add(model);
                watchGroup.visible = false;
                status.innerText = 'Show your wrist to camera';
            },
            undefined,
            (err) => {
                console.error(err);
                status.innerText = 'Error loading model (Check console)';
            }
        );

        /* ---------------- MEDIAPIPE LOGIC ---------------- */
        const hands = new Hands({ locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}` });
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
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });
    </script>
</body>
</html>
