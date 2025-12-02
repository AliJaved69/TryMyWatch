@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container py-5" id="contact" style="max-width: 700px; margin-top: 40px;">

    <h1 class="text-white mb-4">Contact Us</h1>

    <form method="POST" action="{{ route('contact.send') }}">
        @csrf

         {{-- Optional Order ID --}}
        <label class="text-white mb-1 fw-semibold">Order ID (if applicable)</label>
        <input type="text" name="order_id" class="form-control mb-4" placeholder="Enter your order ID if you have one">


        {{-- Name --}}
        <label class="text-white mb-1 fw-semibold">Full Name</label>
        <input 
            type="text" 
            name="name" 
            class="form-control mb-4"
            style="background:#fff; border-radius:10px; height:40px;"
            required>

        {{-- Email --}}
        <label class="text-white mb-1 fw-semibold">Email Address</label>
        <input 
            type="email" 
            name="email" 
            class="form-control mb-4"
            style="background:#fff; border-radius:10px; height:40px;"
            required>

        {{-- Message --}}
        <label class="text-white mb-1 fw-semibold">Message</label>
        <textarea 
            name="message" 
            rows="4"
            class="form-control mb-4"
            style="background:#fff; border-radius:10px;"
            required></textarea>

        <button 
            class="btn btn-primary-custom px-4 py-2 mt-2"
            type="submit">
            Send Message
        </button>

    </form>

</div>

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

@endsection
