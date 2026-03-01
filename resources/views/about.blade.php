@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="bg-onyx min-vh-100 py-5">
    <div class="container" style="margin-top: 120px;">

        <!-- Header Section -->
        <div class="text-center mb-5 animate-fade-in">
            <h1 class="section-title gradient-text mb-3">A New Vision in Luxury</h1>
            <p class="text-silver opacity-75 mx-auto" style="max-width: 700px; font-size: 1.1rem;">
                TryMyWatch bridges the gap between digital convenience and the tactile allure of fine watchmaking through revolutionary AI & AR technology.
            </p>
        </div>

        <!-- Card Section -->
        <div class="row g-4">

            <!-- Intro Card -->
            <div class="col-lg-6 slide-in-left">
                <div class="glass-card p-5 h-100 border border-silver-dim shadow-accent-glow">
                    <h4 class="text-accent fw-bold mb-4"><i class="fas fa-history me-2"></i>Our Heritage</h4>
                    <p class="text-silver opacity-75 lead" style="line-height: 1.8;">
                        TryMyWatch is an innovative e-commerce platform that transforms how people shop for watches online. Our mission is to merge advanced Artificial Intelligence and Augmented Reality to deliver a smart, interactive, and premium buying experience.
                    </p>
                </div>
            </div>

            <!-- Technology Description -->
            <div class="col-lg-6 slide-in-left" style="animation-delay: 0.2s;">
                <div class="glass-card p-5 h-100 border border-silver-dim">
                    <h4 class="text-accent fw-bold mb-4"><i class="fas fa-vr-cardboard me-2"></i>What We Do</h4>
                    <ul class="text-silver list-unstyled" style="line-height: 2.2;">
                        <li><i class="fas fa-check-circle text-accent me-2"></i><strong>AR Wrist Preview:</strong> Try watches virtually in real-time.</li>
                        <li><i class="fas fa-microchip text-accent me-2"></i><strong>AI Smart Detection:</strong> Automated wrist tracking & placement.</li>
                        <li><i class="fas fa-gem text-accent me-2"></i><strong>Exclusive Portal:</strong> Browse and test premium collections.</li>
                    </ul>
                </div>
            </div>

        </div>

        <!-- Technology Section -->
        <div class="glass-card border border-silver-dim mt-5 animate-fade-in p-5 shadow-lg" style="animation-delay: 0.4s;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="text-accent fw-bold mb-4">The Intelligent Engine</h3>
                    <p class="text-silver opacity-75 mb-4" style="font-size: 1.1rem;">
                        TryMyWatch integrates three powerful AI-driven models tailored for the luxury market:
                    </p>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-dark border border-silver-dim">
                                <span class="text-accent d-block mb-1 fw-bold">01. Detection</span>
                                <small class="text-silver-dim">Precise wrist area isolation.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-dark border border-silver-dim">
                                <span class="text-accent d-block mb-1 fw-bold">02. Synthesis</span>
                                <small class="text-silver-dim">Photorealistic watch placement.</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-dark border border-silver-dim">
                                <span class="text-accent d-block mb-1 fw-bold">03. Curate</span>
                                <small class="text-silver-dim">Personalized luxury suggestions.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center mt-5 mt-lg-0">
                    <i class="fas fa-robot fa-5x text-accent opacity-25"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .text-silver-dim { color: rgba(197, 198, 199, 0.4); }
    .border-silver-dim { border-color: rgba(197, 198, 199, 0.1) !important; }
</style>
@endsection
