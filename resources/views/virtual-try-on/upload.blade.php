@extends('layouts.app')

@section('title', 'AI Virtual Try-On')

@section('content')
<section class="py-5" style="margin-top: 80px;">
    <div class="container text-center">
        <h1 class="mb-4">AI Virtual Try-On (Beta)</h1>
        <p class="lead text-secondary mb-5">Upload a photo of your wrist, and our AI will place the <strong>{{ $product->title }}</strong> on it.</p>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Upload Area -->
                <div class="card bg-dark border-secondary mb-4">
                    <div class="card-body p-5">
                        <input type="file" id="imageInput" accept="image/*" class="form-control mb-3">
                        <button id="processBtn" class="btn btn-primary-custom w-100" disabled>
                            <i class="fas fa-magic"></i> Try On Now
                        </button>
                    </div>
                </div>

                <!-- Canvas Area -->
                <div class="position-relative d-inline-block">
                    <img id="uploadedImage" style="max-width: 100%; display: none;">
                    <canvas id="outputCanvas" style="max-width: 100%; border-radius: 8px; box-shadow: 0 0 20px rgba(0,0,0,0.5);"></canvas>
                    <div id="loading" class="position-absolute top-50 start-50 translate-middle text-warning" style="display: none;">
                        <div class="spinner-border" role="status"></div>
                        <div class="mt-2">Detecting Wrist...</div>
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
    const imageInput = document.getElementById('imageInput');
    const processBtn = document.getElementById('processBtn');
    const uploadedImage = document.getElementById('uploadedImage');
    const outputCanvas = document.getElementById('outputCanvas');
    const loading = document.getElementById('loading');
    const ctx = outputCanvas.getContext('2d');

    // Watch Image (Thumbnail) - For simplifying the 2D overlay demonstration
    // ideally we would render the 3D model to an image, but for this feature we overlay the 2D image
    const watchImg = new Image();
    watchImg.src = "{{ $product->thumbnail }}"; 
    // Note: If thumbnail is empty, use a placeholder

    let hands;

    async function initMediaPipe() {
        hands = new Hands({locateFile: (file) => `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`});
        hands.setOptions({
            maxNumHands: 1,
            modelComplexity: 1,
            minDetectionConfidence: 0.5
        });
        hands.onResults(onResults);
    }

    initMediaPipe();

    imageInput.addEventListener('change', function(e) {
        if(e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(event) {
                uploadedImage.src = event.target.result;
                uploadedImage.onload = () => {
                    processBtn.disabled = false;
                    // Reset canvas
                    outputCanvas.width = uploadedImage.naturalWidth;
                    outputCanvas.height = uploadedImage.naturalHeight;
                    ctx.drawImage(uploadedImage, 0, 0);
                };
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    processBtn.addEventListener('click', async function() {
        loading.style.display = 'block';
        processBtn.disabled = true;
        await hands.send({image: uploadedImage});
        loading.style.display = 'none';
        processBtn.disabled = false;
    });

    function onResults(results) {
        // Redraw image
        ctx.drawImage(uploadedImage, 0, 0);

        if (results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
            const landmarks = results.multiHandLandmarks[0];
            
            // Wrist Coordinates
            const wrist = landmarks[0];
            const middleFinger = landmarks[9]; // Middle finger base

            // Calculate pixel positions
            const wx = wrist.x * outputCanvas.width;
            const wy = wrist.y * outputCanvas.height;
            const mx = middleFinger.x * outputCanvas.width;
            const my = middleFinger.y * outputCanvas.height;

            // Calculate Angle
            const dx = mx - wx;
            const dy = my - wy;
            const angle = Math.atan2(dy, dx); 

            // Calculate Size (Distance between wrist and middle finger base approx half hand length)
            const handSize = Math.sqrt(dx*dx + dy*dy);
            const watchSize = handSize * 1.5; // Scale watch relative to hand

            // Draw Watch Image
            ctx.save();
            ctx.translate(wx, wy); // Move to wrist
            ctx.rotate(angle + Math.PI/2); // Rotate to align with arm (adjust +90deg as needed)
            
            // Draw Image Centered
            if (watchImg.complete) {
                ctx.drawImage(watchImg, -watchSize/2, -watchSize/2, watchSize, watchSize);
            } else {
                ctx.fillStyle = 'gold';
                ctx.beginPath();
                ctx.arc(0, 0, handSize/3, 0, 2*Math.PI);
                ctx.fill();
            }

            ctx.restore();
        } else {
            alert('No hand detected! Please try a clearer photo showing your wrist.');
        }
    }
</script>
@endsection
