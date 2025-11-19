@extends('layouts.app')

@section('title', 'Checkout - TryMyWatch')

@section('content')
<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                
                <!-- Personal Information -->
                <div class="form-section" style="background: var(--secondary); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                    <h3 class="section-title">
                        <i class="fas fa-user me-2"></i>Personal Information
                    </h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">First Name *</label>
                                <input type="text" class="form-control" name="first_name" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Name *</label>
                                <input type="text" class="form-control" name="last_name" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" name="email" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Phone *</label>
                                <input type="tel" class="form-control" name="phone" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="form-section" style="background: var(--secondary); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                    <h3 class="section-title">
                        <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                    </h3>
                    <div class="mb-3">
                        <label class="form-label">Address *</label>
                        <input type="text" class="form-control" name="address" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">City *</label>
                                <input type="text" class="form-control" name="city" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">State *</label>
                                <input type="text" class="form-control" name="state" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" name="zip_code" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Country *</label>
                                <input type="text" class="form-control" name="country" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="form-section" style="background: var(--secondary); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                    <h3 class="section-title">
                        <i class="fas fa-credit-card me-2"></i>Payment Information
                    </h3>
                    <div class="mb-3">
                        <label class="form-label">Card Number *</label>
                        <input type="text" class="form-control" name="card_number" placeholder="1234 5678 9012 3456" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                        <div class="card-icons" style="display: flex; gap: 10px; margin-top: 0.5rem;">
                            <i class="fab fa-cc-visa" style="font-size: 1.5rem; opacity: 0.7;"></i>
                            <i class="fab fa-cc-mastercard" style="font-size: 1.5rem; opacity: 0.7;"></i>
                            <i class="fab fa-cc-amex" style="font-size: 1.5rem; opacity: 0.7;"></i>
                            <i class="fab fa-cc-discover" style="font-size: 1.5rem; opacity: 0.7;"></i>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Expiry Date *</label>
                                <input type="text" class="form-control" name="expiry_date" placeholder="MM/YY" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CVV *</label>
                                <input type="text" class="form-control" name="cvv" placeholder="123" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name on Card *</label>
                        <input type="text" class="form-control" name="name_on_card" required style="background-color: #2a2a2a; border: 1px solid #444; color: var(--text);">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary-custom btn-lg" style="width: 100%; padding: 1rem 2rem;">
                    <i class="fas fa-lock me-2"></i>Complete Order - ${{ number_format($total + ($total * 0.08), 2) }}
                </button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="order-summary" style="background: var(--secondary); border-radius: 12px; padding: 2rem; margin-bottom: 2rem;">
                <h3 class="section-title">Order Summary</h3>
                
                @foreach($cart as $item)
                <div class="order-item" style="display: flex; justify-content: between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #444;">
                    <div style="flex-grow: 1;">
                        <h6 class="mb-1">{{ $item['title'] }}</h6>
                        <small class="text-secondary-custom">Qty: {{ $item['quantity'] }}</small>
                    </div>
                    <div class="text-end">
                        <strong>${{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                    </div>
                </div>
                @endforeach
                
                <div class="order-item" style="display: flex; justify-content: between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #444;">
                    <div style="flex-grow: 1;">
                        <h6 class="mb-1">Shipping</h6>
                        <small class="text-secondary-custom">Standard Delivery</small>
                    </div>
                    <div class="text-end">
                        <strong>$0.00</strong>
                    </div>
                </div>
                
                <div class="order-item" style="display: flex; justify-content: between; align-items: center; padding: 1rem 0; border-bottom: 1px solid #444;">
                    <div style="flex-grow: 1;">
                        <h6 class="mb-1">Tax</h6>
                    </div>
                    <div class="text-end">
                        <strong>${{ number_format($total * 0.08, 2) }}</strong>
                    </div>
                </div>
                
                <hr>
                <div class="order-item" style="display: flex; justify-content: between; align-items: center; padding: 1rem 0;">
                    <div style="flex-grow: 1;">
                        <h5 class="mb-0">Total</h5>
                    </div>
                    <div class="text-end">
                        <h5 class="mb-0" style="color: var(--accent);">${{ number_format($total + ($total * 0.08), 2) }}</h5>
                    </div>
                </div>
            </div>

            <!-- Security Badges -->
            <div class="text-center">
                <div style="display: flex; justify-content: center; gap: 15px; margin-bottom: 1rem;">
                    <i class="fas fa-lock fa-2x" style="color: var(--accent);"></i>
                    <i class="fas fa-shield-alt fa-2x" style="color: var(--accent);"></i>
                    <i class="fas fa-user-shield fa-2x" style="color: var(--accent);"></i>
                </div>
                <p class="text-secondary-custom small">Your payment information is secure and encrypted</p>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        color: var(--text);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .form-control:focus {
        background-color: #2a2a2a;
        border-color: var(--accent);
        color: var(--text);
        box-shadow: 0 0 0 0.2rem rgba(201, 169, 110, 0.25);
    }
    
    .form-control::placeholder {
        color: var(--text-secondary);
    }

    /* Success Message Styles */
    .success-container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
        padding: 4rem 2rem;
    }
    
    .success-icon {
        font-size: 4rem;
        color: #28a745;
        margin-bottom: 2rem;
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkoutForm = document.getElementById('checkout-form');
        
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                submitBtn.disabled = true;
                
                // Simulate payment processing
                setTimeout(() => {
                    // Show success message on the same page
                    showSuccessMessage();
                }, 2000);
            });

            // Format card number
            const cardNumberInput = document.querySelector('input[name="card_number"]');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ');
                    e.target.value = formattedValue || value;
                });
            }

            // Format expiry date
            const expiryInput = document.querySelector('input[name="expiry_date"]');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2);
                    }
                    e.target.value = value;
                });
            }
        }

        function showSuccessMessage() {
            const mainContent = document.querySelector('main .container');
            if (mainContent) {
                mainContent.innerHTML = `
                    <div class="success-container">
                        <div class="success-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h1 class="mb-4">Order Successful!</h1>
                        <p class="lead mb-4">Thank you for your purchase. Your order has been confirmed and will be shipped soon.</p>
                        <p class="text-secondary-custom mb-4">You will receive an email confirmation shortly.</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="{{ url('/') }}" class="btn btn-primary-custom me-md-2">
                                <i class="fas fa-home me-2"></i>Back to Home
                            </a>
                            <a href="#" class="btn btn-outline-custom">
                                <i class="fas fa-download me-2"></i>Download Invoice
                            </a>
                        </div>
                    </div>
                `;
            }
        }
    });
</script>
@endsection
@endsection