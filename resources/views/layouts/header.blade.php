<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('dashboard') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="Logo" width="80" class="me-2 rounded-3">
        </a>

        <!-- Mobile Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3" href="{{ route('dashboard') }}">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3" href="{{ route('about') }}">About US</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link fw-semibold px-3" href="{{ route('profile.index') }}">View Profiles</a>
                </li>

                @if(auth()->user()->profile && strtolower(auth()->user()->plan) !== "free" && strtolower(auth()->user()->plan) !== "none")
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="{{ route('matches.show') }}">Matches</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="{{ route('request.view') }}">Followers</a>
                    </li>
                @endif

                @if(auth()->user()->profile)
                    <li class="nav-item">
                        <a class="nav-link fw-semibold px-3" href="{{ route('request.index') }}">Requests</a>
                    </li>
                @endif



                @if(strtolower(auth()->user()->plan) === 'premium' || strtolower(auth()->user()->plan) === 'free' || strtolower(auth()->user()->plan) === 'none')
                    <a href="{{ route('plans') }}" class="btn-premium">
                        <i class="fas fa-gem"></i> Upgrade
                    </a>
                @endif

                @auth

                    <li class="nav-item dropdown me-2">
                        <a class="nav-link position-relative px-3" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bell-fill" style="font-size: 20px;"></i>

                            @if(auth()->user()->unreadNotifications->count())
                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                                    {{ auth()->user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width:320px;">
                            <li class="dropdown-header fw-bold">Notifications</li>

                            @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                                <li>
                                    <a href="{{ $notification->data['url'] ?? route('request.index') }}"
                                        onclick="event.preventDefault(); document.getElementById('notif-{{ $notification->id }}').submit();"
                                        class="dropdown-item small {{ is_null($notification->read_at) ? 'fw-bold' : '' }}">
                                        <span class="d-block" style="width:220px; white-space:normal;">
                                            {{ $notification->data['message'] }}
                                        </span>

                                    </a>

                                    <form id="notif-{{ $notification->id }}" method="POST"
                                        action="{{ route('notifications.read', $notification->id) }}">
                                        @csrf
                                    </form>
                                </li>
                            @empty
                                <li class="dropdown-item text-muted text-center">No new notifications</li>
                            @endforelse


                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-center text-primary" href="{{ route('notifications') }}">
                                    View All
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 👤 USER DROPDOWN -->
                    <!-- 👤 USER DROPDOWN -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-semibold px-3" href="#"
                            id="userDropdown" role="button" data-bs-toggle="dropdown">

                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=7a1f28&color=fff"
                                class="rounded-circle me-2" width="34" height="34">

                            <span>{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                            {{-- ✅ PROFILE CHECK --}}
                            @if(auth()->user()->profile)
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.myprofile') }}">
                                        My Profile
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.create') }}">
                                        Create Profile
                                    </a>
                                </li>
                            @endif

                            <li>
                                <a class="dropdown-item py-2" href="{{ route('settings') }}">Settings</a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2">Logout</button>
                                </form>
                            </li>

                        </ul>
                    </li>


                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-3 px-4 py-2" style="border-color:#7a1f28; color:#7a1f28;"
                            href="{{ route('login') }}">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn ms-3 px-4 py-2 text-white" style="background-color:#7a1f28;"
                            href="{{ route('register') }}">Register</a>
                    </li>
                @endauth

            </ul>
        </div>

    </div>
</nav>