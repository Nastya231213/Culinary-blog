<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid py-3 px-5">
        <a class="navbar-brand" href="#"><i class="bi bi-compass"></i> Culinary Expeditions</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end " id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-house-door-fill "></i>
                    <a class="nav-link {{ request()->is('login')? 'active':''}}" aria-current="page" href="{{ route('home')}}">HOME</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-info-circle"></i>
                    <a class="nav-link" href="#">ABOUT</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">

                    <i class="bi bi-cup"></i>
                    <a class="nav-link" href="#">BLOG</a>
                </li>
                @if(Auth::check())
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-box-arrow-right mb-2"></i>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link p-0" style="border: none; background: none;">LOGOUT</button>
                    </form>
                </li>

                @else
                <li class="nav-item d-flex flex-column align-items-center">

                    <i class="bi bi-box-arrow-in-left"></i>
                    <a class="nav-link {{ request()->is('login')? 'active':''}}" href="{{route('login.form')}}">LOGIN</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">

                    <i class="bi bi-person-badge"></i>
                    <a class="nav-link {{ request()->is('register')? 'active':''}}" href="{{route('register.form')}}">REGISTRATION</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg secondary-navbar bg-light">
    <div class="container-fluid d-flex justify-content-center">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <i id="toggle-icon" class="bi bi-chevron-right"></i> Show recipes
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">All recipes</a>
                </li>
                @foreach($mealTypes as $mealType)
                <li class="nav-item">
                    <a class="nav-link" href="#">{{$mealType}}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleIcon = document.getElementById('toggle-icon');

        document.querySelector('#navbarNavDropdown').addEventListener('shown.bs.collapse', function() {
            toggleIcon.classList.remove('bi-chevron-right');
            toggleIcon.classList.add('bi-chevron-down');
        });

        document.querySelector('#navbarNavDropdown').addEventListener('hidden.bs.collapse', function() {
            toggleIcon.classList.remove('bi-chevron-down');
            toggleIcon.classList.add('bi-chevron-right');
        });
    });
</script>