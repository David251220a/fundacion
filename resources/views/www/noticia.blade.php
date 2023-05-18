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

    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="row g-3">
                <div class="col-lg-12 col-md-12">
                    <div class="row g-3">
                        @foreach ($data as $item)
                            <div class="col-lg-4 col-md-4 wow zoomIn" data-wow-delay="0.3s">
                                <a class="position-relative d-block overflow-hidden" href="{{route('new_detalle', $item->slug)}}">
                                    <img class="img-fluid" src="{{Storage::url($item->files_fotos[0]->file)}}" alt="">
                                    <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                        <h5 class="m-0">{{$item->titulo}}</h5>
                                        <small class="text-primary">
                                            @foreach ($item->tag as $a)
                                                {{$a->tag->descripcion}}
                                                @if (!$loop->last)
                                                -
                                                @else

                                                @endif
                                            @endforeach

                                        </small>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="pagination">
            {{ $data->links('pagination::bootstrap-4') }}
        </div>
    </div>



@endsection

@section('js')

@endsection
