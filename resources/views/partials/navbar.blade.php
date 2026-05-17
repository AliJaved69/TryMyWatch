<style>
    /* ===== NAVBAR BASE ===== */
    .navbar {
        background: rgba(11, 12, 16, 0.9) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(241, 229, 172, 0.05);
        padding: 0.8rem 0;
        transition: all 0.4s ease;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
    }

    .navbar.scrolled {
        padding: 0.5rem 0;
        background: rgba(11, 12, 16, 0.98) !important;
    }

    .navbar .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: nowrap;
    }

    .navbar-brand {
        font-weight: 800;
        letter-spacing: -0.5px;
        font-size: 1.4rem;
        color: var(--text-bright) !important;
        text-decoration: none;
        display: flex;
        align-items: center;
        flex-shrink: 0;
    }

    /* ===== DESKTOP NAV ===== */
    .nav-menu {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.2rem;
    }

    .nav-link {
        font-weight: 500;
        letter-spacing: 0.3px;
        padding: 0.5rem 1.2rem !important;
        color: var(--text) !important;
        opacity: 0.8;
        transition: all 0.3s ease;
        text-decoration: none;
        display: block;
    }

    .nav-link:hover,
    .nav-link.active {
        opacity: 1;
        color: var(--accent) !important;
    }

    /* ===== HAMBURGER BUTTON ===== */
    .nav-toggler {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: flex-end;
        gap: 5px;
        background: transparent;
        border: none;
        padding: 6px;
        cursor: pointer;
        z-index: 10001;
        flex-shrink: 0;
    }

    .nav-toggler .bar {
        width: 28px;
        height: 2px;
        background-color: var(--accent);
        border-radius: 2px;
        transition: all 0.3s ease;
        display: block;
    }

    .nav-toggler .bar:nth-child(2) {
        width: 20px;
    }

    /* Animate hamburger to X when open */
    .nav-toggler.open .bar:nth-child(1) {
        transform: translateY(7px) rotate(45deg);
        width: 28px;
    }

    .nav-toggler.open .bar:nth-child(2) {
        opacity: 0;
        width: 0;
    }

    .nav-toggler.open .bar:nth-child(3) {
        transform: translateY(-7px) rotate(-45deg);
        width: 28px;
    }

    /* ===== MOBILE DRAWER ===== */
    @media (max-width: 991.98px) {
        .nav-toggler {
            display: flex;
        }

        .nav-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(11, 12, 16, 0.98);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            z-index: 10000;
            /* Hidden by default */
            visibility: hidden;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            pointer-events: none;
        }

        /* Open state */
        .nav-menu.open {
            visibility: visible;
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
        }

        .nav-menu .nav-item {
            opacity: 1 !important;
            animation: none !important;
            width: 100%;
            text-align: center;
        }

        .nav-menu .nav-link {
            font-size: 1.4rem;
            font-weight: 600;
            padding: 0.8rem 2rem !important;
            opacity: 1 !important;
        }

        .nav-menu .nav-link:hover {
            color: var(--accent) !important;
        }

        /* Stagger animation for items when menu opens */
        .nav-menu.open .nav-item {
            animation: mobileNavFadeIn 0.4s ease forwards !important;
        }

        .nav-menu.open .nav-item:nth-child(1) { animation-delay: 0.05s !important; }
        .nav-menu.open .nav-item:nth-child(2) { animation-delay: 0.10s !important; }
        .nav-menu.open .nav-item:nth-child(3) { animation-delay: 0.15s !important; }
        .nav-menu.open .nav-item:nth-child(4) { animation-delay: 0.20s !important; }
        .nav-menu.open .nav-item:nth-child(5) { animation-delay: 0.25s !important; }
        .nav-menu.open .nav-item:nth-child(6) { animation-delay: 0.30s !important; }

        @keyframes mobileNavFadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Mobile divider line */
        .nav-divider {
            width: 60px;
            height: 1px;
            background: rgba(241, 229, 172, 0.2);
            margin: 1rem auto;
        }
    }

    @media (min-width: 992px) {
        .nav-menu {
            /* Always visible on desktop */
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            pointer-events: auto !important;
        }
    }
</style>

<nav class="navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-crown text-accent me-2 fs-5"></i>
            <span class="gradient-text">TryMyWatch</span>
        </a>

        {{-- Hamburger toggler --}}
        <button class="nav-toggler" id="navToggler" aria-label="Toggle navigation" aria-expanded="false">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>

        {{-- Nav menu --}}
        <ul class="nav-menu" id="navMenu" role="list">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ route('about') }}">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">Contact Us</a>
            </li>

            {{-- Mobile divider --}}
            <li class="nav-item d-lg-none">
                <div class="nav-divider"></div>
            </li>

            {{-- Cart Icon --}}
            <li class="nav-item">
                <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fas fa-shopping-bag text-accent"></i>
                    <span id="cartCount" class="badge rounded-pill position-absolute top-0 start-100 translate-middle border border-onyx shadow-accent-glow"
                          style="display:none; background: var(--accent); color: var(--primary) !important; font-size: 0.75rem; padding: 0.4em 0.6em; min-width: 1.8em; font-weight: 800;">0</span>
                </a>
            </li>

            {{-- Auth --}}
            <li class="nav-item">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary-custom shadow-accent-glow px-4">
                        <i class="fas fa-user-lock me-2 small"></i> Client Portal
                    </a>
                @else
                    <div class="d-flex align-items-center gap-3 flex-wrap justify-content-center">
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-custom border-0 text-accent">
                                <i class="fas fa-shield-halved me-1"></i> Admin
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary-custom px-4">Terminate Session</button>
                        </form>
                    </div>
                @endguest
            </li>
        </ul>
    </div>
</nav>

<script>
    (function () {
        // Scroll effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('navbar');
            nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Mobile menu toggle
        const toggler = document.getElementById('navToggler');
        const menu    = document.getElementById('navMenu');

        function openMenu() {
            menu.classList.add('open');
            toggler.classList.add('open');
            toggler.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden'; // prevent background scroll
        }

        function closeMenu() {
            menu.classList.remove('open');
            toggler.classList.remove('open');
            toggler.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        toggler.addEventListener('click', function () {
            if (menu.classList.contains('open')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close when a nav link is clicked
        menu.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', closeMenu);
        });

        // Close when clicking outside the menu
        document.addEventListener('click', function (e) {
            if (menu.classList.contains('open') &&
                !menu.contains(e.target) &&
                !toggler.contains(e.target)) {
                closeMenu();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && menu.classList.contains('open')) {
                closeMenu();
            }
        });

        // On window resize: close menu & restore scroll if switching to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992 && menu.classList.contains('open')) {
                closeMenu();
            }
        });
    })();
</script>
