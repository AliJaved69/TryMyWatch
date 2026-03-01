@extends('layouts.app')

@section('content')
<section class="py-5 bg-onyx min-vh-100">
    <div class="container" style="margin-top: 80px;">
        <div class="text-center mb-5">
            <h2 class="section-title gradient-text">Exquisite Timepieces</h2>
            <p class="text-silver opacity-75">Discover our curated collection of luxury watches</p>
        </div>

        @php
            $safeProducts = $products ?? collect();
            if (!method_exists($safeProducts, 'chunk')) {
                $safeProducts = collect($safeProducts);
            }
            $chunks = $safeProducts->chunk(4);
        @endphp

        <div id="watchesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @if($chunks->isNotEmpty())
                    @foreach($chunks as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex == 0) active @endif">
                            <div class="row justify-content-center g-4">
                                @foreach($chunk as $product)
                                    @php
                                        $productId = $product['id'] ?? 1;
                                        $productTitle = $product['title'] ?? 'No Title';
                                        $productPrice = $product['price'] ?? 0;
                                        $productThumbnail = $product['thumbnail'] ?? '';
                                        $productRating = $product['rating'] ?? 0;
                                        $productReviews = $product['reviews'] ?? 0;
                                        $safeReviews = is_array($productReviews) ? count($productReviews) : (int)$productReviews;
                                    @endphp
                                    
                                    <div class="col-lg-3 col-md-6">
                                        <div class="glass-card product-card h-100 d-flex flex-column border border-silver-dim overflow-hidden">
                                            <div class="image-container position-relative" style="height: 250px;">
                                                @if(!empty($productThumbnail) && is_string($productThumbnail))
                                                    <img src="{{ $productThumbnail }}" 
                                                         class="card-img-top h-100 w-100 object-fit-cover" 
                                                         alt="{{ $productTitle }}">
                                                @else
                                                    <div class="h-100 bg-secondary d-flex align-items-center justify-content-center">
                                                        <span class="text-muted">No Image</span>
                                                    </div>
                                                @endif
                                                <div class="card-overlay">
                                                    <a href="{{ route('product.show', $productId) }}" class="btn btn-primary-custom btn-sm">
                                                        <i class="fas fa-eye me-1"></i> Details
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body p-4 text-center d-flex flex-column">
                                                <h5 class="text-silver fw-bold mb-2">
                                                    {{ \Illuminate\Support\Str::limit($productTitle, 35) }}
                                                </h5>
                                                <div class="price-tag mb-3">
                                                    <span class="gradient-text h5 fw-bold">${{ number_format((float)$productPrice, 2) }}</span>
                                                </div>
                                                
                                                <div class="d-flex justify-content-center align-items-center gap-2 mb-3">
                                                    @if($productRating > 0)
                                                        <span class="text-accent small">
                                                            <i class="fas fa-star me-1"></i>{{ number_format((float)$productRating, 1) }}
                                                        </span>
                                                        <span class="text-secondary-custom small">({{ $safeReviews }})</span>
                                                    @endif
                                                </div>

                                                <a href="{{ route('product.show', $productId) }}" 
                                                   class="btn btn-outline-custom w-100 mt-auto btn-sm">
                                                    View Collection
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <div class="glass-card p-5 text-center">
                            <h4 class="text-silver">No watches available at the moment.</h4>
                            <p class="text-secondary-custom">Please check back later for our new arrivals.</p>
                        </div>
                    </div>
                @endif
            </div>

            @if($chunks->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#watchesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon p-3 glass-card rounded-circle" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#watchesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon p-3 glass-card rounded-circle" aria-hidden="true"></span>
                </button>
            @endif
        </div>
    </div>
</section>

<style>
    .product-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .product-card:hover {
        transform: translateY(-10px);
    }
    .card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 12, 16, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        backdrop-filter: blur(2px);
    }
    .product-card:hover .card-overlay {
        opacity: 1;
    }
    .border-silver-dim {
        border-color: rgba(197, 198, 199, 0.05) !important;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection
