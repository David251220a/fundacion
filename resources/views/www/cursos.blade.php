@extends('layouts.www')

@section('content')

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

    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Ultimas Cursos</h6>
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

@endsection
