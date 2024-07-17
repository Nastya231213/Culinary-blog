@extends('layouts.main')

@section('title', 'Registration')
@section('content')
<div class="container">
    <div class="row w-75 mx-auto" id="authenticationForm">
        <div class="col-sm-6 text-black">

            <div class="d-flex align-items-center h-custom-2 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                <form method="POST" action="{{ route('register.store')}}" style="width: 23rem;">
                    @csrf
                    <h2 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">Register</h2>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="text" name="fullName" id="form2ExampleName" class="form-control form-control-lg small-font" required />
                        <label class="form-label" for="form2ExampleName">Full Name</label>
                        @if($errors->has('fullName'))
                        <div class="alert alert-danger error-message" role="alert">
                            {{$errors->first('fullName')}}
                        </div>
                        @endif
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" name="email" id="form2ExampleEmail" class="form-control form-control-lg small-font" required />
                        <label class="form-label" for="form2ExampleEmail">Email address</label>
                        @if($errors->has('email'))
                        <div class="alert alert-danger error-message" role="alert">
                            {{$errors->first('email')}}
                        </div>
                        @endif
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" name="password" id="form2ExamplePassword" class="form-control form-control-lg small-font" required />
                        <label class="form-label" for="form2ExamplePassword">Password</label>
                        @if($errors->has('password'))
                        <div class="alert alert-danger error-message" role="alert">
                            {{$errors->first('password')}}
                        </div>
                        @endif
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" name="password_confirmation" id="form2ExampleConfirmPassword" class="form-control form-control-lg" required />
                        <label class="form-label" for="form2ExampleConfirmPassword">Confirm Password</label>
                    </div>

                    <div class="pt-1 mb-4 d-flex justify-content-center">
                        <input data-mdb-button-init data-mdb-ripple-init class="btn btn-lg w-50" type="submit" value="Register">
                    </div>

                    <p class="small mb-5 pb-lg-2"><a class="text-muted" href="{{route('login.form')}}">Already have an account? Log in</a></p>
                </form>
            </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
            <img src="{{ asset('images/register-image.gif') }}" alt="Register image" class="w-100 h-100" style="object-fit: cover; object-position: left;">
        </div>
    </div>
</div>

@endsection