@extends('layouts.app')

@section('content')
<div class="shop-wrapper container-fluid min-vh-100">
    <div class="shop-head" style="margin-top: 40px;">
        <div>
            <div class="section-tag">The Collection</div>
            <h2 class="section-title">Featured <em>Timepieces</em></h2>
        </div>
        <a class="see-all" href="#">View All Watches <i class="fas fa-arrow-right ms-2"></i></a>
    </div>

    @php
        $safeProducts = $products ?? collect();
        if (!method_exists($safeProducts, 'chunk')) {
            $safeProducts = collect($safeProducts);
        }
    @endphp

    <div class="shop-grid">
        @if($safeProducts->isNotEmpty())
            @foreach($safeProducts as $index => $product)
                @php
                    $productId = $product['id'] ?? 1;
                    $productTitle = $product['title'] ?? 'No Title';
                    $productPrice = $product['price'] ?? 0;
                    $productThumbnail = $product['thumbnail'] ?? '';
                    $productCategory = $product['category'] ?? 'Watch';
                    $productDesc = $product['description'] ?? rtrim(substr($productTitle, 0, 100), '.').'.';
                @endphp

                @if($index === 0)
                    <a href="{{ route('product.show', $productId) }}" class="shop-card card-wide glare-hover">
                        <div class="card-wide-img">
                            @if(!empty($productThumbnail) && is_string($productThumbnail))
                                <img src="{{ $productThumbnail }}" class="watch-img" style="height:260px;" alt="{{ $productTitle }}">
                            @else
                                <div style="height:260px; display:flex; align-items:center; justify-content:center; color:var(--text-secondary);">No Image</div>
                            @endif
                        </div>
                        <div class="card-wide-content">
                            <div class="card-num">01</div>
                            <div class="card-tag">{{ $productCategory }}</div>
                            <div class="card-name">{{ $productTitle }}</div>
                            <div class="card-wide-desc">{{ \Illuminate\Support\Str::limit($productDesc, 120) }}</div>
                            <div class="card-bottom">
                                <div class="card-price gradient-text">${{ number_format((float)$productPrice, 2) }}</div>
                            </div>
                        </div>
                    </a>
                @else
                    <a href="{{ route('product.show', $productId) }}" class="shop-card glare-hover">
                        <div class="card-num">{{ sprintf('%02d', $index + 1) }}</div>
                        <div class="card-tag">{{ $productCategory }}</div>
                        <div class="watch-img-container">
                            @if(!empty($productThumbnail) && is_string($productThumbnail))
                                <img src="{{ $productThumbnail }}" class="watch-img" alt="{{ $productTitle }}">
                            @else
                                <div style="color:var(--text-secondary);">No Image</div>
                            @endif
                        </div>
                        <div class="card-name">{{ $productTitle }}</div>
                        <div class="card-bottom">
                            <div class="card-price gradient-text">${{ number_format((float)$productPrice, 2) }}</div>
                        </div>
                    </a>
                @endif
            @endforeach
        @else
            <div class="col-12 text-center" style="grid-column: 1 / -1;">
                <div class="glass-card p-5 mt-4">
                    <h4 class="text-silver mb-3">No watches available at the moment.</h4>
                    <p class="text-secondary-custom">Please check back later for our new arrivals.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
