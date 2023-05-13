@extends('layouts.www')

@section('content')

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
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Certificados</p>
                        </div>
                        {{-- <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Skilled Instructors</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Online Classes</p>
                        </div>
                        <div class="col-sm-6">
                            <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>International Certificate</p>
                        </div> --}}
                    </div>
                    <a class="btn btn-primary py-3 px-5 mt-2" href="">Ver Cursos</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 category">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="section-title bg-white text-start text-primary pe-3">Misión</h3>
                    <p>Desarrollar diversas actividades abiertas a la comunidad de forma a instruir y capacitar aquellos que busquen la auto superación
                        , de forma a generar oportunidades a las personas que deseen crecer a través de sus propias facultades y capacidad.
                    </p>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                    <h3 class="section-title bg-white text-start text-primary pe-3">Visión</h3>
                    <p>
                        Llevar adelante una iniciativa que priorice a los sectores más vulnerables de la sociedad de forma que puedan participar en el mercado laboral con igualdad de oportunidades.
                    </p>
                </div>
            </div>

        </div>

    </div>

@endsection
