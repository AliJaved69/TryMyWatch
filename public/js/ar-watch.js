// CAMERA
const video = document.getElementById('video');
navigator.mediaDevices.getUserMedia({ video: true })
.then(stream => video.srcObject = stream);

// THREE.JS
const canvas = document.getElementById("three-canvas");
const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
  70,
  window.innerWidth / window.innerHeight,
  0.01,
  10
);
camera.position.z = 1;

const renderer = new THREE.WebGLRenderer({ canvas, alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);

// LIGHT
scene.add(new THREE.AmbientLight(0xffffff, 1));

// LOAD WATCH MODEL
let watchModel;
const loader = new THREE.GLTFLoader();
loader.load(MODEL_URL, gltf => {
    watchModel = gltf.scene;
    watchModel.scale.set(0.01, 0.01, 0.01);
    scene.add(watchModel);
});

// MEDIAPIPE HANDS
const hands = new Hands({
  locateFile: file =>
    `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`
});

hands.setOptions({
  maxNumHands: 1,
  minDetectionConfidence: 0.7,
  minTrackingConfidence: 0.7
});

hands.onResults(results => {
  if (!results.multiHandLandmarks || !watchModel) return;

  const landmarks = results.multiHandLandmarks[0];
  const wrist = landmarks[0];
  const index = landmarks[5];

  // POSITION
  watchModel.position.x = (wrist.x - 0.5) * 2;
  watchModel.position.y = -(wrist.y - 0.5) * 2;

  // ROTATION
  const angle = Math.atan2(
    index.y - wrist.y,
    index.x - wrist.x
  );
  watchModel.rotation.z = -angle;
});

const cameraFeed = new Camera(video, {
  onFrame: async () => {
    await hands.send({ image: video });
  },
  width: 640,
  height: 480
});
cameraFeed.start();

// RENDER LOOP
function animate() {
  requestAnimationFrame(animate);
  renderer.render(scene, camera);
}
animate();
