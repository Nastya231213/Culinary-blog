<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid py-3 px-5">
    <a class="navbar-brand" href="#"><i class="bi bi-gear-fill"></i> Admin Panel</a>
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