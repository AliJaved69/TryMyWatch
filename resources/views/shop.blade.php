@extends('layouts.app')

@section('content')
<style>
    .category-filters-container {
        padding: 15px 0 25px;
    }
    .filter-tab {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(197, 198, 199, 0.1);
        color: var(--text-secondary);
        padding: 10px 24px;
        border-radius: 30px;
        font-weight: 500;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .filter-tab:hover {
        background: rgba(241, 229, 172, 0.05);
        border-color: var(--accent);
        color: var(--accent);
        transform: translateY(-2px);
    }
    .filter-tab.active {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary) !important;
        box-shadow: 0 4px 15px rgba(241, 229, 172, 0.25);
    }
    .category-section-header {
        border-color: rgba(197, 198, 199, 0.08) !important;
    }
    .text-silver-dim {
        color: rgba(197, 198, 199, 0.4);
    }
</style>

<div class="shop-wrapper container-fluid min-vh-100">
    <div class="shop-head" style="margin-top: 40px;">
        <div>
            <div class="section-tag">The Collection</div>
            <h2 class="section-title">Featured <em>Timepieces</em></h2>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    <div class="category-filters-container mb-4">
        <div class="category-filters d-flex flex-wrap gap-2 justify-content-start align-items-center">
            <a href="{{ route('shop', ['category' => 'all']) }}" 
               class="filter-tab {{ $selectedCategory === 'all' ? 'active' : '' }}">
               All Collection
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('shop', ['category' => $cat]) }}" 
                   class="filter-tab {{ $selectedCategory === $cat ? 'active' : '' }}">
                   {{ $cat }}
                </a>
            @endforeach
        </div>
    </div>

    @php
        $safeProducts = $products ?? collect();
        if (!method_exists($safeProducts, 'chunk')) {
            $safeProducts = collect($safeProducts);
        }
        $groupedProducts = $safeProducts->groupBy('category');
    @endphp

    <div class="shop-sections-container">
        @if($safeProducts->isNotEmpty())
            @foreach($groupedProducts as $categoryName => $catProducts)
                <div class="category-section mb-5">
                    <div class="category-section-header d-flex justify-content-between align-items-center mb-4 border-bottom border-silver-dim pb-2">
                        <h3 class="gradient-text fs-4 mb-0"><i class="fas fa-gem me-2 text-accent"></i>{{ $categoryName }}</h3>
                        <span class="text-silver-dim small">{{ $catProducts->count() }} {{ $catProducts->count() === 1 ? 'Timepiece' : 'Timepieces' }}</span>
                    </div>
                    
                    <div class="shop-grid">
                        @foreach($catProducts as $index => $product)
                            @php
                                $productId = $product['id'] ?? 1;
                                $productTitle = $product['title'] ?? 'No Title';
                                $productPrice = $product['price'] ?? 0;
                                $productThumbnail = $product['thumbnail'] ?? '';
                                $productCategory = $product['category'] ?? 'Watch';
                            @endphp

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
                        @endforeach
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center">
                <div class="glass-card p-5 mt-4">
                    <h4 class="text-silver mb-3">No watches available at the moment.</h4>
                    <p class="text-secondary-custom">Please check back later for our new arrivals.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
