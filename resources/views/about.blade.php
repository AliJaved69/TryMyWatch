@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5" style="margin-top: 80px;">

    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="fw-bold text-white">
            About <span class="text-accent">TryMyWatch</span>
        </h1>
        <p class="text-secondary mt-2" style="max-width: 650px; margin: auto; font-size: 17px;">
            A next-generation watch shopping experience powered by AI & AR technology.
        </p>
    </div>

    <!-- Card Section -->
    <div class="row g-4">

        <!-- Intro Card -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg h-100" style="background-color: #1a1a1a;">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-accent mb-3">Who We Are</h4>
                    <p class="text-secondary" style="line-height: 1.8;">
                        TryMyWatch is an innovative e-commerce platform that transforms
                        how people shop for watches online. Our FYP focuses on merging
                        advanced Artificial Intelligence and Augmented Reality to deliver
                        a smart, interactive buying experience.
                    </p>
                </div>
            </div>
        </div>

        <!-- Technology Description -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg h-100" style="background-color: #1a1a1a;">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-accent mb-3">What We Do</h4>
                    <ul class="text-secondary" style="line-height: 1.8;">
                        <li><strong>AR Wrist Preview:</strong> Try watches virtually on your wrist before buying.</li>
                        <li><strong>AI Smart Detection:</strong> Automatic wrist detection + watch placement.</li>
                        <li><strong>Real Store Feel:</strong> Browse, test, and experience watches virtually.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <!-- Technology Section -->
    <div class="card border-0 shadow-lg mt-5" style="background-color: #1a1a1a;">
        <div class="card-body p-4">
            <h3 class="fw-bold text-accent mb-3">Our Technology</h3>
            <p class="text-secondary mb-3" style="font-size: 16px;">
                TryMyWatch integrates three powerful AI-driven models:
            </p>

            <ul class="text-secondary" style="line-height: 1.8;">
                <li><strong>1. Wrist Detection Model:</strong> Detects wrist area from images.</li>
                <li><strong>2. Watch Placement Model:</strong> Places the selected watch perfectly.</li>
                <li><strong>3. Recommendation Model:</strong> Suggests watches based on user behavior.</li>
            </ul>

            <p class="text-secondary mt-3" style="font-size: 16px;">
                Our mission is to bring confidence to online watch shopping with realistic,
                intelligent, and interactive technology.
            </p>
        </div>
    </div>

</div>
@endsection
