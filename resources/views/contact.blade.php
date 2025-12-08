@extends('layouts.app')

@section('title', 'Contact')

@section('content')

<div class="container" style="margin-top: 80px;">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="row bg-dark p-5 rounded-4 shadow-lg">

                {{-- LEFT SIDE CONTENT --}}
                <div class="col-md-5 mb-4">
                    <h1 class="text-white fw-bold mb-4">Contact Us</h1>
                    <p class="text-white-50 mb-3">
                        Have questions about your order, product, or anything else?
                        We're here to help and will respond quickly.
                    </p>

                    <p class="text-white-50 mb-3">
                        Please include your Order ID (if you have one)  
                        so we can assist you faster.
                    </p>
                </div>

                {{-- RIGHT SIDE FORM --}}
                <div class="col-md-7">

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf

                        {{-- Order ID --}}
                        <div class="mb-3">
                            <label class="text-white fw-semibold">Order ID (if applicable)</label>
                            <input type="text" name="order_id" class="form-control rounded-3"
                                   placeholder="Enter your order ID">
                        </div>

                        {{-- Name --}}
                        <div class="mb-3">
                            <label class="text-white fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-3"
                                   style="background:#fff;" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="text-white fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3"
                                   style="background:#fff;" required>
                        </div>

                        {{-- Message --}}
                        <div class="mb-3">
                            <label class="text-white fw-semibold">Message</label>
                            <textarea name="message" rows="4"
                                      class="form-control rounded-3"
                                      style="background:#fff;" required></textarea>
                        </div>

                        <button class="btn btn-primary-custom px-4 py-2 rounded-pill mt-2">
                            Send Message
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@if(session('success'))
<script>
    alert("{{ session('success') }}");
</script>
@endif

@endsection
