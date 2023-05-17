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
                {{-- <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu fade-down m-0">
                        <a href="#" class="dropdown-item">Our Team</a>
                        <a href="#" class="dropdown-item">Testimonial</a>
                        <a href="#" class="dropdown-item">404 Page</a>
                    </div>
                </div> --}}
                <a href="{{route('contacto')}}" class="nav-item nav-link">Contactanos</a>
            </div>
            <a href="" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Ingresar<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->
    <div class="container">
        <div class="mx-4 py-5">
            <h2 class="text-primary">Bienvenido a la Fundación Katupyry </h2>
        </div>
    </div>

    <div class="container mb-4">
        <div class="row" style="@media (min-width: 720px) {height: 500px}">
            <div class="col-md-9 mb-2">
                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        {{-- <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button> --}}
                    </div>

                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="10000">
                            <img src="{{Storage::url('iconos/porta1.jpg')}}" class="d-block w-100" alt="..." >
                            <div class="carousel-caption d-none d-md-block" >
                                {{-- <h4 class="text-white">First slide label</h4>
                                <p>Some representative placeholder content for the first slide.</p> --}}
                            </div>
                        </div>

                        <div class="carousel-item" data-bs-interval="2000">
                            <img src="{{Storage::url('iconos/porta2.jpg')}}" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                {{-- <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p> --}}
                            </div>
                        </div>

                        {{-- <div class="carousel-item">
                            <img src="{{asset('www/img/carousel-1.jpg')}}" class="d-block w-100" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div> --}}
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="col-sm-3 ">
                <div class="card" style="width: 100%">
                    <div class="card-header text-white fw-bold" style="background: rgb(236, 57, 162)">
                      Links de Interés
                    </div>
                    <ul class="list-group list-group-flush rounded" style="background: rgb(236, 57, 162)">
                        <li class="list-group-item w-bold">
                            <a href="" class="w-bold" style="color: #3b5998"><i class="fab fa-facebook-f ml-2"></i> Facebook</a>
                        </li>
                        <li class="list-group-item">
                            <a class="w-bold" href="https://www.instagram.com/fundacionkatupyry/" style="color: rgb(248, 111, 47)"><i class="fab fa-instagram"></i> Instagram</a>
                        </li>
                        <li class="list-group-item">
                            <a href="#"><i class="fas fa-book-reader"></i> Cursos</a>
                        </li>

                        <li class="list-group-item">
                            <a href="#"><i class="fas fa-book-reader"></i> Noticias</a>
                        </li>
                    </ul>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Start -->
    {{-- <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-graduation-cap text-primary mb-4"></i>
                            <h5 class="mb-3">Certificados que respaldan</h5>
                            <p>Respaldamos todo el conocimiento con certificados</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-globe text-primary mb-4"></i>
                            <h5 class="mb-3">Ocupaciones que son tendencia</h5>
                            <p>Ocupaciones y oficios con alta demanada en la actualidad</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-home text-primary mb-4"></i>
                            <h5 class="mb-3">Adquirí todo el conocimento</h5>
                            <p>Todo el conocimiento para desempeñarte como un profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <div class="service-item text-center pt-3">
                        <div class="p-4">
                            <i class="fa fa-3x fa-book-open text-primary mb-4"></i>
                            <h5 class="mb-3">Libros Disponibles</h5>
                            <p> una biblioteca encantada que despierta tu imaginación y conocimiento</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- Service End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s" style="min-height: 400px;">
                    <div class="position-relative h-100">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{Storage::url('iconos/imagen21.jpg')}}" alt="" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h6 class="section-title bg-white text-start text-primary pe-3">Sobre Nosotros</h6>
                    <h1 class="mb-4">Bienvenido a la Fundación Katupyry</h1>
                    <p class="mb-4">Somos una organización que brindamos cursos de capacitación para niños, jóvenes y adultos.</p>
                    <p class="mb-4">Brindando conocimiento, con el fin de dar una salida laboral rápida dentro de la comunidad de Limpio. Estamos dentro de la Sede Social de Club Nueva Estrella.</p>
                    <div class="row gy-2 gx-4 mb-4">
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Excelentes Instructores</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Clases</p>
                        </div>
                        {{-- <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Certificados</p>
                        </div> --}}
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Ver Cursos</a>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Cursos</h6>
                <h1 class="mb-5">Cursos de Interes</h1>
            </div>
            <div class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        <div class="col-lg-12 col-md-12 wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{Storage::url('iconos/barman_hori.jpg')}}" alt="">
                                {{-- <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3 rounded" style="margin: 1px;">
                                    <h5 class="m-0">Inscribete ya!</h5>
                                    <small class="text-primary">Martes</small>
                                </div> --}}
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.3s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{Storage::url('iconos/decoracion.jpg')}}" alt="">
                                {{-- <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">Graphic Design</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div> --}}
                            </a>
                        </div>
                        <div class="col-lg-6 col-md-12 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid" src="{{Storage::url('iconos/corte.jpg')}}" alt="">
                                {{-- <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">Video Editing</h5>
                                    <small class="text-primary">49 Courses</small>
                                </div> --}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{Storage::url('iconos/confi.jpg')}}" alt="" style="object-fit: cover;">
                        {{-- <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin:  1px;">
                            <h5 class="m-0">Online Marketing</h5>
                            <small class="text-primary">49 Courses</small>
                        </div> --}}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Ultimas Noticias</h6>
                {{-- <h1 class="mb-5">Our Students Say!</h1> --}}
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="p-2 mx-auto mb-3" src="{{Storage::url('iconos/ele.jpg')}}" style="width: 350px; height: 350px;">
                    {{-- <h5 class="mb-0">Disponible</h5>
                    <p>Profession</p> --}}
                    <div class="testimonial-text bg-light text-center p-4 rounded">
                        <p class="mb-0">Disponible el cursos de electricidad, inscribite ya.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="p-2 mx-auto mb-3" src="{{Storage::url('iconos/pes.jpg')}}" style="width: 350px; height: 350px;">
                    {{-- <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p> --}}
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Disponible el cursos de todo pestaña, inscribite ya.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="p-2 mx-auto mb-3" src="{{Storage::url('iconos/refri.jpg')}}" style="width: 350px; height: 350px;">
                    {{-- <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p> --}}
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Disponible el cursos de refrigeración, inscribite ya.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="p-2 mx-auto mb-3" src="{{Storage::url('iconos/mani.jpg')}}" style="width: 350px; height: 350px;">
                    {{-- <h5 class="mb-0">Client Name</h5>
                    <p>Profession</p> --}}
                    <div class="testimonial-text bg-light text-center p-4">
                        <p class="mb-0">Disponible el cursos de manicura y pedicura, inscribite ya.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Enlace rápido</h4>
                    <a class="btn btn-link" href="">Sobre Nosotros</a>
                    <a class="btn btn-link" href="">Cursos</a>
                    <a class="btn btn-link" href="">Contactanos</a>
                    {{-- <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a> --}}
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contacto</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+595 986 602 555</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@fundacionkatupyry.com.py</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" target="__blank" href="https://www.facebook.com/FundacionKatupyry"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" target="__blank" href="https://www.instagram.com/fundacionkatupyry/"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('www/lib/wow/wow.min.js')}}"></script>
    <script src="{{asset('www/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('www/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('www/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('www/js/main.js')}}"></script>
</body>

</html>
