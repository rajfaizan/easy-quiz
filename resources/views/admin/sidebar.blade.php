<div class="sidebar px-3">
    <!-- Title -->
    <div class="text-center mb-4">
        <h4 class="fw-bold" style="color: #4a90e2;">SmartExam</h4>
    </div>

    <!-- Navigation -->
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">📊 Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="{{ route('admin.index') }}">
                👥 Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.create') ? 'active' : '' }}" href="{{ route('admin.create') }}">
                👨‍🏫 Teachers
            </a>
        </li>
    </ul>
</div>
