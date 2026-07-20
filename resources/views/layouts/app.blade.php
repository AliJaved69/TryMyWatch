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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        /* === YOUR FULL EXISTING CSS === */

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

        /* Nav items - no global opacity override (handled per-context) */
        .nav-item {
            opacity: 1;
        }

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

/* ========================================= */
/* GLOBAL SHOP GRID (Imported from shop template) */
/* ========================================= */



.shop-wrapper {
    padding: 0 52px 60px;
    position: relative;
    z-index: 1;
}
@media (max-width: 992px) {
    .shop-wrapper { padding: 0 20px 40px; }
}

/* SHOP */
.shop-head{padding:80px 0 0;display:flex;align-items:flex-end;justify-content:space-between; margin-bottom:20px;}
.section-tag{font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--accent);display:flex;align-items:center;gap:10px;margin-bottom:14px; font-weight:700;}
.section-tag::before{content:'';width:30px;height:2px;background:var(--accent)}
.section-h{margin:0;}
.section-h em{font-style:normal; font-weight:300; opacity:0.8;}
.see-all{font-size:0.85rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-secondary);cursor:pointer;display:flex;align-items:center;gap:8px;text-decoration:none;transition:color 0.3s;font-weight:600;}
.see-all:hover{color:var(--accent)}

/* PRODUCT GRID */
.shop-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;padding:32px 0 0;margin-bottom:2px}
@media (max-width: 992px) {
    .shop-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .shop-grid { grid-template-columns: 1fr; }
}

.shop-card{
    background: rgba(31, 40, 51, 0.4);
    backdrop-filter: blur(14px);
    border: 1px solid rgba(241, 229, 172, 0.08);
    border-radius: 20px;
    padding:36px 28px 28px;
    cursor:pointer;
    position:relative;
    overflow:hidden;
    transition:all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
    text-decoration:none; 
    display:flex; 
    flex-direction:column; 
    height: 100%;
}
.shop-card:hover{
    background:rgba(31, 40, 51, 0.8); 
    transform: translateY(-10px);
    box-shadow: 0 20px 45px rgba(0,0,0,0.5);
    border-color: rgba(241, 229, 172, 0.25);
}

.card-num{position:absolute;top:20px;right:20px;font-size:4rem;font-weight:900;color:rgba(255,255,255,0.02);line-height:1;pointer-events:none;user-select:none;}
.card-tag{font-size:0.7rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--accent);margin-bottom:12px;font-weight:700; opacity:0.9;}

.watch-img-container {
    width:100%;
    height:220px;
    margin:0 auto 24px;
    display:flex;
    align-items:center;
    justify-content:center;
    position: relative;
    z-index: 2;
}

.watch-img{
    max-width:100%;
    max-height:100%;
    object-fit:contain; 
    background: transparent;
    transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
    filter: drop-shadow(0 15px 25px rgba(0,0,0,0.4));
}
.shop-card:hover .watch-img{transform:scale(1.08) translateY(-5px);}

.card-name{font-size:1.3rem;font-weight:600;color:var(--text);margin-bottom:20px;line-height:1.4; z-index: 2; position: relative;}
.card-bottom{display:flex;justify-content:space-between;align-items:center; margin-top:auto; z-index: 2; position: relative;}
.card-price{font-size:1.3rem;font-weight:700;}

/* Wide card */
.card-wide{grid-column:span 2;display:grid;grid-template-columns:1.2fr 1fr; padding:0;}
@media (max-width: 992px) {
    .card-wide { grid-column: span 1; grid-template-columns: 1fr; }
}
.card-wide-img{
    background: rgba(0,0,0,0.15);
    display:flex;align-items:center;justify-content:center;
    padding:40px; 
    min-height:300px;
    position: relative;
}
.card-wide-content{padding:48px 40px;display:flex;flex-direction:column;justify-content:center; position:relative;}
.card-wide-content .card-name{font-size:2.2rem;margin-bottom:16px; font-weight:800; background:linear-gradient(135deg, var(--accent), var(--accent-light)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;}
.card-wide-desc{font-size:0.95rem;color:var(--text-secondary);line-height:1.7;margin-bottom:32px;}

        /* === PREMIUM CUSTOM TOAST === */
        .custom-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: rgba(31, 40, 51, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(241, 229, 172, 0.25);
            color: var(--text);
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5), 0 0 20px rgba(241, 229, 172, 0.1);
            z-index: 99999;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateY(100px);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s ease;
            pointer-events: none;
        }
        .custom-toast.show {
            transform: translateY(0);
            opacity: 1;
        }
        .custom-toast i {
            color: var(--accent);
            font-size: 1.25rem;
        }
        @media (max-width: 768px) {
            .custom-toast {
                bottom: 20px;
                left: 20px;
                right: 20px;
                justify-content: center;
                text-align: center;
            }
            /* Hide swiper navigation arrows on mobile */
            .swiper-button-next, .swiper-button-prev {
                display: none !important;
            }
            /* Card-Wide Mobile Optimization */
            .card-wide-img {
                min-height: 200px !important;
                padding: 20px !important;
            }
            .card-wide-content {
                padding: 24px 20px !important;
            }
            .card-wide-content .card-name {
                font-size: 1.6rem !important;
                margin-bottom: 12px !important;
            }
            .card-wide-desc {
                margin-bottom: 20px !important;
                font-size: 0.85rem !important;
            }
        }

        /* === PREMIUM LUXURY CART MODAL STYLING === */
        #cartModal {
            z-index: 100005 !important;
        }
        
        .modal-backdrop {
            z-index: 100002 !important;
        }

        #cartModal .modal-dialog {
            margin-top: 100px !important;
            margin-bottom: 2rem !important;
        }

        #cartModal .modal-content {
            background: rgba(11, 12, 16, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(241, 229, 172, 0.15);
            border-radius: 20px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.8), 0 0 30px rgba(241, 229, 172, 0.05);
            color: var(--text);
        }

        #cartModal .modal-header {
            border-bottom: 1px solid rgba(241, 229, 172, 0.1);
            padding: 1.5rem 2rem;
        }

        #cartModal .modal-title {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 1.25rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        #cartModal .btn-close {
            filter: invert(1) grayscale(1) brightness(1.5);
            opacity: 0.7;
            transition: opacity 0.3s ease;
        }

        #cartModal .btn-close:hover {
            opacity: 1;
        }

        #cartModal .modal-body {
            padding: 2rem;
            max-height: 60vh;
            overflow-y: auto;
        }

        #cartModal .modal-footer {
            border-top: 1px solid rgba(241, 229, 172, 0.1);
            background: rgba(11, 12, 16, 0.4);
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        #cartModal .list-group-item {
            background: rgba(31, 40, 51, 0.4);
            border: 1px solid rgba(241, 229, 172, 0.08);
            border-radius: 12px !important;
            margin-bottom: 12px;
            padding: 18px;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
            color: var(--text);
        }

        #cartModal .list-group-item:hover {
            border-color: rgba(241, 229, 172, 0.3);
            background: rgba(31, 40, 51, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        #cartModal .list-group-item img {
            border: 1px solid rgba(241, 229, 172, 0.15);
            border-radius: 8px;
            object-fit: cover;
            padding: 2px;
            background: rgba(11, 12, 16, 0.8);
        }

        #cartModal .list-group-item strong {
            color: var(--text-bright);
            font-size: 1.05rem;
            font-weight: 600;
        }

        #cartModal .list-group-item small {
            color: var(--accent);
            font-family: monospace;
            font-size: 0.9rem;
        }

        #cartModal .remove-item-btn {
            background: rgba(255, 82, 82, 0.1);
            border: 1px solid rgba(255, 82, 82, 0.2);
            color: #ff5252;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        #cartModal .remove-item-btn:hover {
            background: #ff5252;
            border-color: #ff5252;
            color: #ffffff;
            box-shadow: 0 0 10px rgba(255, 82, 82, 0.4);
        }

        #clearCartBtn {
            background: transparent;
            border: 1px solid rgba(255, 82, 82, 0.4);
            color: #ff5252;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        #clearCartBtn:hover {
            background: #ff5252;
            color: #ffffff;
            border-color: #ff5252;
            box-shadow: 0 0 15px rgba(255, 82, 82, 0.3);
        }

        #checkoutBtn {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border: none;
            color: var(--primary) !important;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.8rem;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        #checkoutBtn:hover {
            box-shadow: 0 0 20px rgba(241, 229, 172, 0.4);
            transform: translateY(-1px);
        }

        #cartModal .empty-cart-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        #cartModal .empty-cart-state i {
            font-size: 3.5rem;
            color: var(--accent);
            opacity: 0.3;
            margin-bottom: 1.5rem;
            display: block;
        }

        #cartModal .empty-cart-state p {
            color: var(--text);
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        #cartModal .empty-cart-state span {
            color: var(--text-secondary);
            font-size: 0.85rem;
            display: block;
        }

        /* Quantity Controller styles */
        #cartModal .quantity-controller {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(241, 229, 172, 0.15);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            padding: 2px 4px;
        }

        #cartModal .btn-qty {
            background: transparent;
            border: none;
            color: var(--accent);
            width: 24px;
            height: 24px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        #cartModal .btn-qty:hover {
            background: rgba(241, 229, 172, 0.15);
            color: var(--accent-light);
        }

        #cartModal .qty-display {
            color: var(--text-bright);
            font-weight: 700;
            font-size: 0.85rem;
            min-width: 20px;
            text-align: center;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    @include('partials.navbar')

    <main class="flex-grow-1 d-flex flex-column">
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
                    cartItemsContainer.innerHTML = `
                        <div class="empty-cart-state text-center">
                            <i class="fas fa-shopping-bag mb-3"></i>
                            <p>Your luxury collection is empty.</p>
                            <span>Select watches from our showroom to add them to your cart.</span>
                        </div>
                    `;
                    return;
                }

                let html = '<ul class="list-group list-group-flush bg-transparent border-0">';
                cart.forEach(item => {
                    html += `
                        <li class="list-group-item d-flex align-items-center justify-content-between bg-transparent">
                            <div class="d-flex align-items-center">
                                <img src="${item.thumbnail}" alt="${item.title}" style="width:60px; height:60px; margin-right:15px;" class="object-fit-cover">
                                <div>
                                    <strong>${item.title}</strong><br>
                                    <div class="d-flex align-items-center mt-1">
                                        <small class="text-accent me-3">$${item.price.toFixed(2)}</small>
                                        <div class="quantity-controller d-flex align-items-center">
                                            <button class="btn-qty decrease-qty-btn" data-id="${item.id}" aria-label="Decrease quantity">-</button>
                                            <span class="qty-display">${item.quantity}</span>
                                            <button class="btn-qty increase-qty-btn" data-id="${item.id}" aria-label="Increase quantity">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="remove-item-btn" data-id="${item.id}" aria-label="Remove item">
                                <i class="fas fa-trash-alt"></i>
                            </button>
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

                // Attach decrease handlers
                document.querySelectorAll('.decrease-qty-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        const cart = loadCart();
                        const item = cart.find(i => i.id == id);
                        if (item) {
                            updateCartItemQty(id, item.quantity - 1);
                        }
                    });
                });

                // Attach increase handlers
                document.querySelectorAll('.increase-qty-btn').forEach(btn => {
                    btn.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        const cart = loadCart();
                        const item = cart.find(i => i.id == id);
                        if (item) {
                            updateCartItemQty(id, item.quantity + 1);
                        }
                    });
                });
            }

            function updateCartItemQty(id, newQty) {
                let cart = loadCart();
                const item = cart.find(i => i.id == id);
                if (item) {
                    item.quantity = newQty;
                    if (item.quantity <= 0) {
                        cart = cart.filter(i => i.id != id);
                    }
                    saveCart(cart);
                    updateCartCount();
                    renderCartItems();
                }
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
                
                // Trigger premium custom toast notification
                if (window.showToast) {
                    window.showToast(`${product.title} added to cart!`);
                }
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
            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function () {
                    window.location.href = '{{ route('checkout') }}';
                });
            }
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

        // === GLOBAL CUSTOM TOAST ===
        function showToast(message, iconClass = 'fas fa-check-circle') {
            // Remove existing toast if present
            const oldToast = document.querySelector('.custom-toast');
            if (oldToast) {
                oldToast.remove();
            }

            // Create toast element
            const toast = document.createElement('div');
            toast.className = 'custom-toast';
            toast.innerHTML = `<i class="${iconClass}"></i><span>${message}</span>`;
            document.body.appendChild(toast);

            // Trigger animation
            setTimeout(() => {
                toast.classList.add('show');
            }, 50);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }, 3000);
        }

        // Expose utility functions
        window.showLoading = showLoading;
        window.showToast = showToast;
    </script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @yield('scripts')

    <!-- Chatbot Widget -->
    @include('partials.chatbot')
</body>

</html>