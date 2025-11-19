@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="container py-5" style="margin-top: 60px;">
    <h2 class="fw-bold">About <span class="text-primary">TryMyWatch</span></h2>

    <p class="mt-3 text-secondary" style="font-size: 16px; line-height: 1.7;">
        TryMyWatch is a next-generation e-commerce platform designed for modern watch shopping.
        Our Final Year Project focuses on combining:
    </p>

    <ul class="text-secondary" style="line-height: 1.8;">
        <li><strong>Augmented Reality (AR):</strong> Users can preview how a watch looks on their wrist before buying.</li>
        <li><strong>Artificial Intelligence (AI):</strong> Smart wrist detection + watch placement + recommendation.</li>
        <li><strong>User-Friendly Store Experience:</strong> Browse, select, and test watches virtually before checkout.</li>
    </ul>

    <p class="mt-3 text-secondary" style="font-size: 16px; line-height: 1.7;">
        Before checkout, users can upload a picture of their wrist or use real-time AR mode.
        Our system automatically detects the wrist area and places the selected watch accurately,
        allowing users to confirm size, color, and style before purchase.
    </p>

    <h3 class="fw-bold mt-5">Our Technology</h3>
    <p class="mt-3 text-secondary" style="font-size: 16px; line-height: 1.7;">
        TryMyWatch integrates three advanced models:
    </p>

    <ul class="text-secondary" style="line-height: 1.8;">
        <li><strong>1. Wrist Detection Model:</strong> Identifies wrist area from the uploaded image.</li>
        <li><strong>2. Watch Placement Model:</strong> Fits the selected watch precisely on the wrist.</li>
        <li><strong>3. Recommendation Model:</strong> Suggests watches based on user activity and preferences.</li>
    </ul>

    <p class="text-secondary mt-3" style="font-size: 16px;">
        Our mission is to bring trust and confidence to online watch shopping 
        by providing a realistic, intelligent, and interactive experience.
    </p>
</div>
@endsection
