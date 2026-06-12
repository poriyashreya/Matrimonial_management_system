<footer class="footer-section mt-3 pt-5">
    <div class="container">
        <div class="row">

            <!-- About -->
            <div class="col-md-4 mb-4" style="margin-right: 8%;">
                <h5 class="fw-bold pb-4">About Matrimony</h5>
                <p style="text-align:justify;">We are a trusted matrimonial platform dedicated to helping individuals
                    find meaningful and lifelong
                    relationships. Our goal is to blend tradition with technology to create genuine connections based on
                    compatibility, values, and trust.</p>
                <div class="d-flex gap-3 fs-4">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-globe"></i></a>
                </div>
            </div>

            <!-- Social icons -->
            <div class="col-md-4 mb-4 me-0 pe-0 w-25">
                <h5 class="fw-bold pb-4">Quick Links</h5>
                <div class="d-flex gap-3 fs-4">
                    <ul class="list-unstyled text-center">
                        <li>
                            <a href="{{ route('dashboard') }}" class="footer-link">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="footer-link">
                                About US
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('profile.index') }}" class="footer-link">
                                View Profiles
                            </a>
                        </li>
                        <li>
                            <a href="{{ strtolower(auth()->user()->plan) !== 'free' ? route('matches.show') : '#' }}"
                                class="footer-link">
                                Matches
                            </a>
                        </li>
                        <li><a href="{{ route('request.view') }}" class="footer-link">Requests</a></li>
                        @if(strtolower(auth()->user()->plan) !== 'free')
                            <li>
                                <a href="{{ route('request.index') }}" class="footer-link">
                                    Followers
                                </a>
                            </li>
                        @endif
                    </ul>

                </div>
            </div>

            <!-- Newsletter -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold pb-4">Join Our Newsletter</h5>
                <p>Subscribe to get latest matches and updates.</p>

                <form class="newsletter-form d-flex">
                    <input type="email" class="form-control me-2" placeholder="Enter your email">
                    <button class="btn btn-light rounded-pill px-4"
                        style="background:#fdf7e7 !important;">Subscribe</button>
                </form>
            </div>

        </div>


    </div>
    <div class="footer-bottom text-center py-3 mt-3">
        <small>&copy; {{ date('Y') }} Matrimony System — All Rights Reserved.</small>
    </div>
</footer>