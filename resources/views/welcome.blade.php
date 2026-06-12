<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>VivahBandhan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('images/logo3.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f8f5f0;
        }

        .navbar .nav-link {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            text-decoration: underline;
        }

        .nav-link:active {
            text-decoration: underline;
        }

        .navbar-brand {
            letter-spacing: 2px;
        }

        .headerbg {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .register-btn {
            padding: 8px 36px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            background-color: #fff;
            color: #000;
        }

        .register-btn:hover {
            background-color: transparent;
            color: #fff;
            border: 1px solid #fff;
        }


        /* HERO */
        .hero {
            min-height: 800px;
            background: linear-gradient(rgba(0, 0, 0, 0.60),
                    rgba(0, 0, 0, 0.60)),
                url("/images/heropage/hero.jpeg") center/cover no-repeat;
            color: #fff;
            position: relative;
        }

        .hero-content {
            max-width: 500px;
        }

        .hero-content p {
            max-width: 900px !important;
        }

        .hero-title {
            font-size: 3.2rem;
            font-weight: 700;
            letter-spacing: 1px;
            line-height: 1.2;
        }

        .hero-title span {
            font-weight: 400;
            margin: 0 10px;
        }

        .hero-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
        }

        .hero .btn {
            padding: 8px 36px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .hero .btn:hover {
            background-color: #fff;
            color: #000;
        }

        /* ===========================
        RESPONSIVE
        =========================== */

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }


        /* COUNTDOWN */
        .countdown {
            background: #3b2617;
            color: #fff;
        }

        .stats {
            background: #fff;
        }

        .stats p {
            color: #c9a24d;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            color: #c9a24d;
        }


        .time-box {
            background: #000;
            padding: 15px 20px;
            border-radius: 10px;
            min-width: 90px;
        }

        .time-box span {
            font-size: 30px;
            font-weight: bold;
            display: block;
        }

        .wedding-stats {
            background: linear-gradient(135deg, #1a1a1a, #000000ff);
            color: #fff;
        }

        .stat-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 30px 15px;
            transition: all 0.4s ease;
        }

        .stat-box:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            font-size: 30px;
            display: block;
            margin-bottom: 10px;
        }

        .stat-number {
            font-size: 40px;
            font-weight: 700;
            color: #ffb3c1;
        }

        .stat-box p {
            margin-top: 5px;
            letter-spacing: 1px;
            font-size: 14px;
            text-transform: uppercase;
        }


        /* Story */
        .love-story-section {
            background: linear-gradient(135deg, #fff1f5, #fffaf0);
            padding: 6% 0% !important;
        }

        .story-card {
            max-width: 1100px;
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 30px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .story-image img {
            width: 450px;
            height: 500px;
            object-fit: cover;
            border-radius: 30px 0 0 30px;
        }

        .story-content {
            padding: 50px;
        }

        .story-subtitle {
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #e63946;
            font-weight: 600;
            font-size: 13px;
        }

        .story-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .heart-divider {
            margin: 20px 0 30px;
            text-align: center;
            position: relative;
        }

        .heart-divider span {
            background: #fff;
            padding: 0 15px;
            color: #e63946;
            font-size: 20px;
        }

        .heart-divider::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            height: 1px;
            background: #f1c0c6;
            z-index: -1;
        }

        .story-step {
            display: flex;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .story-step .dot {
            width: 10px;
            height: 10px;
            background: #e63946;
            border-radius: 50%;
            margin-top: 8px;
            margin-right: 15px;
        }

        .story-step p {
            color: #555;
            margin: 0;
            line-height: 1.6;
        }

        .story-highlight {
            margin-top: 25px;
            font-weight: 600;
            color: #e63946;
            font-size: 18px;
        }



        /* GALLERY */
        .wedding-gallery {
            background: #fffaf5;
        }

        .gallery-tag {
            color: #e63946;
            letter-spacing: 2px;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .gallery-title {
            font-size: 36px;
            font-weight: 700;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .gallery-item img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.6), transparent);
            opacity: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.4s ease;
        }

        .gallery-overlay span {
            font-size: 40px;
            color: #ffb3c1;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }




        /* STATS */
        .stats {
            background: #fff;
        }

        .stats h3 {
            font-weight: 700;
        }

        /* TESTIMONIAL */
        .wedding-testimonial {
            background: linear-gradient(135deg, #fff0f3, #fffaf5);
        }

        .section-tag {
            color: #e63946;
            letter-spacing: 2px;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
        }

        .section-title {
            font-size: 36px;
            font-weight: 700;
            margin-top: 8px;
        }

        .testimonial-box {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            border-radius: 25px;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
        }

        .testimonial-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 35px 70px rgba(0, 0, 0, 0.12);
        }

        .testimonial-box.active {
            border: 2px solid #e63946;
        }

        .quote-icon {
            font-size: 80px;
            color: #e63946;
            line-height: 1;
            opacity: 0.2;
            position: absolute;
            top: 10px;
            left: 20px;
        }

        .testimonial-text {
            font-size: 17px;
            color: #555;
            line-height: 1.7;
            margin-top: 30px;
        }

        .testimonial-name {
            margin-top: 25px;
            font-weight: 600;
            color: #e63946;
            font-size: 16px;
        }



        /* FOOTER */

        footer h5 {
            font-weight: 600;
        }

        .footer {
            background: #111 !important;
        }

        .footer-link {
            color: #bbb;
            text-decoration: none;
        }

        .footer-link:hover {
            color: #fff;
        }


        .navbar .btn {
            padding: 6px 14px;
            font-size: 14px;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <!-- HEADER -->
    <header class="position-absolute headerbg w-100" style="z-index:10;">
        <nav class="navbar navbar-expand-lg navbar-dark bg-transparent py-3">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo1.png') }}" alt="Logo" width="80" class="me-2 rounded-3">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="mainNav">
                    <ul class="navbar-nav align-items-lg-center gap-3">

                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('/') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#story">Our Story</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#gallery">Gallery</a>
                        </li>
                        {{-- AUTH BUTTONS --}}
                        @guest
                            <li class="nav-item ms-lg-3">
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">
                                    Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn register-btn btn-sm">
                                    Register
                                </a>
                            </li>
                        @endguest

                        @auth
                            <li class="nav-item dropdown ms-lg-3">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button class="dropdown-item text-danger">
                                                Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endauth

                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <!-- HERO -->
    <section class="hero d-flex align-items-center justify-content-center text-center">
        <div class="hero-content container">
            <h1 class="hero-title">
                Vikram Singh <span>&</span> Neha Kapoor
            </h1>

            <p class="hero-subtitle mt-3">
                Forever Starts Here: Your Love, Your Journey, Your Wedding Wonderland!
            </p>

            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mt-4">
                Register
            </a>
        </div>
    </section>

    <!-- LOVE STORY -->
    <section id="story" class="love-story-section py-5">
        <div class="container">
            <div class="story-card mx-auto">
                <div class="row g-0 align-items-center">

                    <!-- Image -->
                    <div class="col-lg-5 story-image">
                        <img src="{{ asset('images/heropage/hero1.jpeg') }}" alt="Our Story">
                    </div>

                    <!-- Content -->
                    <div class="col-lg-7 story-content">
                        <h6 class="story-subtitle">Our Journey</h6>
                        <h2 class="story-title">A Beautiful Love Story</h2>

                        <div class="heart-divider">
                            <span>♥</span>
                        </div>

                        <div class="story-step">
                            <span class="dot"></span>
                            <p>
                                What started as a simple hello soon became a
                                connection filled with warmth, laughter, and care.
                            </p>
                        </div>

                        <div class="story-step">
                            <span class="dot"></span>
                            <p>
                                Late-night talks turned into shared dreams,
                                and every moment made our bond stronger.
                            </p>
                        </div>

                        <div class="story-step">
                            <span class="dot"></span>
                            <p>
                                Today, we walk hand in hand, ready to begin
                                our forever with love, family, and blessings.
                            </p>
                        </div>

                        <p class="story-highlight">
                            Join us as we celebrate our happily ever after 💍
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <!-- COUNTDOWN -->
    <!-- STATS -->
    <section class="wedding-stats py-5">
        <div class="container">
            <div class="row g-4 text-center">

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <span class="stat-icon">👥</span>
                        <h2 class="stat-number" data-count="232">0</h2>
                        <p>Guests</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <span class="stat-icon">📸</span>
                        <h2 class="stat-number" data-count="825">0</h2>
                        <p>Photos</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <span class="stat-icon">🌸</span>
                        <h2 class="stat-number" data-count="130">0</h2>
                        <p>Flowers</p>
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <div class="stat-box">
                        <span class="stat-icon">❤️</span>
                        <h2 class="stat-number" data-count="655">0</h2>
                        <p>Days Together</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- GALLERY -->
    <section id="gallery" class="wedding-gallery py-5">
        <div class="container">

            <div class="text-center mb-5">
                <h6 class="gallery-tag">Captured Moments</h6>
                <h2 class="gallery-title">Our Beautiful Memories</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4 col-sm-6">
                    <div class="gallery-item">
                        <img src="{{ asset('images/heropage/gallary1.jpeg') }}">
                    </div>
                </div>

                @for($i = 2; $i < 6; $i++)
                    <div class="col-md-4 col-sm-6">
                        <div class="gallery-item">
                            <img src="{{ asset('images/heropage/gallary' . $i . '.jpg') }}">
                        </div>
                    </div>
                @endfor
                <div class="col-md-4 col-sm-6">
                    <div class="gallery-item">
                        <img src="{{ asset('images/heropage/gallary6.jpeg') }}">
                        <div class="gallery-overlay">
                            <span>♥</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- TESTIMONIAL -->
    <section class="wedding-testimonial py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h6 class="section-tag">Blessings & Love</h6>
                <h2 class="section-title">Stories Filled With Joy</h2>
            </div>

            <div class="row g-4 justify-content-center">

                <div class="col-md-4">
                    <div class="testimonial-box">
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            A magical wedding experience that touched our hearts.
                            Every moment felt truly special.
                        </p>
                        <h6 class="testimonial-name">Aditi & Rahul</h6>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-box active">
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            From décor to emotions, everything was absolutely
                            perfect and beautifully arranged.
                        </p>
                        <h6 class="testimonial-name">Neha Sharma</h6>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="testimonial-box">
                        <div class="quote-icon">“</div>
                        <p class="testimonial-text">
                            A celebration full of love, laughter, and memories
                            we will cherish forever.
                        </p>
                        <h6 class="testimonial-name">Vikram Patel</h6>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <footer class="footer pt-5 pb-3 text-white">
        <div class="container">
            <div class="row text-center text-md-start">

                <div class="col-md-4 mb-4">
                    <h5>VivahBandhan</h5>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" width="100" class="mb-2 rounded-3">
                    <p class="small w-75">
                        A celebration of love, togetherness,
                        and a lifetime of memories.
                    </p>
                </div>

                <div class="col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="footer-link">Home</a></li>
                        <li><a href="#story" class="footer-link">Our Story</a></li>
                        <li><a href="#gallery" class="footer-link">Gallery</a></li>
                    </ul>
                </div>

                <div class="col-md-4 mb-4">
                    <h5>Wedding Date</h5>
                    <p class="small mb-1">20 December 2026</p>
                    <p class="small">With love ❤️</p>
                </div>

            </div>

            <hr class="border-light">

            <p class="text-center small mb-0">
                © {{ date('Y') }} Vivahbandhan. All Rights Reserved.
            </p>
        </div>
    </footer>



    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const weddingDate = new Date("2026-12-20").getTime();
        setInterval(() => {
            const now = new Date().getTime();
            const diff = weddingDate - now;

            document.getElementById("days").innerText = Math.floor(diff / (1000 * 60 * 60 * 24));
            document.getElementById("hours").innerText = Math.floor((diff / (1000 * 60 * 60)) % 24);
            document.getElementById("minutes").innerText = Math.floor((diff / (1000 * 60)) % 60);
            document.getElementById("seconds").innerText = Math.floor((diff / 1000) % 60);
        }, 1000);
    </script>

    <script>
        const counters = document.querySelectorAll('.stat-number');
        const speed = 200; // The lower the number, the faster the count

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;

                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });
    </script>

</body>

</html>