@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="bg-onyx flex-grow-1 d-flex flex-column pb-5" style="padding-top: 120px;">
    <div class="container flex-grow-1 d-flex flex-column justify-content-center">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card p-5 animate-fade-in border border-silver-dim shadow-accent-glow">
                    <div class="row align-items-center">
                        {{-- LEFT SIDE CONTENT --}}
                        <div class="col-md-5 mb-5 mb-md-0 slide-in-left">
                            <h1 class="gradient-text section-title mb-4">Contact Our Concierge</h1>
                            <p class="text-silver opacity-75 lead mb-4">
                                Have questions about an exquisite timepiece or your bespoke order? Our specialists are dedicated to assisting you.
                            </p>

                            <div class="contact-info mt-5 pt-4 border-top border-silver-dim">
                                <p class="text-silver fw-bold mb-1">Direct Assistance</p>
                                <p class="text-accent fs-5">concierge@trymywatch.com</p>
                                <p class="text-silver-dim small mt-4">Average response time: 2-4 business hours.</p>
                            </div>
                        </div>

                        {{-- RIGHT SIDE FORM --}}
                        <div class="col-md-7">
                            <form method="POST" action="{{ route('contact.send') }}" class="ps-md-4">
                                @csrf

                                {{-- Order ID --}}
                                <div class="mb-4">
                                    <label class="text-silver-dim small text-uppercase fw-bold mb-2">Order Reference (Optional)</label>
                                    <input type="text" name="order_id" class="form-control premium-input shadow-sm"
                                           placeholder="e.g. #ORD-7892">
                                </div>

                                {{-- Name --}}
                                <div class="mb-4">
                                    <label class="text-silver-dim small text-uppercase fw-bold mb-2">FullName</label>
                                    <input type="text" name="name" class="form-control premium-input shadow-sm" 
                                           placeholder="Your name" required>
                                </div>

                                {{-- Email --}}
                                <div class="mb-4">
                                    <label class="text-silver-dim small text-uppercase fw-bold mb-2">Email Address</label>
                                    <input type="email" name="email" class="form-control premium-input shadow-sm" 
                                           placeholder="your@email.com" required>
                                </div>

                                {{-- Message --}}
                                <div class="mb-4">
                                    <label class="text-silver-dim small text-uppercase fw-bold mb-2">Your Inquiry</label>
                                    <textarea name="message" rows="5"
                                              class="form-control premium-input shadow-sm"
                                              placeholder="How can we assist you today?" required></textarea>
                                </div>

                                <button class="btn btn-primary-custom w-100 py-3 shadow-accent-glow">
                                    <i class="fas fa-paper-plane me-2"></i> Send Inquiry
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.4); }
    .border-silver-dim { border-color: rgba(197, 198, 199, 0.1) !important; }
</style>

@if(session('success'))
<script>
    // Simple alert for now, can be replaced with SweetAlert or a custom toast later
    alert("{{ session('success') }}");
</script>
@endif

@endsection
