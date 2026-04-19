<style>
    .navbar {
        background: rgba(11, 12, 16, 0.8) !important;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(241, 229, 172, 0.05);
        padding: 0.8rem 0;
        transition: all 0.4s ease;
    }
    
    .navbar.scrolled {
        padding: 0.5rem 0;
        background: rgba(11, 12, 16, 0.95) !important;
    }

    .navbar-brand {
        font-weight: 800;
        letter-spacing: -0.5px;
        font-size: 1.4rem;
        color: var(--text-bright) !important;
    }

    .nav-link {
        font-weight: 500;
        letter-spacing: 0.3px;
        padding: 0.5rem 1.2rem !important;
        color: var(--text) !important;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .nav-link:hover, .nav-link.active {
        opacity: 1;
        color: var(--accent) !important;
    }

    .navbar-toggler {
        border: none;
        padding: 0;
    }

    .navbar-toggler:focus {
        box-shadow: none;
    }

    .toggler-icon {
        width: 30px;
        height: 2px;
        background-color: var(--accent);
        display: block;
        margin: 6px 0;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

        @media (min-width: 992px) {
            .navbar-collapse {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
            }
        }

        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(11, 12, 16, 0.98);
                backdrop-filter: blur(20px);
                position: absolute;
                top: 100%;
                left: 0;
                width: 100%;
                padding: 2rem;
                border-bottom: 1px solid rgba(241, 229, 172, 0.1);
                max-height: 80vh;
                overflow-y: auto;
            }
            
            .nav-item {
                margin-bottom: 1rem;
                text-align: center;
            }
            
            .nav-link {
                font-size: 1.2rem;
            }
        }
</style>

<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="fas fa-crown text-accent me-2 fs-5"></i>
            <span class="gradient-text">TryMyWatch</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="toggler-icon"></span>
            <span class="toggler-icon" style="width: 20px; margin-left: auto;"></span>
            <span class="toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
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

                <!-- Cart Icon -->
                <li class="nav-item ms-lg-3">
                    <a href="#" class="nav-link position-relative glass-card px-3 py-2 border-0" data-bs-toggle="modal" data-bs-target="#cartModal">
                        <i class="fas fa-shopping-bag text-accent"></i>
                        <span id="cartCount" class="badge rounded-pill bg-accent text-dark position-absolute top-0 start-100 translate-middle border border-onyx shadow-accent-glow" style="display:none; color: var(--accent) !important; font-size: 0.75rem; padding: 0.4em 0.6em; min-width: 1.8em; font-weight: 800;">0</span>
                    </a>
                </li>

                <li class="nav-item ms-lg-4 mt-3 mt-lg-0">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-primary-custom shadow-accent-glow px-4">
                            <i class="fas fa-user-lock me-2 small"></i> Client Portal
                        </a>
                    @else
                        <div class="d-flex align-items-center gap-3">
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
    </div>
</nav>

<script>
    window.addEventListener('scroll', function() {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    });
</script>
