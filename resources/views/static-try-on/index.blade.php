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

                <div class="tryon-toggle mb-5 d-inline-flex p-1 bg-dark rounded-pill border border-silver-dim">
                    <button class="btn btn-toggle active" id="btn-upload-mode">
                        <i class="fas fa-upload me-2"></i>Upload Photo
                    </button>
                    <button class="btn btn-toggle" id="btn-camera-mode">
                        <i class="fas fa-camera me-2"></i>Take Photo
                    </button>
                </div>

                @if(!isset($generated))
                    <div id="upload-section">
                        <form id="tryon-form" action="{{ route('static.generate') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                            @csrf
                            <div class="upload-zone p-5 mb-4" id="upload-zone">
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
                    <div class="results-section mt-5">
                        <h3 class="text-accent mb-4">Your AI Try-On Gallery</h3>
                        
                        <!-- Swiper Gallery -->
                        <div class="swiper tryon-swiper mb-5">
                            <div class="swiper-wrapper">
                                @foreach($watches as $watch)
                                    <div class="swiper-slide card-slide">
                                        <div class="tryon-composite-container">
                                            <!-- The Wrist Image as background -->
                                            <img src="{{ $wristImageUrl }}" class="wrist-bg" alt="Your Wrist">
                                            <!-- The Watch overlayed (Simulated with CSS) -->
                                            <div class="watch-overlay">
                                                <img src="{{ $watch->thumbnail }}" class="watch-img" alt="{{ $watch->title }}">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <h5 class="text-accent">{{ $watch->title }}</h5>
                                            <p class="text-silver">${{ number_format($watch->price, 2) }}</p>
                                            <a href="{{ route('product.show', $watch->id) }}" class="btn btn-sm btn-outline-custom">View Details</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination"></div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>

                        <a href="{{ route('static.index') }}" class="btn btn-outline-custom mt-3">
                            <i class="fas fa-redo me-2"></i>Try Another Photo
                        </a>
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

    .tryon-composite-container {
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        border: 1px solid rgba(241, 229, 172, 0.1);
    }

    .watch-img {
        width: 45%;
        transform: rotate(-10deg) translateY(10%);
        filter: drop-shadow(0 15px 15px rgba(0,0,0,0.6));
        transition: transform 0.3s ease;
    }

    .swiper-slide:hover .watch-img {
        transform: rotate(-12deg) translateY(5%) scale(1.05);
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

        // Mode Switching
        btnUpload.onclick = () => {
            btnUpload.classList.add('active');
            btnCamera.classList.remove('active');
            uploadZone.classList.remove('d-none');
            cameraContainer.classList.add('d-none');
            stopCamera();
        };

        btnCamera.onclick = async () => {
            btnCamera.classList.add('active');
            btnUpload.classList.remove('active');
            uploadZone.classList.add('d-none');
            cameraContainer.classList.remove('d-none');
            await startCamera();
        };

        async function startCamera() {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } });
                video.srcObject = stream;
                video.classList.remove('d-none');
                previewContainer.classList.add('d-none');
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
                previewContainer.classList.remove('d-none');
            }, 'image/jpeg');
        };

        retakeBtn.onclick = () => {
            video.classList.remove('d-none');
            previewContainer.classList.add('d-none');
            capturedBlob = null;
        };

        // Click to upload
        if (zone) {
            zone.onclick = () => fileInput.click();
        }

        // Form Submission
        form.onsubmit = (e) => {
            const loadingOverlay = document.getElementById('loading-overlay');
            
            if (btnCamera.classList.contains('active')) {
                if (!capturedBlob) {
                    alert("Please capture a photo first!");
                    e.preventDefault();
                    return;
                }
                
                // Add the blob as a file to the form
                const dataTransfer = new DataTransfer();
                const file = new File([capturedBlob], "capture.jpg", { type: "image/jpeg" });
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
            } else {
                if (fileInput.files.length === 0) {
                    alert("Please select an image to upload!");
                    e.preventDefault();
                    return;
                }
            }
            
            // Show luxury loading
            loadingOverlay.classList.remove('d-none');
        };

        // Initialize Swiper
        if (document.querySelector('.tryon-swiper')) {
            new Swiper('.tryon-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: { el: '.swiper-pagination', clickable: true },
                navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        }
    });
</script>
@endsection
@endsection
