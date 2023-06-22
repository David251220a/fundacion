<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Fundación Katupyry</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    {{-- <link href="{{asset('www/img/favicon.ico')}}" rel="icon"> --}}
    <link href="{{Storage::url('iconos/favicon16x16.png')}}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('www/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('www/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('www/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('www/css/style.css')}}" rel="stylesheet">

    @yield('styles')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Cargando...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            {{-- <h2 class="m-0 text-primary"><img src="{{Storage::url('iconos/logo_horizontal-1.svg')}}" alt=""> Fundación Katupyry</h2> --}}
            <img style="width:100%" src="{{Storage::url('iconos/logo_horizontal-1.svg')}}" alt="">
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="{{route('inicio')}}" class="nav-item nav-link active">Inicio</a>
                <a href="{{route('nosotros')}}" class="nav-item nav-link">Quienes Somos</a>
                <a href="{{route('cursos')}}" class="nav-item nav-link">Cursos</a>
                <a href="{{route('new')}}" class="nav-item nav-link">Noticias</a>
                <a href="{{route('contacto')}}" class="nav-item nav-link">Contactanos</a>
                <a href="{{route('login')}}" class="btn btn-primary py-4 px-lg-5 ">Ingresar<i class="fa fa-arrow-right ms-3"></i></a>
            </div>
            {{-- <a href="{{route('login')}}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Ingresar<i class="fa fa-arrow-right ms-3"></i></a> --}}
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('content')

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Enlace rápido</h4>
                    <a class="btn btn-link" href="">Sobre Nosotros</a>
                    <a class="btn btn-link" href="">Cursos</a>
                    <a class="btn btn-link" href="">Contactanos</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contacto</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Ruta Nº 3, Elizado Aquino</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+595 983 602 155</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@fundacionkatupyry.com.py</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" target="__blank" href="https://www.facebook.com/FundacionKatupyry"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" target="__blank" href="https://www.instagram.com/fundacionkatupyry/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('www/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('www/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('www/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('www/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    @yield('js')
    <!-- Template Javascript -->
    <script src="{{asset('www/js/main.js')}}"></script>
</body>

</html>
