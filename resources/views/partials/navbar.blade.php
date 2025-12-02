<style>
   .outline-btn-nav {
    padding: 6px 18px;
    border-radius: 25px;
    border: 2px solid #fff;
    color: #fff;
    font-weight: 600;
    transition: 0.3s;
}

.outline-btn-nav:hover {
    background: #fff;
    color: #000;
}

.outline-btn-nav-filled {
    padding: 6px 18px;
    border-radius: 25px;
    background: #fff;
    color: #000;
    font-weight: 600;
    transition: 0.3s;
}

.outline-btn-nav-filled:hover {
    opacity: 0.85;
}

</style>
<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <i class="fas fa-crown me-2"></i>TryMy<span>Watch</span>
        </a>

        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon text-light"><i class="fas fa-bars"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">

                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>

                <!-- Cart Icon -->
                <li class="nav-item ms-3">
                    <a href="#" class="nav-link position-relative" data-bs-toggle="modal" data-bs-target="#cartModal">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span id="cartCount" class="badge bg-danger position-absolute top-0 start-100 translate-middle" style="display:none;">0</span>
                    </a>
                </li>

                <!-- AUTH BUTTONS -->
              @guest
    <li class="nav-item ms-3">
        <a href="{{ route('login') }}" class="btn btn-primary-custom">Login</a>
    </li>

    <li class="nav-item ms-2">
        <a href="{{ route('signup') }}" class="btn btn-primary-custom">Signup</a>
    </li>
@endguest




                @auth
                    <!-- Logout -->
                    <li class="nav-item ms-3">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-primary-custom ">Logout</button>
                        </form>
                    </li>
                @endauth

            </ul>

            <a href="{{ url('/shop') }}" class="btn btn-primary-custom ms-lg-2">Try It Now</a>
        </div>
    </div>
</nav>
