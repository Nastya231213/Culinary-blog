<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid py-3 px-5">
        <a class="navbar-brand" href="#"><i class="bi bi-compass"></i> Culinary Expeditions</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-house-door-fill"></i>
                    <a class="nav-link {{request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ route('home') }}">HOME</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-info-circle"></i>
                    <a class="nav-link {{request()->is('about')?'active':''}}" href="{{route('about')}}">ABOUT</a>
                </li>

                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-telephone"></i>
                    <a class="nav-link {{request()->is('contact')?'active':''}}" href="{{route('contact')}}">CONTACT</a>
                </li>


                @if(Auth::check())
                @if(auth()->user()->is_admin)
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-speedometer2"></i>
                    <a class="nav-link {{request()->is('home')?'active':''}}" href="{{route('admin.dashboard')}}">ADMIN PANEL</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-photo-wrapper">
                            <img src="{{ auth()->user()->profile_photo ? asset('storage/profile_photos/' . auth()->user()->profile_photo) : asset('images/default_profile.jpg') }}" alt="Profile Photo" class="profile_photo me-2">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout <i class="bi bi-box-arrow-right mb-1"></i></button>
                            </form>
                        </li>
                    </ul>
                </li>

                @else
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-box-arrow-in-left"></i>
                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login.form') }}">LOGIN</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-person-badge"></i>
                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register.form') }}">REGISTRATION</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="nav-container">
    <nav class="navbar navbar-expand-lg secondary-navbar bg-light">
        <div class="container-fluid d-flex justify-content-center">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <i id="toggle-icon" class="bi bi-chevron-right"></i> Show recipes
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                @php
                $categoriesWithSubcategories = $categories->filter(function($category) {
                return $category->subcategories->count() > 0;
                });
                $categoriesWithoutSubcategories = $categories->filter(function($category) {
                return $category->subcategories->isEmpty();
                });
                $categoriesDisplayedInDropdown = $categoriesWithSubcategories->take(5);
                @endphp
                <ul class="navbar-nav">

                    @foreach($categoriesWithoutSubcategories->take(5) as $category)
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('posts.category',$category->id)}}">{{ $category->name }}</a>
                    </li>
                    @endforeach

                    @if($categoriesDisplayedInDropdown->count() > 0)
                    <li class="nav-item dropdown d-none d-lg-block">
                        <a class="nav-link  d-flex text-nowrap" href="#" id="categoriesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-chevron-right me-2" id="toggle-icon-categories"></i> More Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <li >
                                <a class="nav-link" href="{{route('categories.index')}}">All categories</a>
                            </li>
                            @foreach($categoriesDisplayedInDropdown as $category)
                            <li class="dropdown-submenu dropend">
                                <a class="dropdown-item dropdown-toggle " href="{{route('posts.category',$category->id)}}">{{ $category->name }}</a>
                                <ul class="dropdown-menu">
                                    @foreach($category->subcategories as $subcategory)
                                    <li><a class="dropdown-item" href="{{route('posts.category',$subcategory->id)}}">{{ $subcategory->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    <li class="nav-item d-lg-none">
                        <a class="nav-link" href="{{route('categories.index')}}">All categories</a>
                    </li>
                </ul>

                <form action="{{route('posts.index')}}" class="d-flex w-100  mx-auto justify-content-center justify-content-lg-end" role="sh" id="search-form" method="GET">
                    <input class="form-control ms-1" value="{{request()->query('search')}}" type="search" placeholder="Search" id="search" aria-label="Search" name="search">
                    <button class="btn btn-outline-success" type="submit"> <i class="bi bi-search"></i></button>
                </form>

            </div>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropdownToggle = document.querySelector('#categoriesDropdown');
        var toggleIcon = document.querySelector('#toggle-icon-categories');

        if (dropdownToggle && toggleIcon) {
            dropdownToggle.addEventListener('show.bs.dropdown', function() {
                toggleIcon.classList.remove('bi-chevron-right');
                toggleIcon.classList.add('bi-chevron-down');
            });

            dropdownToggle.addEventListener('hide.bs.dropdown', function() {
                toggleIcon.classList.remove('bi-chevron-down');
                toggleIcon.classList.add('bi-chevron-right');
            });
        }
    });
</script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>