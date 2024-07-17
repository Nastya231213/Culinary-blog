@extends('layouts.main')

@section('title','Login')
@section('content')
<div class="container">
    <div class="row w-75  mx-auto " id="authenticationForm">
        <div class="col-sm-6 text-black">

            <div class="d-flex align-items-center h-custom-2  ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

                <form style="width: 23rem;">

                    <h2 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px;">Log in</h2>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="form2Example18" class="form-control form-control-lg" />
                        <label class="form-label" for="form2Example18">Email address</label>
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="form2Example28" class="form-control form-control-lg" />
                        <label class="form-label" for="form2Example28">Password</label>
                    </div>

                    <div class="pt-1 mb-4 d-flex justify-content-center">
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-lg w-50" type="button">Login</button>
                    </div>

                    <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                    <p>Don't have an account? <a href="#!" class="link-success">Register here</a></p>

                </form>

            </div>

        </div>
        <div class="col-sm-6 px-0 d-none d-sm-block">
            <img src="{{ asset('images/login-image.jpg') }}" alt="Login image" class="w-100 h-100" style="object-fit: cover; object-position: left;">
        </div>
    </div>
</div>

@endsection