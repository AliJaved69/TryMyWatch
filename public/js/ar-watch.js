import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const video = document.getElementById('video');
const canvas = document.getElementById("three-canvas");
const status = document.getElementById("status");

// --- 1. SETUP SCENE ---
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(70, window.innerWidth / window.innerHeight, 0.01, 100);
const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
renderer.setSize(window.innerWidth, window.innerHeight);

// Lighting
scene.add(new THREE.AmbientLight(0xffffff, 2.0));
const dirLight = new THREE.DirectionalLight(0xffffff, 3);
dirLight.position.set(0, 10, 10);
scene.add(dirLight);

// --- 2. LOAD MODEL ---
let watchModel;
const loader = new GLTFLoader();

// FIX: Bypass Ngrok warning for the 3D model file
loader.setRequestHeader({ 'ngrok-skip-browser-warning': 'true' });

status.innerText = "Downloading Model...";

loader.load(
    window.WATCH_CONFIG.modelUrl,
    (gltf) => {
        watchModel = gltf.scene;

        // Auto-Scale Logic
        const box = new THREE.Box3().setFromObject(watchModel);
        const size = box.getSize(new THREE.Vector3());
        const maxDim = Math.max(size.x, size.y, size.z);
        const scaleFactor = 1.5 / maxDim; 
        watchModel.scale.set(scaleFactor, scaleFactor, scaleFactor);
        
        // Center the model
        const center = box.getCenter(new THREE.Vector3());
        watchModel.position.x += (watchModel.position.x - center.x) * scaleFactor;
        watchModel.position.y += (watchModel.position.y - center.y) * scaleFactor;
        watchModel.position.z += (watchModel.position.z - center.z) * scaleFactor;

        watchModel.visible = false;
        scene.add(watchModel);

        status.innerText = "Model Ready. Point at wrist!";
    },
    (xhr) => console.log((xhr.loaded / xhr.total * 100) + '% loaded'),
    (error) => {
        console.error(error);
        status.innerText = "Error Loading Model";
    }
);

// --- 3. MEDIAPIPE TRACKING ---
const hands = new Hands({
    locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands@0.4.1646424915/${file}`
});

hands.setOptions({
    maxNumHands: 1,
    modelComplexity: 1,
    minDetectionConfidence: 0.5,
    minTrackingConfidence: 0.5
});

hands.onResults((results) => {
    if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
        
        const landmarks = results.multiHandLandmarks[0];
        const wrist = landmarks[0];
        const middleFinger = landmarks[9];

        // --- POSITION MAPPING (UPDATED FOR BACK CAMERA) ---
        
        // X is NO LONGER inverted because we aren't mirroring the video
        const x = (wrist.x - 0.5) * 8;   
        
        // Y and Z stay the same
        const y = -(wrist.y - 0.5) * 6;   
        const z = -wrist.z * 10;          

        if (watchModel) {
            watchModel.visible = true;
            watchModel.position.set(x, y, z);

            // Rotation
            const angle = Math.atan2(
                middleFinger.y - wrist.y,
                middleFinger.x - wrist.x
            );
            // Rotation might need slight adjustment depending on the specific model orientation
            watchModel.rotation.z = -angle - Math.PI / 2;
        }
        
        status.innerText = "Tracking Active";

    } else {
        if (watchModel) watchModel.visible = false;
        status.innerText = "Point camera at your hand...";
    }
});

// --- 4. START CAMERA (BACK CAMERA) ---
const cameraFeed = new Camera(video, {
    onFrame: async () => {
        await hands.send({ image: video });
    },
    width: 1280,
    height: 720,
    facingMode: 'environment' // <--- THIS REQUESTS THE BACK CAMERA
});

cameraFeed.start();

// --- 5. LOOP ---
function animate() {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
}
animate();

window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});