<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - Il Tuo Progetto</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- AOS CSS for Animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Animate.css for Additional Animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Custom Styles -->
    <style>
        /* Impostazioni di base */
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            scroll-behavior: smooth;
            overflow-x: hidden;
        }

        /* Navigazione */
        .navigation {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }

        .navigation a {
            color: white;
            margin-left: 15px;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navigation a:hover {
            color: #FFD700;
        }

        /* Carosello */
        .carousel-wrapper {
            position: relative;
            height: 100vh;
            overflow: hidden;
        }

        .owl-carousel .item-t img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .owl-carousel .item img {
            width: 30%;
            height: 30%;
            margin: 0 auto;
            object-fit: cover;
        }

        /* Testo Centrato */
        .centered-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: center;
            z-index: 1;
        }

        .centered-text h1 {
            font-size: 3rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .centered-text p {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        .centered-text a {
            background-color: #0c0606;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .centered-text a:hover {
            background-color: #000000;
        }

        /* Sezioni */
        section {
            padding: 80px 0;
        }

        .section-about,
        .section-features,
        .section-testimonials,
        .section-gallery,
        .section-cta,
        .section-contact {
            animation: fadeIn 2s ease-out;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: #fff;
            padding: 20px 0;
        }

        footer a {
            color: #fff;
            margin: 0 10px;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #FFD700;
        }

        /* Animazioni Personalizzate */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate(-50%, -60%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Text */
        @media (max-width: 768px) {
            .centered-text h1 {
                font-size: 2rem;
            }

            .centered-text p {
                font-size: 1rem;
            }
        }

        /* Testimonianze */
        .testimonial {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .testimonial img {
            border-radius: 50%;
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-bottom: 15px;
        }

        /* Galleria */
        .gallery img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        /* Contatto */
        .contact-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .contact-form input,
        .contact-form textarea {
            border-radius: 5px;
        }

        .contact-form button {
            background-color: #0c0606;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .contact-form button:hover {
            background-color: #000000;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <!-- Navigazione -->
    @if (Route::has('login'))
        <nav class="navigation">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">Accedi</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Registrati</a>
                @endif
            @endauth
        </nav>
    @endif

    <!-- Contenitore del Carosello -->
    <div class="carousel-wrapper">
        <div class="owl-carousel owl-theme">
            <div class="item-t">
                <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/2/assets/alextheorylab037-1-1664902095524.webp?v=1664902096" alt="Slide 1">
            </div>
            <div class="item-t">
                <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/2/assets/alextheorylab018-1664921938386.webp?v=1664921940" alt="Slide 2">
            </div>
            <div class="item-t">
                <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/2/assets/alextheorylabtconricoperteconfronto4015--edited-1665008614905.jpg?v=1665008617" alt="Slide 3">
            </div>
        </div>

        <!-- Testo Centrato con Animazione -->
        <div class="centered-text">
            <h1 class="animate__animated animate__fadeInUp">Benvenuto nel Nostro Progetto</h1>
            <p class="animate__animated animate__fadeInUp animate__delay-1s">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            <a href="#about" class="animate__animated animate__fadeInUp animate__delay-2s">Scopri di più</a>
        </div>
    </div>

    <!-- Sezione About -->
    <section id="about" class="section section-about bg-light">
        <div class="container" data-aos="fade-up">
            <div class="row align-items-center">
                <div class="col-md-6" data-aos="fade-right">
                    <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/2/assets/alextheorygallette096-1665008139658.webp?v=1665008171" alt="Chi Siamo" class="img-fluid rounded shadow">
                </div>
                <div class="col-md-6 mt-5 mt-md-0">
                    <h2 class="mb-4">Chi Siamo</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla vel purus at quam dignissim placerat.</p>
                    <p>Aliquam erat volutpat. Integer nec tortor eu lectus consectetur commodo. Morbi euismod, justo a tincidunt dictum, sapien erat elementum urna, at posuere ligula ligula nec metus.</p>
                    <a href="#" class="text-danger fw-bold">Leggi di più</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Sezione Caratteristiche -->
    <section class="section section-features">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center mb-5">Le Nostre Caratteristiche</h2>
            <div class="row">
                <div class="col-md-4 mb-4 text-center" data-aos="zoom-in">
                    <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/24/assets/mega-menu-120077-mais-paprika0b60f145-9bc3-4e72-9b68-4b6f89c3feea-1-99957533_320x.jpg?v=1694178854" alt="Feature 1" class="mb-3">
                    <h4>Feature 1</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
                <div class="col-md-4 mb-4 text-center" data-aos="zoom-in" data-aos-delay="100">
                    <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/24/assets/mega-menu-120077-gallettasemplice-5150-1371361326_320x.jpg?v=1698055803" alt="Feature 2" class="mb-3">
                    <h4>Feature 2</h4>
                    <p>Nulla vel purus at quam dignissim placerat.</p>
                </div>
                <div class="col-md-4 mb-4 text-center" data-aos="zoom-in" data-aos-delay="200">
                    <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/t/24/assets/mega-menu-120077-lattenocciole-pila-1-1363037794_320x.jpg?v=1694178856" alt="Feature 3" class="mb-3">
                    <h4>Feature 3</h4>
                    <p>Sed vitae nisi a enim tincidunt fermentum.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sezione Testimonianze -->
    <section class="section section-testimonials bg-light">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center mb-5">Testimonianze</h2>
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <div class="testimonial text-center">
                        <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/files/mega-menu-120077-deg-salata-deluxe-1193854528_320x.jpg?v=1714986903" alt="Testimonial 1">
                        <h5 class="mt-3">Mario Rossi</h5>
                        <p class="mt-2">"Questo progetto ha superato le mie aspettative! Ottimo lavoro."</p>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial text-center">
                        <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/files/mega-menu-120077-ciccio-premium-136015497_320x.jpg?v=1714986905" alt="Testimonial 2">
                        <h5 class="mt-3">Luisa Bianchi</h5>
                        <p class="mt-2">"Un'esperienza fantastica, altamente raccomandata."</p>
                    </div>
                </div>
                <div class="item">
                    <div class="testimonial text-center">
                        <img src="https://cdn.shopify.com/s/files/1/0619/9984/1467/files/mega-menu-120077-deg-dolce-deluxe-1147756102_320x.jpg?v=1714998662" alt="Testimonial 3">
                        <h5 class="mt-3">Giovanni Verdi</h5>
                        <p class="mt-2">"Supporto eccellente e risultati straordinari."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sezione Galleria -->
    <section class="section section-gallery">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center mb-5">Galleria</h2>
            <div class="row gallery">
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/Burro-Puro.webp?v=1703066624" alt="Galleria 1">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/90-Pizza.webp?v=1703081545" alt="Galleria 2">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/Burro-Puro.webp?v=1703066624" alt="Galleria 3">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/90-Pizza.webp?v=1703081545" alt="Galleria 4">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/Burro-Puro.webp?v=1703066624" alt="Galleria 5">
                </div>
                <div class="col-md-4 mb-4">
                    <img src="https://alextheory.it/cdn/shop/files/90-Pizza.webp?v=1703081545" alt="Galleria 6">
                </div>
            </div>
        </div>
    </section>

    <!-- Sezione Call to Action -->
    <section class="section section-cta text-white text-center" style="background-color: #333;">
        <div class="container" data-aos="fade-up">
            <h2 class="mb-4">Inizia Ora</h2>
            <p class="mb-4">Unisciti a noi e scopri tutte le potenzialità del nostro progetto.</p>
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">Registrati</a>
        </div>
    </section>

    <!-- Sezione Contatti -->
    <section id="contact" class="section section-contact bg-light">
        <div class="container" data-aos="fade-up">
            <h2 class="text-center mb-5">Contattaci</h2>
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form class="contact-form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name" placeholder="Il tuo nome">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="La tua email">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Messaggio</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Il tuo messaggio"></textarea>
                        </div>
                        <div class="text-center">
                            <button type="submit">Invia Messaggio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>&copy; 2024 Il Mio Progetto. Tutti i diritti riservati.</p>
            <div class="mt-3">
                <a href="#">Privacy Policy</a>
                <a href="#">Termini di Servizio</a>
                <a href="#">Contatti</a>
            </div>
        </div>
    </footer>

    <!-- Includi gli Script -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Animate.css JS (opzionale se vuoi controllare le animazioni via JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.js"></script>

    <!-- Inizializza Owl Carousel e AOS -->
    <script>
        $(document).ready(function () {
            // Inizializza Owl Carousel per il carosello principale
            $('.owl-carousel').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: false,
                items: 1,
                nav: false,
                dots: false,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                smartSpeed: 450
            });

            // Inizializza Owl Carousel per le testimonianze
            $('.section-testimonials .owl-carousel').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 7000,
                autoplayHoverPause: true,
                items: 1,
                nav: false,
                dots: true,
                smartSpeed: 450
            });

            // Inizializza AOS
            AOS.init({
                duration: 1200,
                once: true,
            });

            // Gestisci il menu mobile (se aggiungi un menu mobile)
            $('#mobile-menu-button').click(function () {
                $('#mobile-menu').toggleClass('d-none');
            });
        });
    </script>
</body>

</html>
