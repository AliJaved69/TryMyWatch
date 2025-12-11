@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h1 style="margin-top: 80px;">Checkout Details</h1>

    <form id="payment-form" method="POST" action="{{ route('checkout.process') }}">
        @csrf

        <!-- User Info Fields -->
        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" id="phone" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Shipping Address</label>
            <textarea id="address" name="address" class="form-control" rows="3" required></textarea>
        </div>

        <!-- Payment Method Selector -->
        <div class="mb-3">
            <label class="form-label">Payment Method</label><br>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_method" id="payment_card" value="card" checked>
                <label class="form-check-label" for="payment_card">Credit/Debit Card</label>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod">
                <label class="form-check-label" for="payment_cod">Cash on Delivery</label>
            </div>
        </div>

        <!-- Hidden inputs for cart data -->
        <input type="hidden" id="cartItemsInput" name="items">
        <input type="hidden" id="totalPriceInput" name="total_price">

        <!-- Stripe Card Element Container -->
        <div id="card-element-container">
            <label for="card-element" class="form-label">Credit or debit card</label>
            <div id="card-element" class="bg-white mb-3" style="padding: 12px; border: 1px solid #ced4da; border-radius: 4px;"></div>

            <!-- Display error message to user -->
            <div id="card-errors" role="alert" style="color: red; margin-bottom: 15px;"></div>
        </div>

        <button id="submitBtn" class="btn btn-primary-custom px-4 py-2 mt-2" type="submit">Place Order</button>
    </form>
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

    const card = elements.create('card');
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

    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async function(event) {
        event.preventDefault();

        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        if(cart.length === 0){
            alert('Your cart is empty! Please add products before placing an order.');
            return;
        }

        let totalPrice = 0;
        cart.forEach(item => {
            totalPrice += item.price * item.quantity;
        });
        document.getElementById('cartItemsInput').value = JSON.stringify(cart);
        document.getElementById('totalPriceInput').value = totalPrice.toFixed(2);

        const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

        if(selectedPaymentMethod === 'card') {
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

