@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <style>
        .checkout-header {
            margin-bottom: 3rem;
        }

        .premium-label {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1.5px;
            color: var(--accent);
            margin-bottom: 0.75rem;
            opacity: 0.8;
        }

        .premium-input {
            background: rgba(11, 12, 16, 0.6) !important;
            border: 1px solid rgba(241, 229, 172, 0.1) !important;
            color: var(--text) !important;
            padding: 14px 20px !important;
            border-radius: 12px !important;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
        }

        .premium-input:focus {
            border-color: var(--accent) !important;
            box-shadow: 0 0 20px rgba(241, 229, 172, 0.15) !important;
            background: rgba(11, 12, 16, 0.8) !important;
        }

        .premium-input-container {
            background: rgba(11, 12, 16, 0.6);
            border: 1px solid rgba(241, 229, 172, 0.1);
            padding: 18px;
            border-radius: 12px;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .custom-radio {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(241, 229, 172, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .custom-radio input[type="radio"] {
            margin-left: 0.5rem;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .custom-radio:has(input:checked) {
            background: rgba(241, 229, 172, 0.05);
            border-color: var(--accent);
        }

        .order-summary-mini {
            background: rgba(241, 229, 172, 0.02);
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px dashed rgba(241, 229, 172, 0.1);
        }

        #submitBtn {
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 0.85rem;
            font-weight: 700;
            padding: 1.25rem !important;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-4 p-md-5 mt-5 animate-fade-in">
                    <div class="checkout-header text-center">
                        <p class="text-accent small text-uppercase fw-bold mb-2" style="letter-spacing: 3px;">Final
                            Acquisition</p>
                        <h1 class="gradient-text mb-3">Complete Your Purchase</h1>
                        <div class="d-flex justify-content-center">
                            <div style="width: 50px; height: 2px; background: var(--accent); opacity: 0.3;"></div>
                        </div>
                    </div>

                    <form id="payment-form" method="POST" action="{{ route('checkout.process') }}">
                        @csrf

                        <div class="row g-5">
                            <div class="col-lg-7">
                                <h5 class="text-bright mb-4 fs-6 fw-bold text-uppercase" style="letter-spacing: 1px;">
                                    Shipping Information</h5>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="name" class="premium-label">Full Name</label>
                                        <input type="text" id="name" name="name" class="form-control premium-input"
                                            placeholder="Enter your full name" required>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label for="email" class="premium-label">Email Address</label>
                                        <input type="email" id="email" name="email" class="form-control premium-input"
                                            placeholder="Enter your email address" required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="phone" class="premium-label">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control premium-input"
                                        placeholder="Enter your phone number" required>
                                </div>

                                <div class="mb-4">
                                    <label for="address" class="premium-label">Street Address</label>
                                    <input type="text" id="address" name="address" class="form-control premium-input"
                                        placeholder="e.g. 123 Luxury Ave, Apt 4B" required>
                                </div>

                                <div class="row">
                                    <div class="col-md-5 mb-4">
                                        <label for="city" class="premium-label">City</label>
                                        <input type="text" id="city" name="city" class="form-control premium-input"
                                            placeholder="e.g. Beverly Hills" required>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <label for="state" class="premium-label">State / Region</label>
                                        <input type="text" id="state" name="state" class="form-control premium-input"
                                            placeholder="e.g. CA" required>
                                    </div>
                                    <div class="col-md-3 mb-4">
                                        <label for="zip" class="premium-label">Zip Code</label>
                                        <input type="text" id="zip" name="zip" class="form-control premium-input"
                                            placeholder="e.g. 90210" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="order-summary-mini mb-5">
                                    <h5 class="text-bright mb-4 fs-6 fw-bold text-uppercase" style="letter-spacing: 1px;">
                                        Order Summary</h5>
                                    <div id="summary-items" class="mb-3">
                                        <!-- Items will be populated via JS or shown here -->
                                    </div>
                                    <div class="d-flex justify-content-between border-top border-silver-dim pt-3">
                                        <span class="text-silver-dim">Total Price</span>
                                        <span class="text-accent fw-bold fs-5" id="summary-total">$0.00</span>
                                    </div>
                                </div>

                                <h5 class="text-bright mb-4 fs-6 fw-bold text-uppercase" style="letter-spacing: 1px;">
                                    Payment Method</h5>

                                <div class="d-flex flex-column gap-3 mb-4">
                                    <div class="custom-radio d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" id="payment_card" value="card"
                                            style="cursor: pointer;" checked>
                                        <label class="text-silver mb-0 d-flex align-items-center gap-2" for="payment_card"
                                            style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-credit-card opacity-50"></i> Credit/Debit Card
                                        </label>
                                    </div>
                                    <div class="custom-radio d-flex align-items-center gap-3">
                                        <input type="radio" name="payment_method" id="payment_cod" value="cod"
                                            style="cursor: pointer;">
                                        <label class="text-silver mb-0 d-flex align-items-center gap-2" for="payment_cod"
                                            style="cursor: pointer; width: 100%;">
                                            <i class="fas fa-truck opacity-50"></i> Cash on Delivery
                                        </label>
                                    </div>
                                </div>

                                <!-- Stripe Card Element Container -->
                                <div id="card-element-container" class="mb-4 fade-in">
                                    <label for="card-element" class="premium-label">Card Details</label>
                                    <div id="card-element" class="premium-input-container"></div>
                                    <div id="card-errors" role="alert" class="mt-2 text-danger small"></div>
                                </div>

                                <input type="hidden" id="cartItemsInput" name="items">
                                <input type="hidden" id="totalPriceInput" name="total_price">

                                <div class="mt-4">
                                    <button id="submitBtn" class="btn btn-primary-custom w-100 py-3 shadow-accent-glow"
                                        type="submit">
                                        Place Order
                                    </button>
                                    <p class="text-center text-silver-dim small mt-3">
                                        <i class="fas fa-lock me-1 small"></i> End-to-End Secure Processing
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
            });
        </script>
    @endif

    <script>

        // 🔍 DEBUG: Check if Laravel is sending the Stripe key
        console.log("Stripe key from Laravel:", "{{ config('services.stripe.key') }}");

        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();

        const style = {
            base: {
                color: '#ffffff',
                fontFamily: '"Outfit", sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: 'rgba(255, 255, 255, 0.4)',
                }
            },
            invalid: {
                color: '#ff6b6b',
                iconColor: '#ff6b6b'
            }
        };

        const card = elements.create('card', { style: style });
        card.mount('#card-element');

        const cardContainer = document.getElementById('card-element-container');
        const paymentRadios = document.querySelectorAll('input[name="payment_method"]');

        function toggleCardElement() {
            if (document.getElementById('payment_card').checked) {
                cardContainer.style.display = 'block';
            } else {
                cardContainer.style.display = 'none';
                document.getElementById('card-errors').textContent = '';
            }
        }

        paymentRadios.forEach(radio => {
            radio.addEventListener('change', toggleCardElement);
        });

        toggleCardElement();

        card.on('change', function (event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        function populateOrderSummary() {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const summaryItems = document.getElementById('summary-items');
            const summaryTotal = document.getElementById('summary-total');
            const totalPriceInput = document.getElementById('totalPriceInput');
            const cartItemsInput = document.getElementById('cartItemsInput');
            const submitBtn = document.getElementById('submitBtn');

            if (cart.length === 0) {
                summaryItems.innerHTML = '<p class="text-silver-dim small">Your cart is empty.</p>';
                summaryTotal.textContent = '$0.00';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Cart is Empty';
                }
            } else {
                let html = '';
                let total = 0;
                cart.forEach(item => {
                    html += `
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-silver">${item.title} <span class="text-silver-dim">x${item.quantity}</span></span>
                                <span class="text-bright">$${(item.price * item.quantity).toFixed(2)}</span>
                            </div>
                        `;
                    total += item.price * item.quantity;
                });
                summaryItems.innerHTML = html;
                summaryTotal.textContent = `$${total.toFixed(2)}`;
                if (totalPriceInput) totalPriceInput.value = total.toFixed(2);
                if (cartItemsInput) cartItemsInput.value = JSON.stringify(cart);
            }
        }

        // Initialize on page load
        populateOrderSummary();

        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            const cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (cart.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Cart is Empty',
                    text: 'Please add items to your cart before checking out.',
                });
                return;
            }

            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

            if (selectedPaymentMethod === 'card') {
                document.getElementById('submitBtn').disabled = true;

                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        name: document.getElementById('name').value,
                        email: document.getElementById('email').value,
                    },
                });

                if (error) {
                    document.getElementById('card-errors').textContent = error.message;
                    document.getElementById('submitBtn').disabled = false;
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'payment_method_id';
                    hiddenInput.value = paymentMethod.id;
                    form.appendChild(hiddenInput);

                    form.submit();
                }
            } else {
                form.submit();
            }
        });
    </script>
@endsection