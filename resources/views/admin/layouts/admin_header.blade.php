<header class="header px-4 py-3 d-flex justify-content-between align-items-center">
    <h5 class="mb-0 fw-semibold">
        @yield('page-title', 'Dashboard')
    </h5>

    <span class="text-muted">
        <i class="bi bi-person-circle text-maroon"></i>
        {{ Auth::user()->name ?? 'Admin' }}
    </span>
</header>
