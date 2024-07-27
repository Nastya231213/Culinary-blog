<nav class="navbar navbar-expand-lg  ">
    <div class="container-fluid py-3 px-5">
        <a class="navbar-brand" href="#"><i class="bi bi-gear-fill"></i> Admin Panel</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-speedometer2"></i>
                    <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-person-fill"></i>
                    <a class="nav-link {{ request()->is('admin/users') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Users</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-tags-fill"></i>
                    <a class="nav-link {{ request()->is('admin/categories') ? 'active' : '' }}" href="#">Categories</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-file-earmark-text"></i>
                    <a class="nav-link {{ request()->is('admin/recipes') ? 'active' : '' }}" href="#">Recipes</a>
                </li>
                <li class="nav-item d-flex flex-column align-items-center">
                    <i class="bi bi-box-arrow-right"></i>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link p-0" style="border: none; background: none;">Logout</button>
                    </form>
                </li>

            </ul>
        </div>
    </div>
</nav>