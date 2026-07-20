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

    /* ===== PREMIUM MOBILE DRAWER ===== */
    .mobile-drawer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: #0b0c10 !important;
        /* Solid luxury dark background */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 1.8rem;
        z-index: 10000;
        /* Hidden by default */
        visibility: hidden;
        opacity: 0;
        transform: translateY(-20px);
        transition: opacity 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), visibility 0.4s;
    }

    .mobile-drawer.open {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .drawer-link {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text) !important;
        text-decoration: none;
        transition: all 0.3s ease;
        opacity: 0.9;
        display: inline-flex;
        align-items: center;
        letter-spacing: 0.5px;
    }

    .drawer-link:hover,
    .drawer-link.active {
        color: var(--accent) !important;
        opacity: 1;
        transform: scale(1.05);
    }

    .drawer-close {
        position: absolute;
        top: 20px;
        right: 25px;
        background: transparent;
        border: none;
        color: var(--accent);
        font-size: 3rem;
        cursor: pointer;
        line-height: 1;
        transition: transform 0.3s ease;
        outline: none;
    }

    .drawer-close:hover {
        transform: rotate(90deg);
    }

    .drawer-divider {
        width: 80px;
        height: 2px;
        background: rgba(241, 229, 172, 0.15);
        margin: 0.5rem 0;
    }

    @media (max-width: 991.98px) {
        .nav-toggler {
            display: flex;
        }
    }
</style>

<nav class="navbar" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <i class="fas fa-crown text-accent me-2 fs-5"></i>
            <span class="gradient-text">TryMyWatch</span>
        </a>

        {{-- Desktop Navigation Menu --}}
        <ul class="nav-menu d-none d-lg-flex" role="list">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">Shop</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ route('about') }}">About
                    Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}"
                    href="{{ route('contact') }}">Contact Us</a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                    <i class="fas fa-shopping-bag text-accent"></i>
                    <span id="cartCount"
                        class="badge rounded-pill position-absolute top-0 start-100 translate-middle border border-onyx shadow-accent-glow"
                        style="display:none; background: var(--accent); color: var(--primary) !important; font-size: 0.75rem; padding: 0.4em 0.6em; min-width: 1.8em; font-weight: 800;">0</span>
                </a>
            </li>

            <li class="nav-item">
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary-custom shadow-accent-glow px-4">
                        <i class="fas fa-user-lock me-2 small"></i> Client Portal
                    </a>
                @else
                    <div class="d-flex align-items-center gap-3 flex-wrap">
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

        {{-- Hamburger toggler for mobile --}}
        <button class="nav-toggler" id="navToggler" aria-label="Toggle navigation" aria-expanded="false">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
</nav>

{{-- Mobile Drawer Menu (Placed outside standard navbar structure for perfect fullscreen layout) --}}
<div class="mobile-drawer d-lg-none" id="mobileDrawer">
    <button class="drawer-close" id="drawerClose" aria-label="Close menu">&times;</button>

    <a class="drawer-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
        <i class="fas fa-home text-accent me-3 fs-4"></i>Home
    </a>
    <a class="drawer-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop') }}">
        <i class="fas fa-store text-accent me-3 fs-4"></i>Shop
    </a>
    <a class="drawer-link {{ request()->is('static-try-on*') ? 'active' : '' }}" href="{{ route('static.index') }}">
        <i class="fas fa-magic text-accent me-3 fs-4"></i>AI Try-On
    </a>
    <a class="drawer-link {{ request()->is('about*') ? 'active' : '' }}" href="{{ route('about') }}">
        <i class="fas fa-info-circle text-accent me-3 fs-4"></i>About Us
    </a>
    <a class="drawer-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact') }}">
        <i class="fas fa-envelope text-accent me-3 fs-4"></i>Contact Us
    </a>

    <div class="drawer-divider"></div>

    <!-- Mobile Cart Button -->
    <a href="#" class="drawer-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal"
        id="mobileCartBtn">
        <i class="fas fa-shopping-bag text-accent me-3 fs-4"></i>Cart
        <span id="mobileCartCount" class="badge rounded-pill bg-accent text-primary ms-2"
            style="display:none; font-size: 0.75rem; padding: 0.4em 0.6em; font-weight: 800;">0</span>
    </a>

    <!-- Mobile Auth Option -->
    <div class="mt-3">
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary-custom shadow-accent-glow px-5 py-3 fs-5">
                <i class="fas fa-user-lock me-2"></i> Client Portal
            </a>
        @else
            <div class="d-flex flex-column align-items-center gap-3">
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-custom text-accent fs-5">
                        <i class="fas fa-shield-halved me-2"></i>Admin Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-primary-custom px-5 py-3 fs-5">Terminate Session</button>
                </form>
            </div>
        @endguest
    </div>
</div>

<script>
    (function () {
        // Scroll effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('navbar');
            if (nav) nav.classList.toggle('scrolled', window.scrollY > 50);
        });

        // Mobile drawer toggling
        const toggler = document.getElementById('navToggler');
        const drawer = document.getElementById('mobileDrawer');
        const closeBtn = document.getElementById('drawerClose');
        const mobileCartBtn = document.getElementById('mobileCartBtn');

        function openDrawer() {
            drawer.classList.add('open');
            toggler.classList.add('open');
            toggler.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden'; // prevent background scroll
        }

        function closeDrawer() {
            drawer.classList.remove('open');
            toggler.classList.remove('open');
            toggler.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }

        if (toggler && drawer) {
            toggler.addEventListener('click', function (e) {
                e.stopPropagation();
                if (drawer.classList.contains('open')) {
                    closeDrawer();
                } else {
                    openDrawer();
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeDrawer);
        }

        // Close drawer when clicking drawer links
        drawer.querySelectorAll('.drawer-link').forEach(function (link) {
            if (link !== mobileCartBtn) {
                link.addEventListener('click', closeDrawer);
            }
        });

        if (mobileCartBtn) {
            mobileCartBtn.addEventListener('click', function () {
                closeDrawer();
            });
        }

        // Close on outside click
        document.addEventListener('click', function (e) {
            if (drawer && drawer.classList.contains('open') && !drawer.contains(e.target) && !toggler.contains(e.target)) {
                closeDrawer();
            }
        });

        // Close on ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && drawer && drawer.classList.contains('open')) {
                closeDrawer();
            }
        });

        // Sync mobile cart count with global count
        const globalCartCount = document.getElementById('cartCount');
        const mobileCartCount = document.getElementById('mobileCartCount');

        function syncCartCounts() {
            if (globalCartCount && mobileCartCount) {
                mobileCartCount.textContent = globalCartCount.textContent;
                mobileCartCount.style.display = globalCartCount.style.display;
            }
        }

        syncCartCounts();
        if (globalCartCount) {
            const observer = new MutationObserver(syncCartCounts);
            observer.observe(globalCartCount, { childList: true, characterData: true, subtree: true });
        }
    })();
</script>