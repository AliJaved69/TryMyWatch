<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'TryMyWatch - AI-Powered AR Watch Try-On')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <style>
        /* === YOUR FULL EXISTING CSS === */
        :root {
            --primary: #0B0C10;
            --secondary: #1F2833;
            --accent: #F1E5AC;
            --accent-light: #E0BFB8;
            --text: #C5C6C7;
            --text-secondary: #9BA4B4;
            --highlight: #0F52BA;
        }

        body {
            background-color: var(--primary);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        /* === ENHANCED ANIMATIONS SECTION === */

        /* Floating animation for feature cards */
        @keyframes float-card {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .feature-card:hover {
            animation: float-card 3s ease-in-out infinite;
        }

        /* Pulse animation for CTA buttons */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 10px rgba(201, 169, 110, 0.3);
            }
            50% {
                box-shadow: 0 0 25px rgba(201, 169, 110, 0.6);
            }
        }

        .btn-primary-custom {
            animation: pulse-glow 2s infinite;
        }

        .btn-primary-custom:hover {
            animation: none;
        }

        /* Shimmer effect for text */
        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }
            100% {
                background-position: 200% center;
            }
        }

        .gradient-text {
            background: linear-gradient(90deg, var(--accent), var(--accent-light), var(--accent));
            background-size: 200% auto;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shimmer 3s linear infinite;
        }

        /* Rotating watch bezel */
        @keyframes rotate-bezel {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .watch-bezel {
            animation: rotate-bezel 60s linear infinite;
        }

        .watch-container:hover .watch-bezel {
            animation-duration: 30s;
        }

        /* Bounce animation for indicators */
        @keyframes bounce-indicator {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        .watch-indicator:nth-child(3n) {
            animation: bounce-indicator 2s ease-in-out infinite;
        }

        .watch-indicator:nth-child(3n+1) {
            animation: bounce-indicator 2s ease-in-out infinite 0.5s;
        }

        .watch-indicator:nth-child(3n+2) {
            animation: bounce-indicator 2s ease-in-out infinite 1s;
        }

        /* Wave animation for AR overlay */
        @keyframes wave {
            0% {
                transform: translateY(0) scale(1);
                opacity: 0.5;
            }
            50% {
                transform: translateY(-10px) scale(1.1);
                opacity: 0.8;
            }
            100% {
                transform: translateY(0) scale(1);
                opacity: 0.5;
            }
        }

        .ar-text i {
            animation: wave 2s ease-in-out infinite;
        }

        /* Slide-in animation for page load */
        @keyframes slide-in-bg {
            from {
                clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
            }
            to {
                clip-path: polygon(0 0, 100% 0, 100% 100%, 0 100%);
            }
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            z-index: -1;
            animation: slide-in-bg 1.5s ease-out forwards;
        }

        /* Typewriter effect for hero text */
        @keyframes typewriter {
            from {
                width: 0;
            }
            to {
                width: 100%;
            }
        }

        @keyframes blink-caret {
            from, to {
                border-color: transparent;
            }
            50% {
                border-color: var(--accent);
            }
        }

        .hero-title {
            overflow: hidden;
            border-right: 2px solid var(--accent);
            white-space: nowrap;
            animation: 
                typewriter 3.5s steps(40, end),
                blink-caret 0.75s step-end infinite;
        }

        /* Fade-in stagger for nav items */
        .nav-item {
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }

        .nav-item:nth-child(1) { animation-delay: 0.2s; }
        .nav-item:nth-child(2) { animation-delay: 0.3s; }
        .nav-item:nth-child(3) { animation-delay: 0.4s; }
        .nav-item:nth-child(4) { animation-delay: 0.5s; }
        .nav-item:nth-child(5) { animation-delay: 0.6s; }

        /* Hover ripple effect for buttons */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .btn-ripple::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-ripple:hover::after {
            width: 300px;
            height: 300px;
        }

        /* Glitch effect for watch brand */
        @keyframes glitch {
            0% {
                transform: translate(0);
            }
            20% {
                transform: translate(-2px, 2px);
            }
            40% {
                transform: translate(-2px, -2px);
            }
            60% {
                transform: translate(2px, 2px);
            }
            80% {
                transform: translate(2px, -2px);
            }
            100% {
                transform: translate(0);
            }
        }

        .watch-brand {
            animation: glitch 5s infinite;
        }

        /* Breathing animation for watch container */
        @keyframes breathing {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        .watch-container {
            animation: 
                float 6s ease-in-out infinite,
                breathing 8s ease-in-out infinite;
        }

        /* Enhanced modal entrance */
        @keyframes modal-entrance {
            0% {
                opacity: 0;
                transform: scale(0.7) rotateX(-30deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotateX(0);
            }
        }

        .modal-content {
            animation: modal-entrance 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Staggered fade-in for feature list */
        .feature-list li {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideInLeft 0.5s ease-out forwards;
        }

        .feature-list li:nth-child(1) { animation-delay: 0.3s; }
        .feature-list li:nth-child(2) { animation-delay: 0.5s; }
        .feature-list li:nth-child(3) { animation-delay: 0.7s; }

        /* Neon border animation */
        @keyframes neon-border {
            0%, 100% {
                box-shadow: 
                    0 0 5px var(--accent),
                    inset 0 0 5px var(--accent);
            }
            50% {
                box-shadow: 
                    0 0 20px var(--accent),
                    inset 0 0 10px var(--accent);
            }
        }

        .watch-face {
            animation: neon-border 4s ease-in-out infinite;
        }

        /* Shake animation for cart notification */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        #cartCount {
            animation: shake 0.5s;
        }

        /* Loading spinner for async operations */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid var(--accent);
            border-top-color: transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* === GLOBAL LUXURY UTILITIES === */
        .glass-card {
            background: rgba(31, 40, 51, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(241, 229, 172, 0.1);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(241, 229, 172, 0.3);
            box-shadow: 0 20px 45px rgba(241, 229, 172, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: inline-block;
        }

        .shadow-accent-glow {
            box-shadow: 0 0 25px rgba(241, 229, 172, 0.15);
        }

        .premium-input {
            background: rgba(11, 12, 16, 0.8) !important;
            border: 1px solid rgba(197, 198, 199, 0.2) !important;
            color: var(--text) !important;
            border-radius: 12px !important;
            padding: 12px 20px !important;
            transition: all 0.3s ease !important;
        }

        .premium-input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 15px rgba(241, 229, 172, 0.2) !important;
            outline: none !important;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -1px;
        }

        .text-silver {
            color: var(--text) !important;
        }

        .bg-onyx {
            background-color: var(--primary);
        }

        .bg-slate {
            background-color: var(--secondary);
        }

        /* Responsive Mobile Tweak */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2.5rem;
            }
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
            padding: 1rem 0;
        }

        /* Responsive Text Sizes */
        .hero-title {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            line-height: 1.2;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .hero-description {
            font-size: clamp(0.9rem, 2vw, 1.1rem);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .feature-list {
            font-size: clamp(0.85rem, 1.8vw, 0.95rem);
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
            transition: transform 0.05s cubic-bezier(0.4, 2.3, 0.8, 1);
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
            transition: transform 0.2s cubic-bezier(0.4, 2.3, 0.8, 1);
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
            0%, 100% {
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
            background-color: black;
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
            padding: 3rem 0;
        }

        /* Enhanced Section Titles */
        .section-title {
            position: relative;
            display: inline-block;
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 700;
            margin-bottom: 2rem;
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

        /* Feature Card Text */
        .feature-heading {
            font-size: clamp(1rem, 2vw, 1.1rem);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .feature-description {
            font-size: clamp(0.85rem, 1.8vw, 0.9rem);
            line-height: 1.5;
            color: var(--text-secondary);
        }

        /* Button Text Sizes */
        .btn-primary-custom,
        .btn-outline-custom {
            font-size: clamp(0.85rem, 1.8vw, 0.95rem);
            padding: 0.75rem 1.5rem;
        }

        /* Button Group Animation */
        .button-group {
            animation: fadeIn 1s ease-out 1.2s both;
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .watch-container {
                width: 250px;
                height: 250px;
            }
        }

        @media (max-width: 992px) {
            .hero {
                text-align: center;
                padding: 3rem 0;
            }

            .watch-container {
                width: 220px;
                height: 220px;
                margin: 2rem auto 1rem;
            }

            .hero .row {
                flex-direction: column-reverse;
            }
        }

        @media (max-width: 576px) {
            .btn-primary-custom,
            .btn-outline-custom {
                width: 100%;
                padding: 1rem;
            }
        }

        /* NEW: Watch dial reload animation */
        .watch-dial-reload {
            animation: dialReload 1.5s ease-out;
        }

        @keyframes dialReload {
            0% {
                opacity: 0;
                transform: scale(0.8) rotate(-180deg);
            }
            70% {
                opacity: 1;
                transform: scale(1.05) rotate(10deg);
            }
            100% {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        /* NEW: Watch hands reload animation */
        .watch-hands-reload {
            animation: handsReload 2s ease-out;
        }

        @keyframes handsReload {
            0% {
                opacity: 0;
                transform: rotate(180deg);
            }
            100% {
                opacity: 1;
                transform: rotate(0deg);
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

    <!-- CART MODAL -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cartItems">
                        <p>Your cart is empty.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="clearCartBtn" class="btn btn-danger">Clear Cart</button>
                    <button type="button" id="checkoutBtn" class="btn btn-primary">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <script>
        // === NEW: WATCH RELOAD ANIMATION ===
        function animateWatchOnLoad() {
            const watchDial = document.querySelector('.watch-dial');
            const watchHands = document.querySelector('.watch-hands');

            // Reset and animate the watch dial
            if (watchDial) {
                watchDial.classList.add('watch-dial-reload');
            }

            // Reset and animate the watch hands
            if (watchHands) {
                watchHands.classList.add('watch-hands-reload');
            }

            // Remove animation classes after animation completes
            setTimeout(() => {
                if (watchDial) {
                    watchDial.classList.remove('watch-dial-reload');
                }
                if (watchHands) {
                    watchHands.classList.remove('watch-hands-reload');
                }
            }, 2000);
        }

        // === CREATE PARTICLE EFFECT ===
        function createParticles() {
            const particlesContainer = document.createElement('div');
            particlesContainer.className = 'particles';
            document.body.appendChild(particlesContainer);

            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                // Random size
                const size = Math.random() * 3 + 1;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}vw`;
                particle.style.top = `${Math.random() * 100}vh`;
                
                // Random opacity
                particle.style.opacity = Math.random() * 0.3 + 0.1;
                
                // Random animation duration
                const duration = Math.random() * 20 + 10;
                particle.style.animationDuration = `${duration}s`;
                
                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 5}s`;
                
                particlesContainer.appendChild(particle);
            }
        }

        // === EXISTING WATCH HANDS ANIMATION ===
        const hourHand = document.querySelector('.hour-hand');
        const minuteHand = document.querySelector('.minute-hand');
        const secondHand = document.querySelector('.second-hand');

        function setClock() {
            const now = new Date();
            const seconds = now.getSeconds();
            const minutes = now.getMinutes();
            const hours = now.getHours();

            const secondsDegrees = ((seconds / 60) * 360) + 90;
            const minutesDegrees = ((minutes / 60) * 360) + ((seconds / 60) * 6) + 90;
            const hoursDegrees = ((hours / 12) * 360) + ((minutes / 60) * 30) + 90;

            if (secondHand)
                secondHand.style.transform = `rotate(${secondsDegrees}deg)`;
            if (minuteHand)
                minuteHand.style.transform = `rotate(${minutesDegrees}deg)`;
            if (hourHand)
                hourHand.style.transform = `rotate(${hoursDegrees}deg)`;
        }

        // === ADD RIPPLE EFFECT TO BUTTONS ===
        function addRippleEffect() {
            const buttons = document.querySelectorAll('.btn-primary-custom, .btn-outline-custom');
            
            buttons.forEach(button => {
                button.classList.add('btn-ripple');
                
                button.addEventListener('click', function(e) {
                    const ripple = this.querySelector('.btn-ripple::after');
                    if (ripple) {
                        ripple.style.width = '300px';
                        ripple.style.height = '300px';
                        setTimeout(() => {
                            ripple.style.width = '0';
                            ripple.style.height = '0';
                        }, 600);
                    }
                });
            });
        }

        // === SHAKE CART WHEN ITEM ADDED ===
        function shakeCart() {
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.style.animation = 'none';
                setTimeout(() => {
                    cartCount.style.animation = 'shake 0.5s';
                }, 10);
            }
        }

        // === PARALLAX EFFECT ON SCROLL ===
        function initParallax() {
            const watchContainer = document.querySelector('.watch-container');
            
            window.addEventListener('scroll', () => {
                if (watchContainer) {
                    const scrolled = window.pageYOffset;
                    const rate = scrolled * -0.5;
                    watchContainer.style.transform = `translateY(${rate}px)`;
                }
            });
        }

        // === ANIMATE FEATURE CARDS ON SCROLL ===
        function animateOnScroll() {
            const featureCards = document.querySelectorAll('.feature-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                    } else {
                        entry.target.style.animationPlayState = 'paused';
                    }
                });
            }, { threshold: 0.1 });
            
            featureCards.forEach(card => {
                card.style.animationPlayState = 'paused';
                observer.observe(card);
            });
        }

        // === INITIALIZE EVERYTHING ON PAGE LOAD ===
        document.addEventListener('DOMContentLoaded', function () {
            // Start the reload animation
            animateWatchOnLoad();
            
            // Create particle background
            createParticles();
            
            // Start the clock
            setClock();
            setInterval(setClock, 1000);
            
            // Add ripple effects to buttons
            addRippleEffect();
            
            // Initialize parallax effect
            initParallax();
            
            // Initialize scroll animations
            animateOnScroll();
            
            // Add hover effects to watch
            const watchContainer = document.querySelector('.watch-container');
            if (watchContainer) {
                watchContainer.addEventListener('mouseenter', () => {
                    watchContainer.style.animationDuration = '4s, 4s';
                });
                
                watchContainer.addEventListener('mouseleave', () => {
                    watchContainer.style.animationDuration = '6s, 8s';
                });
            }
        });

        // === CART FUNCTIONALITY ===
        document.addEventListener('DOMContentLoaded', function () {
            const cartCount = document.getElementById('cartCount');
            const cartItemsContainer = document.getElementById('cartItems');
            const clearCartBtn = document.getElementById('clearCartBtn');

            function loadCart() {
                return JSON.parse(localStorage.getItem('cart')) || [];
            }

            function saveCart(cart) {
                localStorage.setItem('cart', JSON.stringify(cart));
            }

            function updateCartCount() {
                const cart = loadCart();
                let totalCount = 0;
                cart.forEach(item => totalCount += item.quantity);
                if (cartCount) {
                    cartCount.textContent = totalCount;
                    cartCount.style.display = totalCount > 0 ? 'inline-block' : 'none';
                    
                    // Shake animation when cart updates
                    if (totalCount > 0) {
                        shakeCart();
                    }
                }
            }

            function renderCartItems() {
                const cart = loadCart();
                if (cart.length === 0) {
                    cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
                    return;
                }

                let html = '<ul class="list-group">';
                cart.forEach(item => {
                    html += `
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <img src="${item.thumbnail}" alt="${item.title}" style="width:50px; height:auto; margin-right:15px; border-radius:5px;">
                                <div>
                                    <strong>${item.title}</strong><br>
                                    <small>$${item.price.toFixed(2)} x ${item.quantity}</small>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-danger remove-item-btn" data-id="${item.id}" aria-label="Remove item">&times;</button>
                        </li>
                    `;
                });
                html += '</ul>';
                cartItemsContainer.innerHTML = html;

                // Attach remove handlers
                document.querySelectorAll('.remove-item-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        removeFromCart(id);
                    });
                });
            }

            function addToCart(product) {
                const cart = loadCart();
                const existing = cart.find(item => item.id == product.id);
                if (existing) {
                    existing.quantity += 1;
                } else {
                    product.quantity = 1;
                    cart.push(product);
                }
                saveCart(cart);
                updateCartCount();
            }

            function removeFromCart(id) {
                let cart = loadCart();
                cart = cart.filter(item => item.id != id);
                saveCart(cart);
                updateCartCount();
                renderCartItems();
            }

            clearCartBtn.addEventListener('click', function () {
                localStorage.removeItem('cart');
                updateCartCount();
                renderCartItems();
            });

            // Update cart count on page load
            updateCartCount();

            // Render cart when modal opens
            const cartModal = document.getElementById('cartModal');
            cartModal.addEventListener('show.bs.modal', function () {
                renderCartItems();
            });

            // Expose addToCart globally to use from product pages/buttons
            window.addToCart = addToCart;
        });

        document.addEventListener('DOMContentLoaded', function () {
            const isLoggedIn = @json(Auth::check());
            console.log('Is user logged in?', isLoggedIn);

            const checkoutBtn = document.getElementById('checkoutBtn');

            checkoutBtn.addEventListener('click', function () {
                if (isLoggedIn) {
                    window.location.href = '{{ route('checkout') }}';
                } else {
                    window.location.href = '{{ route('login') }}';
                }
            });
        });

        // === SMOOTH SCROLLING FOR ANCHOR LINKS ===
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // === LOADING SPINNER FOR BUTTONS ===
        function showLoading(button) {
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="spinner"></span> Loading...';
            button.disabled = true;
            
            return () => {
                button.innerHTML = originalText;
                button.disabled = false;
            };
        }

        // Expose utility functions
        window.showLoading = showLoading;
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @yield('scripts')

    <!-- Chatbot Widget -->
    @include('partials.chatbot')
</body>

</html>