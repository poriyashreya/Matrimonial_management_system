<aside class="sidebar p-3 position-fixed h-100">
    <h4 class="fw-bold text-white mb-4">
        <img
            src="{{ asset($logo) }}"
            alt="Logo"
            style="height:40px; width:40px;"
        >
        Vivah Bandhan
    </h4>

    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>

    <a href="{{ route('admin.verifications') }}"
        class="{{ request()->routeIs('admin.verifications*') ? 'active' : '' }}">
        <i class="bi bi-patch-check me-2"></i> Verifications
    </a>

    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i> Users
    </a>

    <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
        <i class="bi bi-clipboard-data me-2"></i> Reports
    </a>

    <hr class="text-secondary">

    <a href="{{ route('admin.settings.display') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <i class="bi bi-gear me-2"></i> Settings
    </a>

    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
        <i class="bi bi-box-arrow-right me-2"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
</aside>