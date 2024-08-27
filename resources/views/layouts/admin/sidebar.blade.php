<button class="toggle-btn" id="toggleSidebarBtn">
    <i class="bi bi-list"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('admin.dashboard')}}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.users.index')}}">
                    <i class="bi bi-person"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.posts.index')}}">
                    <i class="bi bi-journal-text"></i> Posts
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.categories.index')}}">
                    <i class="bi bi-tags-fill"></i>
                    Categories
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link" href="/">
                    <i class="bi bi-house-door"></i> Back to Main Site
                </a>
            </li>


        </ul>
    </div>
</div>