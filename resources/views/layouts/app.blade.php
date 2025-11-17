<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TryMyWatch - AI-Powered AR Watch Try-On')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Enhanced CSS with responsive improvements */
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
            background: rgba(15, 15, 15, 0.95) !important;
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 0.75rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-size: 1.5rem;
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
            font-size: 0.95rem;
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

        /* Button Styles */
        .btn-primary-custom {
            background: var(--accent);
            color: var(--primary);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background: var(--accent-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(201, 169, 110, 0.3);
            color: var(--primary);
        }

        .btn-outline-custom {
            background: transparent;
            color: var(--text);
            border: 2px solid var(--accent);
            padding: 0.75rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(201, 169, 110, 0.1);
            transform: translateY(-2px);
            color: var(--text);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 2rem 0;
        }

        /* Enhanced Text Sizes */
        .hero-title {
            font-size: 2.25rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }

        .hero-description {
            font-size: 1.05rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .feature-list {
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .feature-list li {
            margin-bottom: 0.5rem;
        }

        /* Watch Container */
        .watch-container {
            width: 280px;
            height: 280px;
            position: relative;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
            margin: 2rem auto;
        }

        .watch-face {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1a1a1a, #2a2a2a);
            border-radius: 50%;
            position: relative;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
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
            box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.8);
        }

        .watch-brand {
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1.5px;
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
            width: 3px;
            height: 50px;
            top: 50%;
            left: 50%;
            margin-top: -50px;
            margin-left: -1.5px;
        }

        .minute-hand {
            width: 2px;
            height: 70px;
            top: 50%;
            left: 50%;
            margin-top: -70px;
            margin-left: -1px;
        }

        .second-hand {
            width: 1px;
            height: 80px;
            top: 50%;
            left: 50%;
            margin-top: -80px;
            margin-left: -0.5px;
            background: var(--accent);
        }

        .watch-crown {
            position: absolute;
            width: 16px;
            height: 16px;
            background: var(--accent);
            border-radius: 50%;
            right: -8px;
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
            background: rgba(15, 15, 15, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.5s ease;
            border-radius: 15px;
            z-index: 4;
        }

        .watch-container:hover .ar-overlay {
            opacity: 1;
        }

        .ar-text {
            color: var(--text);
            font-size: 0.9rem;
            font-weight: 600;
            text-align: center;
        }

        .ar-text i {
            font-size: 1.5rem;
            margin-bottom: 8px;
            display: block;
            color: var(--accent);
        }

        /* Text Colors */
        .text-accent {
            color: var(--accent);
        }

        .text-secondary-custom {
            color: var(--text-secondary);
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        /* Enhanced Text Effects */
        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced Animations */
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 1s ease-out 0.3s both;
        }

        .feature-item {
            animation: slideInUp 0.6s ease-out both;
        }

        .feature-item:nth-child(1) {
            animation-delay: 0.6s;
        }

        .feature-item:nth-child(2) {
            animation-delay: 0.8s;
        }

        .feature-item:nth-child(3) {
            animation-delay: 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced Button Effects */
        .btn-glow {
            position: relative;
            overflow: hidden;
        }

        .btn-glow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-glow:hover::before {
            left: 100%;
        }

        .btn-slide {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: var(--accent);
            transition: all 0.3s ease;
            z-index: -1;
        }

        .btn-slide:hover::before {
            width: 100%;
            opacity: 0.1;
        }

        /* Enhanced Watch Design */
        .watch-indicators {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 3;
        }

        .watch-indicator {
            position: absolute;
            width: 3px;
            height: 10px;
            background: var(--accent);
            left: 50%;
            top: 8px;
            margin-left: -1.5px;
            transform-origin: center 120px;
        }

        .indicator-1 {
            transform: rotate(0deg);
        }

        .indicator-2 {
            transform: rotate(30deg);
        }

        .indicator-3 {
            transform: rotate(60deg);
        }

        .indicator-4 {
            transform: rotate(90deg);
        }

        .indicator-5 {
            transform: rotate(120deg);
        }

        .indicator-6 {
            transform: rotate(150deg);
        }

        .indicator-7 {
            transform: rotate(180deg);
        }

        .indicator-8 {
            transform: rotate(210deg);
        }

        .indicator-9 {
            transform: rotate(240deg);
        }

        .indicator-10 {
            transform: rotate(270deg);
        }

        .indicator-11 {
            transform: rotate(300deg);
        }

        .indicator-12 {
            transform: rotate(330deg);
        }

        .watch-bezel {
            position: absolute;
            width: 95%;
            height: 95%;
            border: 1.5px solid var(--accent);
            border-radius: 50%;
            z-index: 4;
            opacity: 0.3;
        }

        /* Dark modal background and text */
        .modal-content {
            background-color: #121212;
            /* dark black */
            color: #f0f0f0;
            /* light text */
            border-radius: 8px;
            border: none;
        }

        .modal-header,
        .modal-footer {
            border-color: #222;
            /* darker border */
        }

        .btn-close {
            filter: invert(1);
            /* Make close icon visible on dark background */
        }

        .modal-body p,
        .modal-body ul.list-group li {
            color: #ddd;
        }

        .btn-danger {
            background-color: #b33939;
            border-color: #8b2e2e;
        }

        .btn-primary {
            background-color: #1f6feb;
            border-color: #185bcc;
        }

        /* Scrollbar for modal-body if content overflows */
        .modal-dialog-scrollable .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }


        .watch-glow {
            position: absolute;
            width: 110%;
            height: 110%;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }

        .watch-container:hover .watch-glow {
            opacity: 0.1;
        }

        /* Features Section */
        .features-section {
            background: linear-gradient(180deg, var(--primary) 0%, rgba(26, 26, 26, 0.3) 100%);
            padding: 4rem 0;
        }

        .section-title {
            position: relative;
            display: inline-block;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 3rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: var(--accent);
            border-radius: 2px;
        }

        /* Enhanced Feature Cards */
        .feature-card {
            transition: all 0.3s ease;
            padding: 1.5rem 1rem;
            border-radius: 12px;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            background: rgba(201, 169, 110, 0.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
        }

        .feature-icon {
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .feature-icon .fas {
            font-size: 2.25rem !important;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-heading {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .feature-description {
            font-size: 0.9rem;
            line-height: 1.5;
            color: var(--text-secondary);
        }

        /* Button Group Animation */
        .button-group {
            animation: fadeIn 1s ease-out 1.2s both;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .hero-title {
                font-size: 2rem;
            }

            .watch-container {
                width: 250px;
                height: 250px;
            }
        }

        @media (max-width: 992px) {
            .hero {
                text-align: center;
                padding: 4rem 0;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .hero-description {
                font-size: 1rem;
            }

            .watch-container {
                width: 220px;
                height: 220px;
                margin: 3rem auto 1rem;
            }

            .section-title {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }

            .nav-link {
                font-size: 0.9rem;
                margin: 0 0.3rem;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-description {
                font-size: 0.95rem;
            }

            .feature-list {
                font-size: 0.9rem;
            }

            .btn-primary-custom,
            .btn-outline-custom {
                padding: 0.65rem 1.25rem;
                font-size: 0.9rem;
            }

            .watch-container {
                width: 200px;
                height: 200px;
            }

            .watch-brand {
                font-size: 0.8rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .feature-heading {
                font-size: 1rem;
            }

            .feature-description {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .hero {
                padding: 3rem 0;
                min-height: auto;
            }

            .hero-title {
                font-size: 1.35rem;
                margin-bottom: 1rem;
            }

            .hero-description {
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }

            .feature-list {
                font-size: 0.85rem;
            }

            .button-group {
                justify-content: center;
            }

            .btn-primary-custom,
            .btn-outline-custom {
                width: 100%;
                max-width: 200px;
                margin: 0.25rem 0;
            }

            .watch-container {
                width: 180px;
                height: 180px;
            }

            .features-section {
                padding: 3rem 0;
            }

            .section-title {
                font-size: 1.35rem;
            }

            .feature-card {
                padding: 1.25rem 0.75rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 400px) {
            .watch-container {
                width: 160px;
                height: 160px;
            }

            .hero-title {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Enhanced scroll effect with throttle
        let scrollTimeout;
        window.addEventListener('scroll', function () {
            const navbar = document.getElementById('navbar');

            if (!navbar) return;

            // Clear the timeout if it's already set
            clearTimeout(scrollTimeout);

            // Set a new timeout
            scrollTimeout = setTimeout(function () {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }, 10);
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                }
            });
        }, observerOptions);

        // Observe feature cards and other elements
        document.addEventListener('DOMContentLoaded', function () {
            const featureCards = document.querySelectorAll('.feature-card');
            const animateElements = document.querySelectorAll('.animate-fade-in, .slide-in-left');

            featureCards.forEach(card => {
                observer.observe(card);
            });

            animateElements.forEach(element => {
                observer.observe(element);
            });
        });

        // Enhanced watch hand animation with smooth transitions
        function updateWatchHands() {
            const now = new Date();
            const seconds = now.getSeconds();
            const minutes = now.getMinutes();
            const hours = now.getHours() % 12;

            const secondHand = document.querySelector('.second-hand');
            const minuteHand = document.querySelector('.minute-hand');
            const hourHand = document.querySelector('.hour-hand');

            if (!secondHand || !minuteHand || !hourHand) return;

            const secondsDegrees = ((seconds / 60) * 360) + 90;
            const minutesDegrees = ((minutes / 60) * 360) + ((seconds / 60) * 6) + 90;
            const hoursDegrees = ((hours / 12) * 360) + ((minutes / 60) * 30) + 90;

            // Add smooth transition only for hour and minute hands
            minuteHand.style.transition = seconds === 0 ? 'none' : 'transform 0.3s cubic-bezier(0.4, 2.3, 0.8, 1)';
            hourHand.style.transition = seconds === 0 ? 'none' : 'transform 0.3s cubic-bezier(0.4, 2.3, 0.8, 1)';

            secondHand.style.transform = `rotate(${secondsDegrees}deg)`;
            minuteHand.style.transform = `rotate(${minutesDegrees}deg)`;
            hourHand.style.transform = `rotate(${hoursDegrees}deg)`;
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function () {
            updateWatchHands();
            setInterval(updateWatchHands, 1000);

            // Add loaded class for any future animations
            document.body.classList.add('loaded');
        });
    </script>

    @stack('scripts')
</body>

</html>