@extends('layouts.app')

@section('title', 'Login - TryMyWatch')

@section('content')
<div class="container py-5" style="max-width: 400px; margin-top: 60px;">
    <h2 class="mb-4 text-center gradient-text">Login to Your Account</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label text-secondary-custom">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-secondary-custom">Password</label>
            <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <button type="submit" class="btn btn-primary-custom w-100 btn-glow">Login</button>
    </form>

    <p class="mt-3 text-center">
        Don't have an account? <a href="{{ route('signup') }}" class="text-accent">Sign up here</a>.
    </p>
</div>
@endsection
