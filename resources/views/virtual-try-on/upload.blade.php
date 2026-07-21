@extends('layouts.app')

@section('title', 'AI Virtual Try-On')

@section('content')
<style>
    .tryon-toggle {
        background: rgba(11, 12, 16, 0.9) !important;
        border: 1px solid rgba(241, 229, 172, 0.1) !important;
        padding: 5px;
    }
    
    .btn-toggle {
        padding: 12px 30px;
        border-radius: 50px;
        color: rgba(197, 198, 199, 0.6);
        border: none;
        background: transparent;
        font-weight: 500;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .btn-toggle.active {
        background: var(--accent);
        color: var(--primary);
        font-weight: 700;
        box-shadow: 0 0 20px rgba(241, 229, 172, 0.2);
    }

    .upload-zone {
        border: 2px dashed rgba(241, 229, 172, 0.2);
        background: rgba(31, 40, 51, 0.3);
        border-radius: 24px;
        transition: all 0.4s ease;
    }

    .upload-zone:hover {
        border-color: var(--accent);
        background: rgba(241, 229, 172, 0.05);
        transform: scale(1.01);
    }

    .camera-wrapper {
        border: 1px solid rgba(241, 229, 172, 0.2);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }

    .tryon-editor-viewport {
        position: relative;
        width: 100%;
        max-width: 450px;
        overflow: hidden;
        border-radius: 16px;
        background: #0d0d0d;
        display: flex;
        align-items: center;
        justify-content: center;
        touch-action: none;
    }

    .wrist-editor-bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        pointer-events: none;
    }

    .draggable-watch-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 160px;
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        touch-action: none;
        user-select: none;
    }

    .draggable-watch-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.5));
        pointer-events: none;
    }
</style>

<section class="py-5 bg-onyx min-vh-100" style="margin-top: 80px;">
    <div class="container text-center">
        <h1 class="gradient-text mb-4">AI Static Try-On</h1>
        <p class="lead text-secondary mb-5">Fit the <strong>{{ $product->title }}</strong> to your wrist using AI analysis.</p>

        <!-- Initial Input Screen -->
        <div id="input-screen" class="row justify-content-center">
            <div class="col-lg-6">
                <div class="glass-card p-5">
                    <div class="tryon-toggle mb-5 d-inline-flex p-1 bg-dark rounded-pill border border-silver-dim">
                        <button class="btn btn-toggle active" id="btn-upload-mode">
                            <i class="fas fa-upload me-2"></i>Upload Photo
                        </button>
                        <button class="btn btn-toggle" id="btn-camera-mode">
                            <i class="fas fa-camera me-2"></i>Take Photo
                        </button>
                    </div>

                    <!-- Upload Form Section -->
                    <div id="upload-section" class="mb-4">
                        <div class="upload-zone p-5 mb-4" id="upload-zone" style="cursor: pointer;">
                            <i class="fas fa-cloud-upload-alt fa-4x text-accent mb-3"></i>
                            <h4 class="text-silver">Click or Drag Image Here</h4>
                            <p class="text-secondary-custom small">Recommended: Clear photo of your wrist face-up</p>
                            <input type="file" id="imageInput" class="d-none" accept="image/*">
                        </div>
                    </div>

                    <!-- Camera Section -->
                    <div id="camera-container" class="d-none mb-4">
                        <div class="camera-wrapper glass-card overflow-hidden">
                            <video id="webcam" autoplay playsinline class="w-100" style="max-height: 350px; object-fit: cover;"></video>
                            <canvas id="photo-canvas" class="d-none"></canvas>
                            <div class="camera-controls p-3 bg-dark">
                                <button type="button" id="capture-btn" class="btn btn-accent rounded-circle p-3 shadow-accent-glow">
                                    <i class="fas fa-camera fa-2x text-primary"></i>
                                </button>
                            </div>
                        </div>
                        <div id="preview-container" class="d-none mt-3">
                            <p class="text-silver mb-2">Photo Captured!</p>
                            <img id="photo-preview" class="img-fluid rounded border border-accent mb-3" style="max-height: 200px;">
                            <div class="d-flex justify-content-center gap-2">
                                <button type="button" id="retake-btn" class="btn btn-outline-danger px-4">Retake</button>
                                <button type="button" id="confirm-capture-btn" class="btn btn-primary-custom px-4">Use Photo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Result / Fitting Viewport Screen (Hidden initially) -->
        <div id="result-screen" class="row justify-content-center d-none">
            <!-- Left Column: Non-interactive Viewport -->
            <div class="col-lg-6 mb-4">
                <div class="glass-card p-3 d-flex justify-content-center align-items-center position-relative">
                    <div class="tryon-editor-viewport" id="tryon-viewport" style="touch-action: none; pointer-events: none;">
                        <!-- Image elements -->
                        <img id="uploadedImage" class="wrist-editor-bg" crossorigin="anonymous">
                        <!-- Draggable Watch Overlay (Locked from pointer events) -->
                        <div class="draggable-watch-wrapper" id="watch-draggable" style="pointer-events: none; touch-action: none; cursor: default;">
                            <img src="{{ $product->thumbnail }}" id="active-watch-img" class="draggable-watch-img" alt="Watch Overlay" crossorigin="anonymous">
                        </div>
                    </div>
                    
                    <div id="loading" class="position-absolute top-50 start-50 translate-middle text-warning text-center p-4 rounded glass-card border border-accent" style="z-index: 20; background: rgba(11, 12, 16, 0.9);">
                        <div class="spinner-border text-accent mb-3" role="status"></div>
                        <div class="text-white fw-bold mb-1">Detecting Wrist Anatomy</div>
                        <div class="text-silver-dim small">Precision fitting in progress...</div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Watch Info & Action -->
            <div class="col-lg-4 mb-4">
                <div class="glass-card p-5 h-100 d-flex flex-column justify-content-between text-start">
                    <div>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-dark border border-accent p-2">AI Try-On</span>
                            <span class="text-accent fw-bold"><i class="fas fa-check-circle me-1"></i>AI Fitted</span>
                        </div>
                        
                        <h3 class="text-accent mb-1">{{ $product->title }}</h3>
                        <p class="text-silver-dim small mb-3">{{ $product->brand }}</p>
                        <h4 class="text-white mb-4">${{ number_format($product->price, 2) }}</h4>
                        
                        <div class="alert alert-dark border-silver-dim py-3" style="background: rgba(31, 40, 51, 0.3);">
                            <p class="text-silver small mb-0"><i class="fas fa-info-circle text-accent me-2"></i>The watch has been automatically fitted to your wrist using AI analysis. Download the result below.</p>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button id="download-btn" class="btn btn-primary-custom py-3 shadow-accent-glow">
                            <i class="fas fa-download me-2"></i>Download Fitted Image
                        </button>
                        <button id="retry-btn" class="btn btn-outline-custom py-3 mt-2">
                            <i class="fas fa-redo me-2"></i>Try Another Photo
                        </button>
                        <a href="{{ route('product.show', $product->id) }}" class="btn btn-outline-light py-2 mt-2 text-center">
                            Back to Product Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- MediaPipe Hands -->
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@mediapipe/drawing_utils/drawing_utils.js" crossorigin="anonymous"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnUpload = document.getElementById('btn-upload-mode');
        const btnCamera = document.getElementById('btn-camera-mode');
        const uploadZone = document.getElementById('upload-zone');
        const uploadSection = document.getElementById('upload-section');
        const cameraContainer = document.getElementById('camera-container');
        const imageInput = document.getElementById('imageInput');
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('photo-canvas');
        const captureBtn = document.getElementById('capture-btn');
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('photo-preview');
        const retakeBtn = document.getElementById('retake-btn');
        const confirmCaptureBtn = document.getElementById('confirm-capture-btn');

        const inputScreen = document.getElementById('input-screen');
        const resultScreen = document.getElementById('result-screen');
        const uploadedImage = document.getElementById('uploadedImage');
        const watchWrapper = document.getElementById('watch-draggable');
        const watchImg = document.getElementById('active-watch-img');
        const viewport = document.getElementById('tryon-viewport');
        const loading = document.getElementById('loading');
        
        const downloadBtn = document.getElementById('download-btn');
        const retryBtn = document.getElementById('retry-btn');

        let stream = null;
        let capturedBlob = null;
        let scale = 100;
        let rotation = 0;
        let hands = null;

        // Initialize MediaPipe
        async function initMediaPipe() {
            try {
                hands = new Hands({locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`});
                hands.setOptions({
                    maxNumHands: 1,
                    modelComplexity: 1,
                    minDetectionConfidence: 0.35
                });
                hands.onResults(onResults);
            } catch (err) {
                console.error("MediaPipe Initialization Error:", err);
            }
        }
        initMediaPipe();

        // Mode Switching
        btnUpload.onclick = () => {
            btnUpload.classList.add('active');
            btnCamera.classList.remove('active');
            uploadSection.classList.remove('d-none');
            cameraContainer.classList.add('d-none');
            stopCamera();
        };

        btnCamera.onclick = async () => {
            btnCamera.classList.add('active');
            btnUpload.classList.remove('active');
            uploadSection.classList.add('d-none');
            cameraContainer.classList.remove('d-none');
            await startCamera();
        };

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                video.classList.remove('d-none');
                captureBtn.classList.remove('d-none');
                previewContainer.classList.add('d-none');
                capturedBlob = null;
            } catch (err) {
                alert("Camera access denied or not available.");
                btnUpload.click();
            }
        }

        function stopCamera() {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }

        // Capture Photo
        captureBtn.onclick = () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            
            canvas.toBlob((blob) => {
                capturedBlob = blob;
                previewImg.src = URL.createObjectURL(blob);
                video.classList.add('d-none');
                captureBtn.classList.add('d-none');
                previewContainer.classList.remove('d-none');
            }, 'image/jpeg');
        };

        retakeBtn.onclick = () => {
            video.classList.remove('d-none');
            captureBtn.classList.remove('d-none');
            previewContainer.classList.add('d-none');
            capturedBlob = null;
        };

        // Use Captured Photo
        confirmCaptureBtn.onclick = () => {
            if (capturedBlob) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    processImage(event.target.result);
                };
                reader.readAsDataURL(capturedBlob);
            }
        };

        // Upload Zone Click
        uploadZone.onclick = () => imageInput.click();

        // File Select
        imageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    processImage(event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // Drag & Drop
        uploadZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = 'var(--accent)';
        });
        uploadZone.addEventListener('dragleave', () => {
            uploadZone.style.borderColor = 'rgba(241, 229, 172, 0.2)';
        });
        uploadZone.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadZone.style.borderColor = 'rgba(241, 229, 172, 0.2)';
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    processImage(event.target.result);
                };
                reader.readAsDataURL(e.dataTransfer.files[0]);
            }
        });

        // Common image processing pipeline
        function processImage(src) {
            stopCamera();
            inputScreen.classList.add('d-none');
            resultScreen.classList.remove('d-none');
            loading.classList.remove('d-none');
            
            // Set default center before analysis
            watchWrapper.style.left = '50%';
            watchWrapper.style.top = '50%';
            scale = 100;
            rotation = 0;
            applyTransform();

            uploadedImage.onload = function() {
                // Dynamically adjust viewport height to match natural image aspect ratio
                const aspect = uploadedImage.naturalHeight / uploadedImage.naturalWidth;
                viewport.style.height = (viewport.clientWidth * aspect) + 'px';

                // Polling helper to ensure the MediaPipe Hands object is ready before calling it
                const checkAndRun = async () => {
                    if (hands) {
                        try {
                            await hands.send({image: uploadedImage});
                        } catch (err) {
                            console.error("MediaPipe Analysis Error:", err);
                            handleDetectionFailure();
                        }
                    } else {
                        // Polling retry after 150ms
                        setTimeout(checkAndRun, 150);
                    }
                };

                // Introduce a tiny rendering sync delay to ensure the browser has fully laid out and painted the image pixels
                requestAnimationFrame(() => {
                    setTimeout(checkAndRun, 100);
                });
            };
            uploadedImage.src = src;
        }

        function applyTransform() {
            watchWrapper.style.transform = `translate(-50%, -50%) scale(${scale / 100}) rotate(${rotation}deg)`;
        }

        function handleDetectionFailure() {
            // Revert to center and hide loading
            loading.classList.add('d-none');
            showToast("Wrist detection failed. Watch positioned in center.", 'fas fa-info-circle');
        }

        function showToast(msg, iconClass = 'fas fa-check-circle') {
            if (window.showToast) {
                window.showToast(msg, iconClass);
            } else {
                alert(msg);
            }
        }

        // MediaPipe results callback
        function onResults(results) {
            loading.classList.add('d-none');
            
            if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                const landmarks = results.multiHandLandmarks[0];
                const wrist      = landmarks[0];
                const indexMCP   = landmarks[5];
                const pinkyMCP   = landmarks[17];

                const vWidth  = viewport.clientWidth;
                const vHeight = viewport.clientHeight;

                const wx = wrist.x * vWidth;
                const wy = wrist.y * vHeight;

                // ── Arm axis: wrist (L0) → middle finger MCP (L9) ────────────────────
                // L9 sits directly above L0 in the hand's anatomical axis — cleaner
                // forearm direction than averaging the full knuckle row.
                const mx    = landmarks[9].x * vWidth;
                const my    = landmarks[9].y * vHeight;
                const armDx = mx - wx;
                const armDy = my - wy;
                const armLen = Math.hypot(armDx, armDy);

                // ── Rotation ─────────────────────────────────────────────────────────
                // Product thumbnails have a VERTICAL strap (strap runs top-to-bottom).
                // So the watch rotation should directly follow the arm angle — no +90° offset.
                //   Vertical arm   (θ≈-90°) → -90°  → strap runs along the arm ✓
                //   Horizontal arm (θ≈0°)   →   0°  → strap horizontal ✓
                const armAngleDeg = Math.atan2(armDy, armDx) * 180 / Math.PI;
                rotation = Math.round(armAngleDeg);

                // ── Scale: Index MCP → Pinky MCP wrist width ─────────────────────────
                const ix = indexMCP.x * vWidth;
                const iy = indexMCP.y * vHeight;
                const px = pinkyMCP.x * vWidth;
                const py = pinkyMCP.y * vHeight;
                const handWidth       = Math.hypot(px - ix, py - iy);
                const targetWatchWidth = handWidth * 1.25;
                const baseWatchWidth   = watchWrapper.clientWidth || 160;
                scale = Math.round((targetWatchWidth / baseWatchWidth) * 100);
                scale = Math.max(30, Math.min(250, scale));

                // ── Position: offset 10% down forearm axis from wrist ────────────────
                const offsetDistance = armLen * 0.10;
                const dirX  = -armDx / armLen;
                const dirY  = -armDy / armLen;
                const finalX = wx + dirX * offsetDistance;
                const finalY = wy + dirY * offsetDistance;

                watchWrapper.style.left = `${finalX}px`;
                watchWrapper.style.top  = `${finalY}px`;

                applyTransform();
                showToast("AI Auto-fit complete!");
            } else {
                handleDetectionFailure();
            }
        }

        // Reset Try-on
        retryBtn.onclick = () => {
            resultScreen.classList.add('d-none');
            inputScreen.classList.remove('d-none');
            
            uploadedImage.src = '';
            capturedBlob = null;
            imageInput.value = '';
            
            if (btnCamera.classList.contains('active')) {
                startCamera();
            }
        };

        // Download merging
        downloadBtn.onclick = () => {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = uploadedImage.naturalWidth;
            canvas.height = uploadedImage.naturalHeight;
            
            // Draw background
            ctx.drawImage(uploadedImage, 0, 0, canvas.width, canvas.height);
            
            // Calculate scale ratio between natural image dimensions and display viewport
            const ratio = uploadedImage.naturalWidth / viewport.clientWidth;
            
            // Coordinates of watch center in natural space
            const cx = watchWrapper.offsetLeft * ratio;
            const cy = watchWrapper.offsetTop * ratio;
            
            // Scaled dimensions in natural space
            const wVal = watchWrapper.clientWidth * (scale / 100) * ratio;
            const hVal = watchWrapper.clientHeight * (scale / 100) * ratio;
            
            ctx.save();
            ctx.translate(cx, cy);
            ctx.rotate(rotation * Math.PI / 180);
            
            // Draw watch centered
            ctx.drawImage(watchImg, -wVal / 2, -hVal / 2, wVal, hVal);
            ctx.restore();
            
            // Trigger download
            const link = document.createElement('a');
            link.download = `tryon_AI_{{ strtolower(str_replace(' ', '_', $product->title)) }}.jpg`;
            link.href = canvas.toDataURL('image/jpeg', 0.95);
            link.click();
        };
    });
</script>
@endsection
