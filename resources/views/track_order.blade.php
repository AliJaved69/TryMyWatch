@extends('layouts.app')

@section('title', 'Track Your Order')

@section('content')
<style>
    .track-container {
        margin-top: 100px;
        min-height: 70vh;
    }
    .track-input-card {
        background: rgba(31, 40, 51, 0.4);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(241, 229, 172, 0.1);
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
    }
    .luxury-search-form {
        background: rgba(11, 12, 16, 0.8);
        border: 1px solid rgba(241, 229, 172, 0.15);
        border-radius: 50px;
        padding: 6px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3), inset 0 2px 10px rgba(0,0,0,0.5);
        transition: all 0.3s ease;
    }
    .luxury-search-form:focus-within {
        border-color: var(--accent);
        box-shadow: 0 0 30px rgba(241, 229, 172, 0.25), inset 0 2px 10px rgba(0,0,0,0.5);
    }
    .search-field-icon {
        position: absolute;
        left: 24px;
        color: rgba(241, 229, 172, 0.4);
        font-size: 1.2rem;
        pointer-events: none;
    }
    .luxury-search-input {
        background: transparent !important;
        border: none !important;
        color: #ffffff !important;
        font-family: monospace;
        font-size: 1.1rem;
        padding: 12px 20px 12px 55px !important;
        border-radius: 50px !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .luxury-search-input::placeholder {
        color: rgba(255, 255, 255, 0.3) !important;
    }
    .luxury-search-btn {
        background: var(--accent) !important;
        color: var(--primary) !important;
        font-weight: 800;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-radius: 50px !important;
        padding: 12px 30px !important;
        border: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 5px 15px rgba(241, 229, 172, 0.2) !important;
    }
    .luxury-search-btn:hover {
        background: var(--accent-light) !important;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(241, 229, 172, 0.4) !important;
    }
    .luxury-search-btn:active {
        transform: translateY(0);
    }
    
    /* Timeline styling */
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        margin: 3rem 0;
    }
    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        z-index: 1;
    }
    .timeline-progress {
        position: absolute;
        top: 25px;
        left: 0;
        height: 4px;
        background: var(--accent);
        z-index: 2;
        transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .timeline-step {
        position: relative;
        z-index: 3;
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 120px;
    }
    .step-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: var(--primary);
        border: 2px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        margin-bottom: 0.75rem;
        transition: all 0.5s ease;
    }
    .timeline-step.active .step-icon {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
        box-shadow: 0 0 20px var(--accent);
    }
    .timeline-step.completed .step-icon {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }
    .step-text {
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.4);
        text-align: center;
        transition: color 0.5s ease;
    }
    .timeline-step.active .step-text, .timeline-step.completed .step-text {
        color: var(--text-bright);
    }
    
    /* Order info section */
    .order-info-card {
        background: rgba(31, 40, 51, 0.25);
        border: 1px solid rgba(241, 229, 172, 0.08);
        border-radius: 15px;
        padding: 2rem;
        margin-top: 2rem;
    }
    .track-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid rgba(241, 229, 172, 0.1);
    }
</style>

<div class="container track-container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            
            <!-- Lookup Form -->
            <div class="track-input-card text-center mb-5 animate-fade-in">
                <p class="text-accent small text-uppercase fw-bold mb-2" style="letter-spacing: 3px;">Boutique Services</p>
                <h1 class="gradient-text mb-4">Orchestration Tracker</h1>
                <p class="text-silver-dim mb-4" style="max-width: 500px; margin: 0 auto 2rem;">
                    Enter your unique luxury acquisition tracking identifier below to check its current fulfillment and delivery state.
                </p>
                
                <form action="{{ route('order.track') }}" method="GET" class="luxury-search-form mx-auto" style="max-width: 550px;">
                    <div class="position-relative d-flex align-items-center w-100">
                        <i class="fas fa-search search-field-icon"></i>
                        <input type="text" name="tracking_id" class="form-control luxury-search-input flex-grow-1" placeholder="e.g. TMW-ABC123XYZ" value="{{ $trackingId }}" required autocomplete="off">
                        <button class="btn luxury-search-btn" type="submit">
                            Track
                        </button>
                    </div>
                </form>

                @if($error)
                    <div class="mt-4 text-danger small bg-danger bg-opacity-10 p-3 rounded-3 border border-danger border-opacity-20 animate-fade-in">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ $error }}
                    </div>
                @endif
            </div>

            <!-- Tracking Results -->
            @if($order)
                @php
                    // Define status progression
                    $statusSteps = ['pending', 'processing', 'shipped', 'completed'];
                    $currentStatusIndex = array_search($order->status, $statusSteps);
                    if ($currentStatusIndex === false) {
                        $currentStatusIndex = 0; // Default fallback
                    }
                    
                    // Compute progress bar width
                    $progressPercentage = ($currentStatusIndex / (count($statusSteps) - 1)) * 100;
                @endphp
                
                <div class="track-input-card animate-fade-in" style="animation-delay: 0.15s;">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 pb-3 border-bottom border-silver-dim">
                        <div>
                            <span class="text-silver-dim small text-uppercase">Tracking Reference</span>
                            <h4 class="text-accent fw-bold mb-0 mt-1">{{ $order->order_number }}</h4>
                        </div>
                        <div class="text-sm-end">
                            <span class="text-silver-dim small text-uppercase">Acquisition Date</span>
                            <p class="text-bright fw-bold mb-0 mt-1">{{ $order->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Progress Timeline -->
                    @if($order->status === 'cancelled')
                        <div class="my-5 text-center p-4 bg-danger bg-opacity-10 border border-danger border-opacity-20 rounded-3">
                            <i class="fas fa-ban text-danger fa-3x mb-3"></i>
                            <h5 class="text-bright fw-bold mb-1">Acquisition Voided</h5>
                            <p class="text-silver-dim mb-0">This order has been cancelled. If you believe this is an error, please reach out to concierge.</p>
                        </div>
                    @else
                        <div class="timeline-steps">
                            <div class="timeline-progress" style="width: {{ $progressPercentage }}%;"></div>
                            
                            <div class="timeline-step {{ $currentStatusIndex >= 0 ? ($currentStatusIndex == 0 ? 'active' : 'completed') : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-file-invoice"></i>
                                </div>
                                <span class="step-text">Placed</span>
                            </div>
                            
                            <div class="timeline-step {{ $currentStatusIndex >= 1 ? ($currentStatusIndex == 1 ? 'active' : 'completed') : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <span class="step-text">Preparing</span>
                            </div>
                            
                            <div class="timeline-step {{ $currentStatusIndex >= 2 ? ($currentStatusIndex == 2 ? 'active' : 'completed') : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <span class="step-text">Transit</span>
                            </div>
                            
                            <div class="timeline-step {{ $currentStatusIndex >= 3 ? 'completed active' : '' }}">
                                <div class="step-icon">
                                    <i class="fas fa-gift"></i>
                                </div>
                                <span class="step-text">Delivered</span>
                            </div>
                        </div>
                    @endif

                    <!-- Details Accordion/List -->
                    <div class="row g-4 mt-2">
                        <div class="col-md-6">
                            <div class="order-info-card h-100">
                                <h6 class="text-accent text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Customer Information</h6>
                                <p class="text-white mb-0" style="line-height: 1.8;">
                                    <strong>Name:</strong> {{ $order->name }}<br>
                                    <strong>Direct Line:</strong> {{ $order->phone }}<br>
                                    <strong>Email:</strong> {{ $order->email }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="order-info-card h-100">
                                <h6 class="text-accent text-uppercase fw-bold mb-3" style="font-size: 0.75rem; letter-spacing: 1px;">Destination Coordinates</h6>
                                <p class="text-white mb-0" style="line-height: 1.8;">
                                    {{ $order->address }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Itemized Overview -->
                    <div class="order-info-card mt-4">
                        <h6 class="text-accent text-uppercase fw-bold mb-4" style="font-size: 0.75rem; letter-spacing: 1px;">Acquisition Pieces</h6>
                        <div class="table-responsive">
                            <table class="table table-dark table-borderless align-middle">
                                <thead>
                                    <tr class="border-bottom border-silver-dim" style="font-size: 0.8rem; color: rgba(255,255,255,0.4); text-transform: uppercase;">
                                        <th>Piece</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-end">Investment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $items = is_string($order->items) ? json_decode($order->items, true) : $order->items;
                                    @endphp
                                    @foreach($items as $item)
                                        <tr class="border-bottom border-silver-dim border-opacity-10">
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(isset($item['thumbnail']) || isset($item['image']))
                                                        <img src="{{ $item['thumbnail'] ?? $item['image'] }}" alt="{{ $item['title'] ?? $item['name'] ?? 'Product' }}" class="track-item-img me-3">
                                                    @endif
                                                    <div>
                                                        <span class="text-bright fw-bold d-block">{{ $item['title'] ?? $item['name'] ?? 'Product' }}</span>
                                                        <small class="text-accent">$ {{ number_format($item['price'], 2) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center text-silver-dim">x{{ $item['quantity'] }}</td>
                                            <td class="text-end text-bright fw-bold">$ {{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="fs-5">
                                        <td colspan="2" class="text-end fw-bold text-silver-dim pt-3">Total Investment</td>
                                        <td class="text-end fw-bold text-accent pt-3">$ {{ number_format($order->total_price, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
