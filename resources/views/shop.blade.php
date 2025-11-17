@extends('layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <h2 class="mb-4 text-center" style="margin-top: 50px;">Watches</h2>

        @php
            // Safely get products and ensure it's a collection
            $safeProducts = $products ?? collect();
            if (!method_exists($safeProducts, 'chunk')) {
                $safeProducts = collect($safeProducts);
            }
            $chunks = $safeProducts->chunk(4);
        @endphp

        <div id="watchesCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
            <div class="carousel-inner">
                @if($chunks->isNotEmpty())
                    @foreach($chunks as $chunkIndex => $chunk)
                        <div class="carousel-item @if($chunkIndex == 0) active @endif">
                            <div class="row justify-content-center g-4">
                                @foreach($chunk as $product)
                                    @php
                                        // Safely access product properties
                                        $productId = $product['id'] ?? 1;
                                        $productTitle = $product['title'] ?? 'No Title';
                                        $productPrice = $product['price'] ?? 0;
                                        $productThumbnail = $product['thumbnail'] ?? '';
                                        $productRating = $product['rating'] ?? 0;

                                        // Sanitize reviews count to avoid array/string issues
                                        $productReviews = $product['reviews'] ?? 0;
                                        $safeReviews = is_array($productReviews) ? count($productReviews) : (int)$productReviews;
                                    @endphp
                                    
                                    <div class="col-lg-3 col-md-6 mb-4">
                                        <div class="card bg-dark text-white border-0 shadow-lg rounded h-100 product-card">
                                            <div class="image-container" style="height: 250px; overflow: hidden;">
                                                @if(!empty($productThumbnail) && is_string($productThumbnail))
                                                    <img src="{{ $productThumbnail }}" 
                                                         class="card-img-top h-100 object-fit-cover" 
                                                         alt="{{ $productTitle }}"
                                                         loading="lazy"
                                                         onerror="this.src='https://via.placeholder.com/300x300/333333/FFFFFF?text=No+Image'">
                                                @else
                                                    <div class="card-img-top h-100 bg-secondary d-flex align-items-center justify-content-center">
                                                        <span class="text-muted">No Image</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="card-body text-center d-flex flex-column">
                                                <h5 class="card-title fs-6">
                                                    {{ \Illuminate\Support\Str::limit($productTitle, 50) }}
                                                </h5>
                                                <p class="card-text text-warning fw-bold mt-auto mb-2">
                                                    ${{ number_format((float)$productPrice, 2) }}
                                                </p>
                                                @if($productRating > 0)
                                                    <div class="rating mb-2">
                                                        <small class="text-muted">
                                                            ⭐ {{ number_format((float)$productRating, 1) }} 
                                                            ({{ $safeReviews }})
                                                        </small>
                                                    </div>
                                                @endif
                                                <a href="{{ route('product.show', $productId) }}" 
                                                   class="btn btn-primary-custom w-100 mt-auto">
                                                    View Details
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
                        <div class="row justify-content-center">
                            <div class="col-12 text-center py-5">
                                <h4 class="text-muted">No watches available at the moment.</h4>
                                <p class="text-muted">Please check back later.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if($chunks->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#watchesCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#watchesCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>

                <div class="carousel-indicators position-relative mt-4">
                    @foreach($chunks as $chunkIndex => $chunk)
                        <button type="button" 
                                data-bs-target="#watchesCarousel" 
                                data-bs-slide-to="{{ $chunkIndex }}" 
                                class="@if($chunkIndex == 0) active @endif bg-dark rounded-circle mx-1"
                                style="width: 10px; height: 10px;"
                                aria-label="Slide {{ $chunkIndex + 1 }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>

<style>
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3) !important;
}

.object-fit-cover {
    object-fit: cover;
    width: 100%;
}

.carousel-indicators button {
    border: none;
    opacity: 0.5;
}

.carousel-indicators button.active {
    opacity: 1;
}
</style>
@endsection
