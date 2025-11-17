<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TryMyWatch - AI-Powered AR Watch Try-On</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #0f0f0f;
            --secondary: #1a1a1a;
            --accent: #c9a96e;
            --accent-light: #e6d2a9;
            --text: #f5f5f5;
            --text-secondary: #a0a0a0;
        }

        body {
            background-color: var(--primary);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* Header Styles */
        .navbar {
            background: rgba(15, 15, 15, 0.9) !important;
            backdrop-filter: blur(10px);
            padding: 1.5rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 1rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text) !important;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .nav-link {
            color: var(--text) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            position: relative;
        }

        .nav-link:hover {
            color: var(--accent) !important;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-primary-custom {
            background: var(--accent);
            color: var(--primary);
            border: none;
            padding: 0.8rem 1.8rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: var(--accent-light);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(201, 169, 110, 0.3);
            color: var(--primary);
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--accent);
            padding: 0.8rem 1.8rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(201, 169, 110, 0.1);
            transform: translateY(-3px);
            color: var(--text);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .watch-container {
            width: 300px;
            height: 300px;
            position: relative;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
        }

        .watch-face {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            border-radius: 50%;
            position: relative;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .watch-face::before {
            content: '';
            position: absolute;
            width: 90%;
            height: 90%;
            border-radius: 50%;
            background: var(--primary);
            z-index: 1;
        }

        .watch-dial {
            position: absolute;
            width: 85%;
            height: 85%;
            background: linear-gradient(135deg, #0a0a0a, #1a1a1a);
            border-radius: 50%;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.8);
        }

        .watch-brand {
            color: var(--accent);
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 2px;
            z-index: 3;
        }

        .watch-hands {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 3;
        }

        .hand {
            position: absolute;
            background: var(--text);
            transform-origin: bottom center;
            border-radius: 2px;
        }

        .hour-hand {
            width: 4px;
            height: 60px;
            top: 50%;
            left: 50%;
            margin-top: -60px;
            margin-left: -2px;
        }

        .minute-hand {
            width: 3px;
            height: 90px;
            top: 50%;
            left: 50%;
            margin-top: -90px;
            margin-left: -1.5px;
        }

        .second-hand {
            width: 2px;
            height: 100px;
            top: 50%;
            left: 50%;
            margin-top: -100px;
            margin-left: -1px;
            background: var(--accent);
        }

        .watch-crown {
            position: absolute;
            width: 20px;
            height: 20px;
            background: var(--accent);
            border-radius: 50%;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 3;
        }

        .ar-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 15, 15, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s ease;
            border-radius: 20px;
            z-index: 4;
        }

        .watch-container:hover .ar-overlay {
            opacity: 1;
        }

        .ar-text {
            color: var(--text);
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
        }

        .ar-text i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
            color: var(--accent);
        }

        /* Features Section */
        .features {
            padding: 8rem 0;
            background: var(--secondary);
        }

        .feature-card {
            background: var(--primary);
            border-radius: 15px;
            padding: 2.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--accent);
        }

        .feature-icon {
            font-size: 2.5rem;
            color: var(--accent);
            margin-bottom: 1.5rem;
        }

        /* Technology Section */
        .technology {
            padding: 8rem 0;
        }

        .tech-stack .badge {
            background: var(--secondary);
            color: var(--text);
            padding: 0.8rem 1.5rem;
            border-radius: 30px;
            font-size: 0.9rem;
            font-weight: 500;
            margin: 0.5rem;
        }

        .architecture {
            width: 100%;
            max-width: 500px;
            height: 400px;
            background: var(--secondary);
            border-radius: 15px;
            position: relative;
            overflow: hidden;
        }

        .layer {
            position: absolute;
            width: 80%;
            left: 10%;
            height: 60px;
            background: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .layer:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .layer-1 {
            top: 10%;
            border-left: 5px solid #61dafb;
        }

        .layer-2 {
            top: 30%;
            border-left: 5px solid #ff2d20;
        }

        .layer-3 {
            top: 50%;
            border-left: 5px solid #ffca28;
        }

        .layer-4 {
            top: 70%;
            border-left: 5px solid #4db33d;
        }

        /* CTA Section */
        .cta-section {
            padding: 8rem 0;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
        }

        /* Footer */
        footer {
            background: var(--primary);
            padding: 5rem 0 2rem;
        }

        .footer-column h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--accent);
        }

        .footer-column ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-column ul li {
            margin-bottom: 0.8rem;
        }

        .footer-column ul li a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-column ul li a:hover {
            color: var(--accent);
        }

        .social-links a {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            background: var(--secondary);
            border-radius: 50%;
            color: var(--text);
            text-decoration: none;
            transition: all 0.3s ease;
            margin-right: 0.5rem;
        }

        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Text Colors */
        .text-accent {
            color: var(--accent);
        }

        .text-secondary-custom {
            color: var(--text-secondary);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-crown me-2"></i>TryMy<span>Watch</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon text-light"><i class="fas fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#technology">Technology</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <a href="#try-now" class="btn btn-primary-custom ms-lg-3">Try It Now</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Experience Watches in <span class="text-accent">Augmented Reality</span></h1>
                    <p class="lead mb-4 text-secondary-custom">TryMyWatch revolutionizes online shopping with AI-powered AR technology that lets you virtually try on luxury watches in real-time, right from your device.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#try-now" class="btn btn-primary-custom">Try It Now</a>
                        <a href="#features" class="btn btn-outline-custom">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="watch-container mx-auto">
                        <div class="watch-face">
                            <div class="watch-dial">
                                <div class="watch-brand">TRYMYWATCH</div>
                            </div>
                            <div class="watch-hands">
                                <div class="hand hour-hand"></div>
                                <div class="hand minute-hand"></div>
                                <div class="hand second-hand"></div>
                            </div>
                            <div class="watch-crown"></div>
                        </div>
                        <div class="ar-overlay">
                            <div class="ar-text">
                                <i class="fas fa-cube"></i>
                                AR Try-On Experience
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Premium Features</h2>
                    <p class="lead text-secondary-custom mx-auto" style="max-width: 600px;">Discover how TryMyWatch combines cutting-edge technology with luxury shopping experience</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-vr-cardboard"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">AR Try-On</h3>
                        <p class="text-secondary-custom">Real-time augmented reality visualization of watches on your wrist using advanced hand tracking and 3D rendering.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">AI Recommendations</h3>
                        <p class="text-secondary-custom">Intelligent content-based filtering suggests watches that match your style preferences and previous selections.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">AI Chat Assistant</h3>
                        <p class="text-secondary-custom">Natural language processing chatbot provides personalized style advice and answers product questions instantly.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-3">Seamless E-Commerce</h3>
                        <p class="text-secondary-custom">Complete shopping experience with product browsing, cart management, and secure checkout process.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Technology Section -->
    <section class="technology" id="technology">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">Advanced Technology Stack</h2>
                    <p class="lead text-secondary-custom mx-auto" style="max-width: 600px;">Built with cutting-edge technologies for optimal performance and scalability</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-4">Sophisticated Architecture</h2>
                    <p class="text-secondary-custom mb-4">TryMyWatch employs a modular, service-oriented architecture that ensures high performance, scalability, and maintainability.</p>
                    <div class="tech-stack mb-4">
                        <span class="badge">MediaPipe</span>
                        <span class="badge">Three.js</span>
                        <span class="badge">TensorFlow</span>
                        <span class="badge">Laravel</span>
                        <span class="badge">MySQL</span>
                        <span class="badge">Python</span>
                    </div>
                    <p class="text-secondary-custom mb-4">The platform seamlessly integrates AR visualization, AI recommendations, and e-commerce functionality into a cohesive user experience.</p>
                    <a href="#" class="btn btn-primary-custom">Technical Details</a>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <div class="architecture mx-auto">
                        <div class="layer layer-1">Presentation Layer (HTML5, CSS, JavaScript, Three.js)</div>
                        <div class="layer layer-2">Application Layer (Laravel, RESTful APIs)</div>
                        <div class="layer layer-3">AI Layer (Python, TensorFlow, Flask)</div>
                        <div class="layer layer-4">Data Layer (MySQL Database)</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section text-center" id="try-now">
        <div class="container">
            <h2 class="display-5 fw-bold mb-4">Ready to Transform Your Watch Shopping Experience?</h2>
            <p class="lead text-secondary-custom mb-5 mx-auto" style="max-width: 600px;">Join the future of e-commerce with our AI-powered AR platform. Try on luxury watches virtually before making a purchase decision.</p>
            <a href="#" class="btn btn-primary-custom btn-lg">Start Your AR Experience</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <h3>TryMyWatch</h3>
                    <p class="text-secondary-custom mt-3">Revolutionizing online watch shopping with AI and Augmented Reality technology.</p>
                    <div class="social-links mt-4">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h3>Quick Links</h3>
                    <ul class="mt-3">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#technology">Technology</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h3>Technology</h3>
                    <ul class="mt-3">
                        <li><a href="#">AR Try-On</a></li>
                        <li><a href="#">AI Recommendations</a></li>
                        <li><a href="#">Chat Assistant</a></li>
                        <li><a href="#">E-Commerce</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-3">
                    <h3>Contact Info</h3>
                    <ul class="mt-3">
                        <li class="text-secondary-custom"><i class="fas fa-map-marker-alt me-2 text-accent"></i> University of Management and Technology</li>
                        <li class="text-secondary-custom"><i class="fas fa-envelope me-2 text-accent"></i> contact@trymywatch.com</li>
                        <li class="text-secondary-custom"><i class="fas fa-phone me-2 text-accent"></i> +1 (555) 123-4567</li>
                    </ul>
                </div>
            </div>
            <div class="copyright mt-5">
                <p>&copy; 2023 TryMyWatch - AI-Powered AR Watch Try-On Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Animate watch hands
        function updateWatchHands() {
            const now = new Date();
            const seconds = now.getSeconds();
            const minutes = now.getMinutes();
            const hours = now.getHours() % 12;

            const secondHand = document.querySelector('.second-hand');
            const minuteHand = document.querySelector('.minute-hand');
            const hourHand = document.querySelector('.hour-hand');

            const secondsDegrees = ((seconds / 60) * 360) + 90;
            const minutesDegrees = ((minutes / 60) * 360) + ((seconds / 60) * 6) + 90;
            const hoursDegrees = ((hours / 12) * 360) + ((minutes / 60) * 30) + 90;

            secondHand.style.transform = `rotate(${secondsDegrees}deg)`;
            minuteHand.style.transform = `rotate(${minutesDegrees}deg)`;
            hourHand.style.transform = `rotate(${hoursDegrees}deg)`;
        }

        setInterval(updateWatchHands, 1000);
        updateWatchHands(); // Initialize immediately
    </script>
</body>
</html>
-->
