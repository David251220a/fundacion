@extends('layouts.www')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ckeditor-styles.css') }}">
@endsection

@section('content')


    {{-- <img src="{{Storage::url('noticias/2ozVIBXBbsyu27qDfNTzMTxoQ9f18VUzgyxo0Qos.jpg')}}" class="d-block w-100" alt="..."> --}}

    <div class="container">
        <div class="mx-4 py-3 mt-2">
            <h2 class="section-title bg-white text-center text-primary px-3">Noticias</h2>
        </div>
    </div>

    <div class="container">
        <div class="mx-4 py-3">
            <h2 class="bg-white text-center text-black px-3">{{  Str::title($data->titulo) }}</h2>
        </div>
    </div>

    <div class="container d-flex justify-content-center align-items-center mb-4">
        <div class="owl-carousel owl-height" style="max-height: 520px;">
            @foreach ($data->files_fotos as $item)
                <div class="item" style="width: 100%; max-height: 520px">
                    <img src="{{ Storage::url($item->file) }}" alt="" class="" style="height: 520px" />
                </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <div class="py-2">
            {!! $data->contenido !!}
        </div>
    </div>


    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp mb-2" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Redes Sociales</h6>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    {{-- {!! $data->file_video[0]->file !!} --}}
                    {{-- {{ $data->file_video }} --}}
                </div>

            </div>

        </div>
    </div>

@endsection

@section('js')
        <script>
            $(document).ready(function(){
                $('.owl-carousel').owlCarousel({
                    loop: true,
                    margin: 10,
                    // nav: true,
                    dots: false,
                    autoplay: true,
                    autoplayTimeout: 5000,
                    center: true,
                    responsive:{
                        0:{
                            items:1
                        },
                        600:{
                            items:1
                        },
                        1000:{
                            items:2
                        }
                    }
                });
            });
        </script>

@endsection
