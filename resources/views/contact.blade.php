@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container py-5" id="contact">
    <h2>Contact Us</h2>

    <form class="mt-4" method="POST" action="#">
        @csrf
        <input class="form-control mb-3" type="text" name="name" placeholder="Your Name">
        <input class="form-control mb-3" type="email" name="email" placeholder="Your Email">
        <textarea class="form-control mb-3" name="message" placeholder="Message"></textarea>
        <button class="btn btn-primary-custom">Send Message</button>
    </form>
</div>
@endsection
