<div class="container mt-3">
@if(Session::has('successMessage'))

    <div class="alert alert-success w-75 d-flex align-items-center mx-auto" role="alert">
        <i class="bi bi-check-circle-fill flex-shrink-0 me-2" style="font-size: 1.5rem;"></i>
        <div>
            {{Session::get('successMessage')}}

        </div>
    </div>
    @endif

    @if(Session::has('errorMessage'))
    <div class="alert alert-danger w-75 d-flex align-items-center mx-auto" role="alert">
        <i class="bi bi-exclamation-circle-fill flex-shrink-0 me-2" style="font-size: 1.5rem;"></i>
        <div>
            {{ Session::get('errorMessage') }}
        </div>
    </div>
    @endif
</div>