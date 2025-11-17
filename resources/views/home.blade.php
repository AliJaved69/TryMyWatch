@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left content: Headline + Description + Buttons -->
            <div class="col-lg-6" style="margin-top: 50px;">
                <h1 class="display-4 fw-bold mb-4 animate-fade-in">
                    Discover the Future of Watch Shopping with 
                    <span class="text-accent gradient-text">AI-Powered Augmented Reality</span>
                </h1>
                <p class="lead mb-4 text-secondary-custom slide-in-left">
                    TryMyWatch transforms the way you shop for luxury watches — try on the latest models virtually using cutting-edge AI and AR technology, all from the comfort of your home.
                </p>
                <ul class="mb-4 text-secondary-custom feature-list" style="list-style: none; padding-left: 0;">
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>Real-time, realistic watch try-on experience</li>
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>Extensive collection of top watch brands</li>
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>Seamless integration with your device camera</li>
                </ul>
                <div class="d-flex flex-wrap gap-3 button-group">
                    <a href="{{ url('/shop') }}" class="btn btn-primary-custom btn-glow">Try It Now</a>
                    <a href="#features" class="btn btn-outline-custom btn-slide">Learn More</a>
                </div>
            </div>

            <!-- Right content: Enhanced Watch animation -->
            <div class="col-lg-6 text-center">
                <div class="watch-container mx-auto" style="max-width: 320px;">
                    <div class="watch-face">
                        <div class="watch-dial">
                            <div class="watch-brand">TRYMYWATCH</div>
                            <div class="watch-indicators">
                                @for($i = 1; $i <= 12; $i++)
                                    <div class="watch-indicator indicator-{{ $i }}"></div>
                                @endfor
                            </div>
                        </div>
                        <div class="watch-hands">
                            <div class="hand hour-hand"></div>
                            <div class="hand minute-hand"></div>
                            <div class="hand second-hand"></div>
                        </div>
                        <div class="watch-crown"></div>
                        <div class="watch-bezel"></div>
                    </div>
                    <div class="watch-glow"></div>
                    <div class="ar-overlay">
                        <div class="ar-text">
                            <i class="fas fa-cube fa-bounce"></i>
                            AR Try-On Experience
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-5 features-section">
    <div class="container text-center">
        <h2 class="mb-5 section-title">Why Choose TryMyWatch?</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="mb-3">Easy-to-Use Interface</h5>
                <p class="text-secondary-custom">
                    Simply use your device camera to virtually try on watches in real-time with smooth, intuitive controls.
                </p>
            </div>
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="mb-3">Secure & Private</h5>
                <p class="text-secondary-custom">
                    Your privacy matters. All AR processing happens securely without storing your images or data.
                </p>
            </div>
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="mb-3">Save Time & Shop Confidently</h5>
                <p class="text-secondary-custom">
                    No more guesswork — see exactly how each watch fits your wrist before buying.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection