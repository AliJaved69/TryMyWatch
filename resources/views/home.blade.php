@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left content: Headline + Description + Buttons -->
            <div class="col-lg-6" style="margin-top: 30px;">
                <h1 class="hero-title animate-fade-in">
                    Discover the Future of Watch Shopping with 
                    <span class="text-accent gradient-text">AI-Powered AR</span>
                </h1>
                <p class="hero-description text-secondary-custom slide-in-left">
                    Experience luxury watch shopping like never before. Our cutting-edge AI technology combined with augmented reality lets you try on premium watches virtually, seeing exactly how they look on your wrist in real-time from the comfort of your home.
                </p>
                <ul class="mb-4 text-secondary-custom feature-list" style="list-style: none; padding-left: 0;">
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>Photorealistic virtual try-on with 98% accuracy</li>
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>Curated collection of 50+ luxury watch brands</li>
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i>AI-powered size & fit recommendations</li>
                    <li class="feature-item"><i class="fas fa-check-circle text-accent me-2"></i><a href="{{ route('watch.try', $watch->id) }}" class="text-decoration-none">Try Now</a></li>   
                </ul>
                <!-- <div class="d-flex flex-wrap gap-3 button-group">
                    <a href="{{ url('/shop') }}" class="btn btn-primary-custom btn-glow">Try It Now</a>
                    <a href="#features" class="btn btn-outline-custom btn-slide">Learn More</a>
                </div> -->
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