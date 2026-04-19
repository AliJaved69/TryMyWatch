@extends('layouts.app')

@section('title', 'Home')

@section('content')
<!-- Hero Slider Section -->
<section class="hero-slider-section">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide hero-slide" style="background: linear-gradient(rgba(11, 12, 16, 0.7), rgba(11, 12, 16, 0.7)), url('https://images.unsplash.com/photo-1523170335258-f5ed11844a49?auto=format&fit=crop&q=80'); background-size: cover; background-position: center;">
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content">
                        <h1 class="hero-title">Timeless <span class="text-accent">Elegance</span></h1>
                        <p class="hero-subtitle">Discover the curated collection of luxury timepieces.</p>
                        <a href="{{ url('/shop') }}" class="btn btn-primary-custom">Explore Collection</a>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide hero-slide" style="background: linear-gradient(rgba(11, 12, 16, 0.7), rgba(11, 12, 16, 0.7)), url('https://images.unsplash.com/photo-1547996160-81dfa63595aa?auto=format&fit=crop&q=80'); background-size: cover; background-position: center;">
                <div class="container h-100 d-flex align-items-center">
                    <div class="hero-content">
                        <h1 class="hero-title">Virtual <span class="text-accent">Try-On</span></h1>
                        <p class="hero-subtitle">Experience our AI-powered AR technology today.</p>
                        <a href="{{ url('/shop') }}" class="btn btn-primary-custom">Try it Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>

<!-- Luxury Introduction Section -->
<section class="luxury-intro-section py-5">
    <div class="container">
        <div class="glass-card p-5 animate-fade-in shadow-lg">
            <div class="row align-items-center">
                <!-- Content (Left) -->
                <div class="col-lg-7 text-start">
                    <h2 class="section-title gradient-text mb-4 text-start">A New Vision in Luxury</h2>
                    <p class="lead text-silver mb-4 pe-lg-5">
                        At TryMyWatch, we bridge the gap between digital convenience and the tactile allure of fine watchmaking. Our "New Idea" is simple yet revolutionary: **Real-time AI wrist synthesis**.
                    </p>
                    <p class="text-secondary-custom mb-5 pe-lg-5">
                        Gone are the days of guessing. With our advanced AR models and newly launched **AI Static Try-On**, you can instantly see a variety of premium watches rendered with photorealistic accuracy, lighting, and fit on your own wrist.
                    </p>
                    <div class="d-flex justify-content-start gap-4 flex-wrap">
                        <div class="feature-badge">
                            <i class="fas fa-microchip mb-2"></i>
                            <span>AI Powered</span>
                        </div>
                        <div class="feature-badge">
                            <i class="fas fa-vr-cardboard mb-2"></i>
                            <span>AR Experience</span>
                        </div>
                        <div class="feature-badge">
                            <i class="fas fa-fingerprint mb-2"></i>
                            <span>Personalized</span>
                        </div>
                    </div>
                </div>
                <!-- Image (Right) -->
                <div class="col-lg-5 text-center mt-5 mt-lg-0">
                    <div class="intro-image-container">
                        <img src="{{ asset('images/luxury-intro.png') }}" class="img-fluid rounded-4 shadow-accent-glow" alt="Luxury AR Try-On">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-slider-section {
        height: 80vh;
        margin-top: 70px;
    }
    .hero-swiper {
        width: 100%;
        height: 100%;
    }
    .hero-slide {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    .hero-content {
        max-width: 600px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease;
    }
    .swiper-slide-active .hero-content {
        opacity: 1;
        transform: translateY(0);
    }
    .hero-title {
        font-size: 4rem;
        font-weight: 800;
        color: #fff;
        margin-bottom: 1.5rem;
    }
    .hero-subtitle {
        font-size: 1.5rem;
        color: var(--text);
        margin-bottom: 2.5rem;
    }
    .glass-card {
        background: rgba(31, 40, 51, 0.4);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(241, 229, 172, 0.1);
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }
    .shadow-accent-glow {
        box-shadow: 0 0 30px rgba(241, 229, 172, 0.2);
        border: 1px solid rgba(241, 229, 172, 0.1);
    }
    .rounded-4 {
        border-radius: 1.5rem !important;
    }
    .feature-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        color: var(--accent);
        font-weight: 600;
        font-size: 0.9rem;
        padding: 1rem;
        border-radius: 15px;
        background: rgba(241, 229, 172, 0.05);
        min-width: 120px;
        transition: transform 0.3s ease;
    }
    .feature-badge:hover {
        transform: translateY(-5px);
        background: rgba(241, 229, 172, 0.1);
    }
    .swiper-pagination-bullet {
        background: var(--accent) !important;
    }
    .swiper-button-next, .swiper-button-prev {
        color: var(--accent) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.hero-swiper', {
            loop: true,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            autoplay: { delay: 5000 },
            pagination: { el: '.swiper-pagination', clickable: true },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
        });
    });
</script>

<!-- Features Section -->
<section id="features" class="py-5 features-section">
    <div class="container text-center">
        <h2 class="mb-5 section-title">Why Choose TryMyWatch?</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="feature-heading">Easy-to-Use Interface</h5>
                <p class="feature-description">
                    Simply use your device camera to virtually try on watches in real-time with smooth, intuitive controls.
                </p>
            </div>
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="feature-heading">Secure & Private</h5>
                <p class="feature-description">
                    Your privacy matters. All AR processing happens securely without storing your images or data.
                </p>
            </div>
            <div class="col-md-4 feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock fa-3x text-accent mb-3"></i>
                </div>
                <h5 class="feature-heading">Save Time & Shop Confidently</h5>
                <p class="feature-description">
                    No more guesswork — see exactly how each watch fits your wrist before buying.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section id="how-it-works" class="py-5" style="background: rgba(26, 26, 26, 0.5);">
    <div class="container text-center">
        <h2 class="mb-5 section-title">How It Works</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                    <div class="step-number mb-3" style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">1</div>
                    <h5 class="mb-3">Select a Watch</h5>
                    <p class="small">Browse our curated collection of luxury watches from top brands.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                    <div class="step-number mb-3" style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">2</div>
                    <h5 class="mb-3">Enable Camera</h5>
                    <p class="small">Allow camera access for real-time augmented reality experience.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                    <div class="step-number mb-3" style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">3</div>
                    <h5 class="mb-3">Try It On</h5>
                    <p class="small">See the watch on your wrist with accurate sizing and realistic shadows.</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                    <div class="step-number mb-3" style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">4</div>
                    <h5 class="mb-3">Make Your Decision</h5>
                    <p class="small">Purchase with confidence knowing exactly how the watch looks on you.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Dynamic Featured Products Section -->
<section id="featured-products" class="py-5 mt-5">
    <div class="container text-center mb-5">
        <h2 class="section-title gradient-text">Featured Timepieces</h2>
        <p class="text-secondary-custom">Exquisite craftsmanship meets modern technology.</p>
    </div>
    
    <div class="container pb-5">
        <div class="shop-grid">
            @foreach($products as $index => $product)
                @php
                    $productId = $product->id ?? 1;
                    $productTitle = $product->title ?? 'No Title';
                    $productPrice = $product->price ?? 0;
                    $productThumbnail = $product->thumbnail ?? '';
                    $productCategory = $product->category->name ?? 'Watch';
                    $productDesc = implode(' ', array_slice(explode(' ', strip_tags($product->description ?? $productTitle)), 0, 15)).'...';
                @endphp

                @if($index === 0)
                    <a href="{{ route('product.show', $productId) }}" class="shop-card card-wide animate-fade-in" style="animation-delay: 0.1s">
                        <div class="card-wide-img">
                            @if(!empty($productThumbnail))
                                <img src="{{ $productThumbnail }}" class="watch-img" style="height:260px;" alt="{{ $productTitle }}">
                            @endif
                        </div>
                        <div class="card-wide-content">
                            <div class="card-num">01</div>
                            <div class="card-tag">{{ $productCategory }}</div>
                            <div class="card-name">{{ $productTitle }}</div>
                            <div class="card-wide-desc">{{ $productDesc }}</div>
                            <div class="card-bottom">
                                <div class="card-price gradient-text">${{ number_format((float)$productPrice, 2) }}</div>
                                <div class="card-arrow"><i class="fas fa-arrow-up"></i></div>
                            </div>
                        </div>
                    </a>
                @else
                    <a href="{{ route('product.show', $productId) }}" class="shop-card animate-fade-in" style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                        <div class="card-num">{{ sprintf('%02d', $index + 1) }}</div>
                        <div class="card-tag">{{ $productCategory }}</div>
                        <div class="watch-img-container">
                            @if(!empty($productThumbnail))
                                <img src="{{ $productThumbnail }}" class="watch-img" alt="{{ $productTitle }}">
                            @endif
                        </div>
                        <div class="card-name">{{ $productTitle }}</div>
                        <div class="card-bottom">
                            <div class="card-price gradient-text">${{ number_format((float)$productPrice, 2) }}</div>
                            <div class="card-arrow"><i class="fas fa-arrow-up"></i></div>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section id="testimonials" class="py-5">
    <div class="container text-center">
        <h2 class="mb-5 section-title">What Our Users Say</h2>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded" style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                    <div class="mb-3">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="mb-3">"Finally, a way to try luxury watches without visiting a store. The AR technology is incredibly realistic!"</p>
                    <p class="small text-accent">- Michael R.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded" style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                    <div class="mb-3">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="mb-3">"Saved me from making a $5,000 mistake. The watch looked different online than on my wrist."</p>
                    <p class="small text-accent">- Sarah L.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 rounded" style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                    <div class="mb-3">
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                        <i class="fas fa-star text-accent"></i>
                    </div>
                    <p class="mb-3">"The AI sizing recommendation was spot on. My new watch fits perfectly thanks to TryMyWatch."</p>
                    <p class="small text-accent">- David K.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section id="cta" class="py-5 text-center" style="background: linear-gradient(135deg, rgba(15, 15, 15, 0.9), rgba(201, 169, 110, 0.1));">
    <div class="container">
        <h2 class="mb-4">Ready to Transform Your Watch Shopping Experience?</h2>
        <p class="mb-4 hero-description">Join thousands of satisfied customers who shop watches smarter with AI.</p>
        <!-- <a href="{{ url('/shop') }}" class="btn btn-primary-custom btn-glow" style="font-size: 1.1rem; padding: 1rem 2rem;">
            <i class="fas fa-play-circle me-2"></i>Start Your AR Experience
        </a> -->
    </div>
</section>

<style>
    /* FIX: Remove typewriter animation for hero-title */
    .hero-title {
        font-size: clamp(1.5rem, 4vw, 2.5rem);
        line-height: 1.2;
        margin-bottom: 1rem;
        font-weight: 700;
        overflow: visible !important;
        white-space: normal !important;
        border-right: none !important;
        animation: fadeIn 1s ease-out !important;
    }

    /* Keep gradient text animation */
    .gradient-text {
        background: linear-gradient(90deg, var(--accent), var(--accent-light), var(--accent));
        background-size: 200% auto;
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: shimmer 3s linear infinite;
    }

    /* Fix for hero description animation */
    .hero-description {
        animation: fadeIn 1s ease-out 0.5s both !important;
    }

    /* Additional animations for new sections */
    .step-card {
        transition: all 0.4s ease;
        height: 100%;
        opacity: 0;
        transform: translateY(30px);
    }
    
    .step-card.visible {
        opacity: 1;
        transform: translateY(0);
    }
    
    .step-card:hover {
        transform: translateY(-10px);
        background: rgba(201, 169, 110, 0.15) !important;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
    }
    
    .step-number {
        transition: all 0.3s ease;
    }
    
    .step-card:hover .step-number {
        transform: scale(1.1) rotate(360deg);
        background: var(--accent-light) !important;
    }
    
    .testimonial-card {
        transition: all 0.3s ease;
        height: 100%;
        opacity: 0;
        transform: translateX(-20px);
    }
    
    .testimonial-card.visible {
        opacity: 1;
        transform: translateX(0);
    }
    
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(201, 169, 110, 0.1);
    }
    
    /* Enhanced feature list animation */
    .feature-item i {
        transition: transform 0.3s ease;
    }
    
    .feature-item:hover i {
        transform: scale(1.2) rotate(360deg);
    }
</style>

<script>
    // Fix: Remove typewriter animation and replace with fade-in
    document.addEventListener('DOMContentLoaded', function() {
        // Simple scroll animation for step cards
        const observerOptions = {
            threshold: 0.2,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);
        
        // Observe all animated elements
        document.querySelectorAll('.step-card, .testimonial-card').forEach(el => {
            observer.observe(el);
        });
        
        // Enhanced feature list hover effects
        document.querySelectorAll('.feature-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1.2) rotate(360deg)';
                }
            });
            
            item.addEventListener('mouseleave', function() {
                const icon = this.querySelector('i');
                if (icon) {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }
            });
        });
        
        // Add delay to feature list items for staggered animation
        document.querySelectorAll('.feature-item').forEach((item, index) => {
            item.style.animationDelay = `${0.3 + (index * 0.2)}s`;
        });
    });
</script>
@endsection