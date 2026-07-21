@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    @php
        // Build slides from the latest products' images; fall back to static assets.
        $heroSlides = collect($products ?? [])
            ->map(fn($p) => $p->thumbnail)
            ->filter()
            ->values();

        if ($heroSlides->isEmpty()) {
            $heroSlides = collect([
                asset('images/hero_watch_display.png'),
                asset('images/luxury-intro.png'),
                asset('images/poster_ar_preview.png'),
            ]);
        }
    @endphp
    <section class="hero-section">
        <div class="hero-slider" id="heroSlider" data-interval="4500">
            <!-- Rotating background images -->
            <div class="hero-slides">
                @foreach ($heroSlides as $i => $img)
                    <div class="hero-slide {{ $i === 0 ? 'active' : '' }}"
                        style="background-image: url('{{ $img }}');"></div>
                @endforeach
            </div>
            <div class="hero-slider-overlay"></div>

            <!-- Text content (stays constant while images rotate) -->
            <div class="container h-100 d-flex align-items-center position-relative" style="z-index: 3;">
                <div class="hero-content">
                    <h1 class="hero-title animate-fade-in">Timeless <span class="text-accent">Elegance</span> & AI
                        Innovation</h1>
                    <p class="hero-subtitle animate-fade-in" style="animation-delay: 0.2s;">Discover a curated
                        collection of luxury timepieces and experience real-time AI-powered AR try-on directly on your
                        wrist.</p>
                    <div class="d-flex gap-3 animate-fade-in" style="animation-delay: 0.4s;">
                        <a href="{{ url('/shop') }}" class="btn btn-primary-custom shadow-accent-glow px-4 py-3">Explore
                            Collection</a>
                    </div>
                </div>
            </div>

            @if ($heroSlides->count() > 1)
                <!-- Prev / Next controls -->
                <button class="hero-arrow hero-arrow-prev" type="button" aria-label="Previous slide">&#10094;</button>
                <button class="hero-arrow hero-arrow-next" type="button" aria-label="Next slide">&#10095;</button>

                <!-- Dot indicators -->
                <div class="hero-dots">
                    @foreach ($heroSlides as $i => $img)
                        <button class="hero-dot {{ $i === 0 ? 'active' : '' }}" type="button" data-index="{{ $i }}"
                            aria-label="Go to slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>
            @endif
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
                            At TryMyWatch, we bridge the gap between digital convenience and the tactile allure of fine
                            watchmaking. Our "New Idea" is simple yet revolutionary: **Real-time AI wrist synthesis**.
                        </p>
                        <p class="text-secondary-custom mb-5 pe-lg-5">
                            Gone are the days of guessing. With our advanced AR models and newly launched **AI Static
                            Try-On**, you can instantly see a variety of premium watches rendered with photorealistic
                            accuracy, lighting, and fit on your own wrist.
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
                            <img src="{{ asset('images/luxury-intro.png') }}" class="img-fluid rounded-4 shadow-accent-glow"
                                alt="Luxury AR Try-On">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hero-section {
            height: 85vh;
            margin-top: 70px;
            position: relative;
            overflow: hidden;
            background: #06070a;
            display: flex;
            align-items: center;
        }

        /* Rotating image slider */
        .hero-slider {
            position: absolute;
            inset: 0;
        }

        .hero-slides {
            position: absolute;
            inset: 0;
            z-index: 1;
        }

        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0;
            transition: opacity 1.2s ease-in-out;
        }

        .hero-slide.active {
            opacity: 1;
            animation: heroZoom 6s ease-out forwards;
        }

        @keyframes heroZoom {
            from {
                transform: scale(1.08);
            }

            to {
                transform: scale(1);
            }
        }

        .hero-slider-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
            background: linear-gradient(90deg, rgba(6, 7, 10, 0.92) 0%, rgba(6, 7, 10, 0.65) 42%, rgba(6, 7, 10, 0.25) 100%);
        }

        .hero-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 4;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 1px solid rgba(241, 229, 172, 0.4);
            background: rgba(6, 7, 10, 0.4);
            color: var(--accent);
            font-size: 1.2rem;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .hero-arrow:hover {
            background: rgba(241, 229, 172, 0.18);
        }

        .hero-arrow-prev {
            left: 22px;
        }

        .hero-arrow-next {
            right: 22px;
        }

        .hero-dots {
            position: absolute;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 4;
            display: flex;
            gap: 10px;
        }

        .hero-dot {
            width: 10px;
            height: 10px;
            padding: 0;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
        }

        .hero-dot.active {
            width: 26px;
            border-radius: 6px;
            background: var(--accent);
        }

        @media (max-width: 576px) {
            .hero-arrow {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .hero-arrow-prev {
                left: 10px;
            }

            .hero-arrow-next {
                right: 10px;
            }
        }

        .hero-content {
            max-width: 750px;
            position: relative;
            z-index: 3;
            text-align: left;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 1.5rem;
            line-height: 1.15;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.9), 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        .hero-subtitle {
            font-size: 1.35rem;
            color: var(--text-secondary);
            margin-bottom: 2.5rem;
            line-height: 1.6;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.9), 0 1px 3px rgba(0, 0, 0, 0.7);
        }

        .glass-card {
            background: rgba(31, 40, 51, 0.4);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(241, 229, 172, 0.1);
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
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
    </style>

    <script>
        (function () {
            const slider = document.getElementById('heroSlider');
            if (!slider) return;

            const slides = Array.from(slider.querySelectorAll('.hero-slide'));
            const dots = Array.from(slider.querySelectorAll('.hero-dot'));
            if (slides.length <= 1) return;

            const interval = parseInt(slider.dataset.interval, 10) || 4500;
            let current = 0;
            let timer = null;

            function show(index) {
                current = (index + slides.length) % slides.length;
                slides.forEach((s, i) => s.classList.toggle('active', i === current));
                dots.forEach((d, i) => d.classList.toggle('active', i === current));
            }

            const next = () => show(current + 1);
            const prev = () => show(current - 1);
            const start = () => { stop(); timer = setInterval(next, interval); };
            function stop() { if (timer) { clearInterval(timer); timer = null; } }

            slider.querySelector('.hero-arrow-next')?.addEventListener('click', () => { next(); start(); });
            slider.querySelector('.hero-arrow-prev')?.addEventListener('click', () => { prev(); start(); });
            dots.forEach(d => d.addEventListener('click', () => { show(parseInt(d.dataset.index, 10)); start(); }));

            // Pause auto-rotation while the user hovers the hero.
            slider.addEventListener('mouseenter', stop);
            slider.addEventListener('mouseleave', start);

            start();
        })();
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
                        Simply use your device camera to virtually try on watches in real-time with smooth, intuitive
                        controls.
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
                        <div class="step-number mb-3"
                            style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">
                            1</div>
                        <h5 class="mb-3">Select a Watch</h5>
                        <p class="small">Browse our curated collection of luxury watches from top brands.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                        <div class="step-number mb-3"
                            style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">
                            2</div>
                        <h5 class="mb-3">Enable Camera</h5>
                        <p class="small">Allow camera access for real-time augmented reality experience.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                        <div class="step-number mb-3"
                            style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">
                            3</div>
                        <h5 class="mb-3">Try It On</h5>
                        <p class="small">See the watch on your wrist with accurate sizing and realistic shadows.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="step-card p-4 rounded" style="background: rgba(201, 169, 110, 0.1);">
                        <div class="step-number mb-3"
                            style="width: 50px; height: 50px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; font-weight: bold; color: var(--primary);">
                            4</div>
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
                        $productCategory = is_object($product->category) ? ($product->category->name ?? 'Watch') : ($product->category ?? 'Watch');
                        $productDesc = implode(' ', array_slice(explode(' ', strip_tags($product->description ?? $productTitle)), 0, 15)) . '...';
                    @endphp

                    @if($index === 0)
                        <a href="{{ route('product.show', $productId) }}" class="shop-card card-wide animate-fade-in glare-hover"
                            style="animation-delay: 0.1s">
                            <div class="card-wide-img">
                                @if(!empty($productThumbnail))
                                    <img src="{{ $productThumbnail }}" class="watch-img" style="height:260px;"
                                        alt="{{ $productTitle }}">
                                @endif
                            </div>
                            <div class="card-wide-content">
                                <div class="card-num">01</div>
                                <div class="card-tag">{{ $productCategory }}</div>
                                <div class="card-name">{{ $productTitle }}</div>
                                <div class="card-wide-desc">{{ $productDesc }}</div>
                                <div class="card-bottom">
                                    <div class="card-price gradient-text">${{ number_format((float) $productPrice, 2) }}</div>
                                </div>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('product.show', $productId) }}" class="shop-card animate-fade-in glare-hover"
                            style="animation-delay: {{ 0.1 * ($index + 1) }}s">
                            <div class="card-num">{{ sprintf('%02d', $index + 1) }}</div>
                            <div class="card-tag">{{ $productCategory }}</div>
                            <div class="watch-img-container">
                                @if(!empty($productThumbnail))
                                    <img src="{{ $productThumbnail }}" class="watch-img" alt="{{ $productTitle }}">
                                @endif
                            </div>
                            <div class="card-name">{{ $productTitle }}</div>
                            <div class="card-bottom">
                                <div class="card-price gradient-text">${{ number_format((float) $productPrice, 2) }}</div>
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
                    <div class="testimonial-card p-4 rounded"
                        style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                        <div class="mb-3">
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                        </div>
                        <p class="mb-3">"Finally, a way to try luxury watches without visiting a store. The AR technology is
                            incredibly realistic!"</p>
                        <p class="small text-accent">- Michael R.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 rounded"
                        style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                        <div class="mb-3">
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                        </div>
                        <p class="mb-3">"Saved me from making a $5,000 mistake. The watch looked different online than on my
                            wrist."</p>
                        <p class="small text-accent">- Sarah L.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card p-4 rounded"
                        style="background: rgba(26, 26, 26, 0.7); border-left: 4px solid var(--accent);">
                        <div class="mb-3">
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                            <i class="fas fa-star text-accent"></i>
                        </div>
                        <p class="mb-3">"The AI sizing recommendation was spot on. My new watch fits perfectly thanks to
                            TryMyWatch."</p>
                        <p class="small text-accent">- David K.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section id="cta" class="py-5 text-center"
        style="background: linear-gradient(135deg, rgba(15, 15, 15, 0.9), rgba(201, 169, 110, 0.1));">
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
        document.addEventListener('DOMContentLoaded', function () {
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
                item.addEventListener('mouseenter', function () {
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.style.transform = 'scale(1.2) rotate(360deg)';
                    }
                });

                item.addEventListener('mouseleave', function () {
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