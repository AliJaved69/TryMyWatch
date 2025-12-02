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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        /* === YOUR FULL EXISTING CSS === */
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

        // Initialize everything on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Start the reload animation
            animateWatchOnLoad();
            
            // Start the clock
            setClock();
            setInterval(setClock, 1000);
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
    // ...existing cart code...

    const checkoutBtn = document.getElementById('checkoutBtn');

    checkoutBtn.addEventListener('click', function () {
        // Make an AJAX call to check if user is logged in
        fetch('/api/check-auth', { credentials: 'same-origin' })
            .then(res => res.json())
            .then(data => {
                if (data.authenticated) {
                    // redirect to checkout
                    window.location.href = '{{ route('checkout') }}';
                } else {
                    // redirect to login page
                    window.location.href = '{{ route('login') }}';
                }
            }).catch(() => {
                // fallback to login page on error
                window.location.href = '{{ route('login') }}';
            });
    });
});

    </script>
    @yield('scripts')

</body>

</html>