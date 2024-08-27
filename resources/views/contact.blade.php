@extends('layouts.main_with_sidebar')
@section('title','Contact')
@section('content')
<div class="mt-3">
    <h3>Contact Us</h3>
    <p>If you have any questions, feel free to reach out to us using the form below, or contact us directly through the provided contact details.</p>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h5>Our Contact Details</h5>
            <ul class="list-unstyled">
                <li><strong>Email:</strong> <a href="mailto:info@example.com">info@example.com</a></li>
                <li><strong>Phone:</strong> <a href="tel:+123456789">+1 (234) 567-89</a></li>
                <li><strong>Address:</strong> 1234 Culinary Street, Food City, FC 12345</li>
            </ul>
        </div>
    </div>
</div>
@endsection