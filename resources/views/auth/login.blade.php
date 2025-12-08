@extends('layouts.app')

@section('title', 'Login - TryMyWatch')

@section('content')

<div class="container" style="margin-top: 80px;">

    <div class="row justify-content-center">
        <div class="col-lg-6">

            {{-- MATCHING CONTACT PAGE CARD STYLE --}}
            <div class="bg-dark p-5 rounded-4 shadow-lg">

                {{-- TITLE --}}
                <h2 class="mb-4 text-center gradient-text">Login to Your Account</h2>

                {{-- Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- SAME FORM YOU ALREADY HAVE --}}
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label text-secondary-custom">Email address</label>
                        <input type="email" 
                               class="form-control rounded-3" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required />
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary-custom">Password</label>
                        <input type="password" 
                               class="form-control rounded-3" 
                               id="password" 
                               name="password" 
                               required />
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 btn-glow rounded-pill">
                        Login
                    </button>
                </form>

                <p class="mt-3 text-center text-white-50">
                    Don't have an account?
                    <a href="{{ route('signup') }}" class="text-accent">Sign up here</a>.
                </p>

            </div>

        </div>
    </div>
</div>

@endsection
