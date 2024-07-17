@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card">
            <div class="card-header">
                Verify Account
            </div>
            <div class="card-body">
                <p>Your account is not veirfied.Please verify your account first
                    <a href="{{route('resend.email')}}">-> resend verification link</a>
                </p>
                
            </div>
        </div>
    </div>
</div>

@endsection