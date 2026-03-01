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

@section('content')
<section class="py-5 bg-onyx min-vh-100" style="margin-top: 80px;">
    <div class="container">
        @php
            $productPrice = $product['price'] ?? 0;
            $productThumbnail = $product['thumbnail'] ?? '';
            $productDescription = $product['description'] ?? 'No description available.';
            $productBrand = $product['brand'] ?? 'Unknown Brand';
            $productRating = $product['rating'] ?? 0;
        @endphp

        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-md-6 text-center animate-fade-in">
                <div class="glass-card p-3 shadow-accent-glow">
                    @if(!empty($productThumbnail) && is_string($productThumbnail))
                        <img src="{{ $productThumbnail }}" class="img-fluid rounded-3 w-100 object-fit-cover shadow-lg" alt="{{ $productTitleSafe }}">
                    @else
                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 450px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6 slide-in-left">
                <div class="glass-card p-5 h-100">
                    <h1 class="gradient-text mb-2">{{ $productTitleSafe }}</h1>
                    <p class="text-accent fs-4 fw-bold mb-4">${{ number_format((float)$productPrice, 2) }}</p>
                    
                    <div class="mb-4">
                        <label class="text-silver-dim small text-uppercase fw-bold mb-2">Description</label>
                        <p class="text-silver opacity-75 lead">{{ $productDescription }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <label class="text-silver-dim small text-uppercase fw-bold mb-1 d-block">Brand</label>
                            <span class="text-silver fw-bold">{{ $productBrand }}</span>
                        </div>
                        <div class="col-6 text-end">
                            @if($productRating > 0)
                                <label class="text-silver-dim small text-uppercase fw-bold mb-1 d-block">Rating</label>
                                <span class="text-accent fw-bold"><i class="fas fa-star me-1"></i>{{ number_format((float)$productRating, 1) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3 mb-5">
                        <button 
                            class="btn btn-primary-custom py-3 add-to-cart-btn" 
                            data-id="{{ $product['id'] ?? '' }}" 
                            data-title="{{ $productTitleSafe }}" 
                            data-price="{{ $productPrice }}" 
                            data-thumbnail="{{ $productThumbnail }}"
                        >
                            <i class="fas fa-shopping-bag me-2"></i> Add to Cart
                        </button>
                    </div>

                    <hr class="border-silver-dim mb-4">

                    <!-- AI & AR Features -->
                    <div class="ai-features bg-dark rounded-4 p-4 border border-silver-dim shadow-sm">
                        <h6 class="text-accent text-uppercase small fw-bold mb-3"><i class="fas fa-magic me-2"></i>Virtual Experience</h6>
                        <div class="d-grid gap-2">
                            @if(!empty($product['model_3d']))
                                <a href="{{ route('product.ar', $product['id']) }}" class="btn btn-outline-custom">
                                    <i class="fas fa-cube me-2"></i> View in AR (Camera)
                                </a>
                            @endif
                            <a href="{{ route('product.try-on-upload', $product['id']) }}" class="btn btn-outline-light py-2">
                                <i class="fas fa-robot me-2"></i> AI Static Try-On
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.5); }
    .border-silver-dim { border-color: rgba(197, 198, 199, 0.1) !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .object-fit-cover { object-fit: cover; }
</style>

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
    <a href="{{ route('checkout') }}" class="btn btn-primary">Checkout</a>
</div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
    // console.log("Cart script loaded");

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
