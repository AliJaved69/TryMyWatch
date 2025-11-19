<nav class="navbar navbar-expand-lg fixed-top" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <i class="fas fa-crown me-2"></i>TryMy<span>Watch</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
        <span id="cartCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="display:none;">
            0
        </span>
    </a>
</li>
            </ul>
            <a href="{{ url('/shop') }}" class="btn btn-primary-custom ms-lg-3">Try It Now</a>
        </div>
    </div>
</nav>
