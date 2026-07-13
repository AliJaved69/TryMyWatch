@extends('layouts.app')

@section('title', 'AI Static Try-On')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="glass-card p-5 mt-5 animate-fade-in text-center">
                <h1 class="gradient-text mb-4">AI Static Try-On</h1>
                <p class="text-silver mb-4">Upload a photo of your wrist and let our AI show you how our luxury watches fit you.</p>
                
                <div class="mb-4">
                    <span class="badge bg-dark border border-accent p-2">
                        <i class="fas fa-coins text-accent me-2"></i>
                        Available Credits: <strong>{{ $credits }}</strong>
                    </span>
                </div>

                @if(!isset($generated))
                    <div class="tryon-toggle mb-5 d-inline-flex p-1 bg-dark rounded-pill border border-silver-dim">
                        <button class="btn btn-toggle active" id="btn-upload-mode">
                            <i class="fas fa-upload me-2"></i>Upload Photo
                        </button>
                        <button class="btn btn-toggle" id="btn-camera-mode">
                            <i class="fas fa-camera me-2"></i>Take Photo
                        </button>
                    </div>

                    <div id="upload-section">
                        <form id="tryon-form" action="{{ route('static.generate') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                            @csrf
                            <div class="upload-zone p-5 mb-4" id="upload-zone" style="cursor: pointer;">
                                <i class="fas fa-cloud-upload-alt fa-4x text-accent mb-3"></i>
                                <h4 class="text-silver">Click or Drag Image Here</h4>
                                <p class="text-secondary-custom small">Recommended: Clear photo of your wrist face-up</p>
                                <input type="file" name="wrist_image" id="wrist_image" class="d-none" accept="image/*">
                            </div>

                            <!-- Camera Container (Hidden by default) -->
                            <div id="camera-container" class="d-none mb-4">
                                <div class="camera-wrapper glass-card overflow-hidden">
                                    <video id="webcam" autoplay playsinline class="w-100"></video>
                                    <canvas id="photo-canvas" class="d-none"></canvas>
                                    <div class="camera-controls p-3">
                                        <button type="button" id="capture-btn" class="btn btn-accent rounded-circle p-3">
                                            <i class="fas fa-camera fa-2x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="preview-container" class="d-none mt-3">
                                    <p class="text-silver">Photo Captured!</p>
                                    <img id="photo-preview" class="img-fluid rounded border border-accent" style="max-height: 200px;">
                                    <button type="button" id="retake-btn" class="btn btn-sm btn-outline-danger mt-2">Retake</button>
                                </div>
                            </div>

                            <button type="submit" id="submit-tryon" class="btn btn-primary-custom px-5 py-3">
                                <i class="fas fa-magic me-2"></i>Generate Try-On
                            </button>
                        </form>
                    </div>
                @else
                    <div class="results-section mt-4 text-start">
                        <h3 class="gradient-text mb-4 text-center">Interactive Fitting Suite</h3>
                        
                        <div class="row justify-content-center">
                            <!-- Left Column: Interactive Viewport -->
                            <div class="col-lg-6 mb-4">
                                <div class="glass-card p-3 d-flex justify-content-center align-items-center position-relative">
                                    <div class="tryon-editor-viewport" id="tryon-viewport">
                                        <img src="{{ $wristImageUrl }}" id="wrist-bg-image" class="wrist-editor-bg" alt="Your Wrist" crossorigin="anonymous">
                                        <!-- Draggable Watch Overlay -->
                                        <div class="draggable-watch-wrapper" id="watch-draggable">
                                            <img src="{{ $watches->first()->thumbnail }}" id="active-watch-img" class="draggable-watch-img" alt="Watch Overlay" crossorigin="anonymous">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column: Fine-Tuning Controls -->
                            <div class="col-lg-5 mb-4">
                                <div class="glass-card p-4 h-100 d-flex flex-column justify-content-between">
                                    <div>
                                        <h4 class="text-accent mb-1" id="active-watch-title">{{ $watches->first()->title }}</h4>
                                        <p class="text-silver-dim small mb-3" id="active-watch-brand">{{ $watches->first()->brand }}</p>
                                        <h3 class="text-white mb-4" id="active-watch-price">${{ number_format($watches->first()->price, 2) }}</h3>
                                        
                                        <div class="mb-4">
                                            <label class="text-silver small d-flex justify-content-between mb-2">
                                                <span>Size / Scale</span>
                                                <span id="scale-val">100%</span>
                                            </label>
                                            <input type="range" id="scale-slider" class="premium-range" min="30" max="250" value="100">
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="text-silver small d-flex justify-content-between mb-2">
                                                <span>Rotation</span>
                                                <span id="rotate-val">-10°</span>
                                            </label>
                                            <input type="range" id="rotate-slider" class="premium-range" min="-180" max="180" value="-10">
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button id="download-btn" class="btn btn-primary-custom py-3">
                                            <i class="fas fa-download me-2"></i>Download Fitted Image
                                        </button>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                <button id="reset-btn" class="btn btn-outline-custom w-100 py-2">
                                                    <i class="fas fa-undo me-2"></i>Reset
                                                </button>
                                            </div>
                                            <div class="col-6">
                                                <a href="{{ route('product.show', $watches->first()->id) }}" id="details-link" class="btn btn-outline-custom w-100 py-2 text-center">
                                                    Details <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Watch Selector Slider -->
                        <h4 class="text-accent mb-4 text-center mt-4">Select a Luxury Watch to Try On</h4>
                        <div class="swiper tryon-swiper mb-4">
                            <div class="swiper-wrapper">
                                @foreach($watches as $watch)
                                    <div class="swiper-slide card-slide" 
                                         style="cursor: pointer;"
                                         data-id="{{ $watch->id }}"
                                         data-title="{{ $watch->title }}"
                                         data-brand="{{ $watch->brand }}"
                                         data-price="${{ number_format($watch->price, 2) }}"
                                         data-thumbnail="{{ $watch->thumbnail }}"
                                         data-url="{{ route('product.show', $watch->id) }}">
                                        <div class="glass-card p-3 text-center h-100 d-flex flex-column align-items-center justify-content-between">
                                            <div style="height: 120px; display: flex; align-items: center; justify-content: center;" class="mb-3 w-100">
                                                <img src="{{ $watch->thumbnail }}" style="max-height: 100%; max-width: 100%; object-fit: contain;" alt="{{ $watch->title }}">
                                            </div>
                                            <div>
                                                <h6 class="text-white mb-1 text-truncate" style="max-width: 150px;">{{ $watch->title }}</h6>
                                                <span class="text-accent small">${{ number_format($watch->price, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('static.index') }}" class="btn btn-outline-custom px-5">
                                <i class="fas fa-redo me-2"></i>Upload Another Photo
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

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
        aspect-ratio: 4 / 3;
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
        object-fit: contain;
        pointer-events: none;
    }

    .draggable-watch-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 160px;
        height: 160px;
        cursor: move;
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

    .premium-range {
        -webkit-appearance: none;
        width: 100%;
        background: rgba(197, 198, 199, 0.1);
        height: 6px;
        border-radius: 3px;
        outline: none;
    }

    .premium-range::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--accent);
        cursor: pointer;
        box-shadow: 0 0 10px rgba(241, 229, 172, 0.5);
    }

    /* Luxury Loading Overlay */
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 12, 16, 0.95);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .luxury-spinner {
        width: 60px;
        height: 60px;
        border: 2px solid rgba(241, 229, 172, 0.1);
        border-top: 2px solid var(--accent);
        border-radius: 50%;
        animation: spin 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
        margin-bottom: 2rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 576px) {
        .glass-card { padding: 2rem 1rem !important; }
        .btn-toggle { padding: 10px 15px; font-size: 0.85rem; }
    }
</style>

<!-- Loading Overlay (Hidden) -->
<div id="loading-overlay" class="d-none">
    <div class="luxury-spinner"></div>
    <h4 class="gradient-text mb-2">Analyzing Anatomy</h4>
    <p class="text-silver-dim small">Precision fitting in progress...</p>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const zone = document.getElementById('upload-zone');
        const fileInput = document.getElementById('wrist_image');
        const btnUpload = document.getElementById('btn-upload-mode');
        const btnCamera = document.getElementById('btn-camera-mode');
        const cameraContainer = document.getElementById('camera-container');
        const uploadZone = document.getElementById('upload-zone');
        const video = document.getElementById('webcam');
        const canvas = document.getElementById('photo-canvas');
        const captureBtn = document.getElementById('capture-btn');
        const previewContainer = document.getElementById('preview-container');
        const previewImg = document.getElementById('photo-preview');
        const retakeBtn = document.getElementById('retake-btn');
        const form = document.getElementById('tryon-form');
        
        let stream = null;
        let capturedBlob = null;

        if (form) {
            // Mode Switching
            if (btnUpload && btnCamera) {
                btnUpload.onclick = () => {
                    btnUpload.classList.add('active');
                    btnCamera.classList.remove('active');
                    if (uploadZone) uploadZone.classList.remove('d-none');
                    if (cameraContainer) cameraContainer.classList.add('d-none');
                    stopCamera();
                };

                btnCamera.onclick = async () => {
                    btnCamera.classList.add('active');
                    btnUpload.classList.remove('active');
                    if (uploadZone) uploadZone.classList.add('d-none');
                    if (cameraContainer) cameraContainer.classList.remove('d-none');
                    await startCamera();
                };
            }

            async function startCamera() {
                try {
                    stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                    if (video) {
                        video.srcObject = stream;
                        video.classList.remove('d-none');
                    }
                    if (previewContainer) previewContainer.classList.add('d-none');
                } catch (err) {
                    alert("Camera access denied or not available.");
                    if (btnUpload) btnUpload.click();
                }
            }

            function stopCamera() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }

            // Capture Photo
            if (captureBtn && video && canvas && previewImg && previewContainer) {
                captureBtn.onclick = () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    
                    canvas.toBlob((blob) => {
                        capturedBlob = blob;
                        previewImg.src = URL.createObjectURL(blob);
                        video.classList.add('d-none');
                        previewContainer.classList.remove('d-none');
                    }, 'image/jpeg');
                };
            }

            if (retakeBtn && video && previewContainer) {
                retakeBtn.onclick = () => {
                    video.classList.remove('d-none');
                    previewContainer.classList.add('d-none');
                    capturedBlob = null;
                };
            }

            // Click to upload
            if (zone && fileInput) {
                zone.onclick = () => fileInput.click();
            }

            // Form Submission
            form.onsubmit = (e) => {
                const loadingOverlay = document.getElementById('loading-overlay');
                
                if (btnCamera && btnCamera.classList.contains('active')) {
                    if (!capturedBlob) {
                        alert("Please capture a photo first!");
                        e.preventDefault();
                        return;
                    }
                    
                    // Add the blob as a file to the form
                    const dataTransfer = new DataTransfer();
                    const file = new File([capturedBlob], "capture.jpg", { type: "image/jpeg" });
                    dataTransfer.items.add(file);
                    if (fileInput) fileInput.files = dataTransfer.files;
                } else {
                    if (fileInput && fileInput.files.length === 0) {
                        alert("Please select an image to upload!");
                        e.preventDefault();
                        return;
                    }
                }
                
                // Show luxury loading
                if (loadingOverlay) loadingOverlay.classList.remove('d-none');
            };
        }

        // Initialize Swiper
        if (document.querySelector('.tryon-swiper')) {
            new Swiper('.tryon-swiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: false,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 4 }
                }
            });
        }

        // Interactive Editor Logic
        const viewport = document.getElementById('tryon-viewport');
        const watchWrapper = document.getElementById('watch-draggable');
        if (watchWrapper && viewport) {
            const watchImg = document.getElementById('active-watch-img');
            const wristBg = document.getElementById('wrist-bg-image');
            
            const scaleSlider = document.getElementById('scale-slider');
            const scaleVal = document.getElementById('scale-val');
            const rotateSlider = document.getElementById('rotate-slider');
            const rotateVal = document.getElementById('rotate-val');
            const resetBtn = document.getElementById('reset-btn');
            const downloadBtn = document.getElementById('download-btn');
            
            let scale = 100;
            let rotation = -10;
            let isDragging = false;
            let startX, startY;
            let startLeft, startTop;

            function applyTransform() {
                watchWrapper.style.transform = `translate(-50%, -50%) scale(${scale / 100}) rotate(${rotation}deg)`;
                scaleVal.textContent = `${scale}%`;
                rotateVal.textContent = `${rotation}°`;
            }

            watchWrapper.addEventListener('pointerdown', (e) => {
                isDragging = true;
                watchWrapper.setPointerCapture(e.pointerId);
                startX = e.clientX;
                startY = e.clientY;
                startLeft = watchWrapper.offsetLeft;
                startTop = watchWrapper.offsetTop;
                e.preventDefault();
            });

            watchWrapper.addEventListener('pointermove', (e) => {
                if (!isDragging) return;
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;
                watchWrapper.style.left = `${startLeft + dx}px`;
                watchWrapper.style.top = `${startTop + dy}px`;
            });

            const stopDrag = (e) => {
                if (isDragging) {
                    isDragging = false;
                    watchWrapper.releasePointerCapture(e.pointerId);
                }
            };
            watchWrapper.addEventListener('pointerup', stopDrag);
            watchWrapper.addEventListener('pointercancel', stopDrag);

            scaleSlider.addEventListener('input', (e) => {
                scale = parseInt(e.target.value);
                applyTransform();
            });

            rotateSlider.addEventListener('input', (e) => {
                rotation = parseInt(e.target.value);
                applyTransform();
            });

            resetBtn.addEventListener('click', () => {
                scale = 100;
                rotation = -10;
                scaleSlider.value = 100;
                rotateSlider.value = -10;
                watchWrapper.style.left = '50%';
                watchWrapper.style.top = '50%';
                applyTransform();
            });

            // Watch selection from Swiper
            document.querySelectorAll('.swiper-slide[data-thumbnail]').forEach(slide => {
                slide.addEventListener('click', () => {
                    const id = slide.getAttribute('data-id');
                    const title = slide.getAttribute('data-title');
                    const brand = slide.getAttribute('data-brand');
                    const price = slide.getAttribute('data-price');
                    const thumbnail = slide.getAttribute('data-thumbnail');
                    const url = slide.getAttribute('data-url');
                    
                    // Update editor
                    watchImg.src = thumbnail;
                    document.getElementById('active-watch-title').textContent = title;
                    document.getElementById('active-watch-brand').textContent = brand;
                    document.getElementById('active-watch-price').textContent = price;
                    document.getElementById('details-link').href = url;
                });
            });

            // Download merging
            downloadBtn.addEventListener('click', () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                canvas.width = wristBg.naturalWidth;
                canvas.height = wristBg.naturalHeight;
                
                // Draw background
                ctx.drawImage(wristBg, 0, 0, canvas.width, canvas.height);
                
                // Calculate scale ratio
                const ratio = wristBg.naturalWidth / viewport.clientWidth;
                
                // Visual center of the watch wrapper
                const cx = watchWrapper.offsetLeft * ratio;
                const cy = watchWrapper.offsetTop * ratio;
                
                // Scaled dimensions on natural space
                const wVal = watchWrapper.clientWidth * (scale / 100) * ratio;
                const hVal = watchWrapper.clientHeight * (scale / 100) * ratio;
                
                ctx.save();
                ctx.translate(cx, cy);
                ctx.rotate(rotation * Math.PI / 180);
                
                // Draw watch centered
                ctx.drawImage(watchImg, -wVal / 2, -hVal / 2, wVal, hVal);
                ctx.restore();
                
                // Create download link
                const link = document.createElement('a');
                link.download = `tryon_${document.getElementById('active-watch-title').textContent.toLowerCase().replace(/\s+/g, '_')}.jpg`;
                link.href = canvas.toDataURL('image/jpeg', 0.95);
                link.click();
            });

            applyTransform();
        }
    });
</script>
@endsection
@endsection
