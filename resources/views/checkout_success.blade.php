@extends('layouts.app')

@section('title', 'Order Success')

@section('content')
<div class="container mt-5">
    <h1 style="margin-top: 80px;">Thank you!</h1>
    <p>Your order has been placed successfully.</p>
    <a href="{{ url('/shop') }}" class="btn btn-primary">Continue Shopping</a>
</div>
@endsection

@section('scripts')
<script>
    localStorage.removeItem('cart');
</script>
@endsection

