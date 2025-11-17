@extends('layouts.app')

@php
    // Safely set product title string to avoid array issues
    $productTitleSafe = is_array($product['title'] ?? null) ? 'Product Details' : ($product['title'] ?? 'Product Details');
@endphp

@section('title', $productTitleSafe)

@section('styles')
<style>
    /* Dark modal background and text */
    .modal-content {
        background-color: #121212;
        color: #f0f0f0;
        border-radius: 8px;
        border: none;
    }

    .modal-header, .modal-footer {
        border-color: #222;
    }

    .btn-close {
        filter: invert(1);
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

    /* Navbar toggler icon */
    .navbar-toggler-icon i {
        color: white;
        font-size: 1.25rem;
    }

    /* Customize cart badge */
    .badge.bg-danger {
        background-color: #b33939;
    }
</style>
@endsection

@section('navbar')
<nav class="navbar navbar-expand-lg fixed-top" id="navbar" style="background-color: #121212;">
    <div class="container">
        <a class="navbar-brand text-light" href="{{ url('/home') }}">
            <i class="fas fa-crown me-2"></i>TryMy<span>Watch</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link text-light" href="{{ url('/home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="{{ url('/shop') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="{{ url('/about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-light" href="{{ url('/contact') }}">Contact</a></li>
                <!-- Cart Icon -->
                <li class="nav-item ms-3">
                    <a href="#" class="nav-link position-relative text-light" data-bs-toggle="modal" data-bs-target="#cartModal" style="font-size:1.3rem;">
                        <i class="fas fa-shopping-cart"></i>
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
@endsection

@section('content')
<section class="py-5" style="margin-top: 80px;">
    <div class="container">
        @php
            $productPrice = $product['price'] ?? 0;
            $productThumbnail = $product['thumbnail'] ?? '';
            $productDescription = $product['description'] ?? 'No description available.';
            $productBrand = $product['brand'] ?? 'Unknown Brand';
            $productRating = $product['rating'] ?? 0;
        @endphp

        <div class="row">
            <div class="col-md-6 text-center">
                @if(!empty($productThumbnail) && is_string($productThumbnail))
                    <img src="{{ $productThumbnail }}" class="img-fluid rounded" alt="{{ $productTitleSafe }}">
                @else
                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                        <span class="text-muted">No Image Available</span>
                    </div>
                @endif
            </div>
            <div class="col-md-6">
                <h1>{{ $productTitleSafe }}</h1>
                <p class="lead text-secondary-custom">
                    ${{ number_format((float)$productPrice, 2) }}
                </p>
                <p>{{ $productDescription }}</p>
                
                <p><strong>Brand:</strong> {{ $productBrand }}</p>
                
                @if($productRating > 0)
                    <p><strong>Rating:</strong> ⭐ {{ number_format((float)$productRating, 1) }}/5</p>
                @endif
                
                <button 
                    class="btn btn-primary-custom add-to-cart-btn" 
                    data-id="{{ $product['id'] ?? '' }}" 
                    data-title="{{ $productTitleSafe }}" 
                    data-price="{{ $productPrice }}" 
                    data-thumbnail="{{ $productThumbnail }}"
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Cart Modal -->
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
        <a href="{{ url('/checkout') }}" class="btn btn-primary">Checkout</a>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
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
        if(cartCount) {
            cartCount.textContent = totalCount;
            cartCount.style.display = totalCount > 0 ? 'inline-block' : 'none';
        }
    }

    function renderCartItems() {
        const cart = loadCart();
        if(cart.length === 0) {
            cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
            return;
        }

        let html = '<ul class="list-group">';
        cart.forEach(item => {
            html += `
                <li class="list-group-item d-flex align-items-center">
                    <img src="${item.thumbnail}" alt="${item.title}" style="width:50px; height:auto; margin-right:15px;">
                    <div class="flex-grow-1">
                        <strong>${item.title}</strong><br>
                        $${item.price.toFixed(2)} x ${item.quantity}
                    </div>
                    <button class="btn btn-sm btn-danger remove-item-btn" data-id="${item.id}">&times;</button>
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
        console.log('Adding product:', product);  // DEBUG LOG
        const cart = loadCart();
        const existing = cart.find(item => item.id == product.id);
        if(existing) {
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

    clearCartBtn.addEventListener('click', function() {
        localStorage.removeItem('cart');
        updateCartCount();
        renderCartItems();
    });

    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const product = {
                id: this.getAttribute('data-id'),
                title: this.getAttribute('data-title'),
                price: parseFloat(this.getAttribute('data-price')),
                thumbnail: this.getAttribute('data-thumbnail')
            };

            // Check for missing data
            if(!product.id || !product.title || isNaN(product.price)) {
                alert('Product data missing or invalid!');
                console.error('Product data missing:', product);
                return;
            }

            addToCart(product);
            alert(`${product.title} added to cart!`);
        });
    });

    // Render items when modal opens
    const cartModal = document.getElementById('cartModal');
    cartModal.addEventListener('show.bs.modal', function () {
        renderCartItems();
    });

    updateCartCount();
});

</script>
@endsection
