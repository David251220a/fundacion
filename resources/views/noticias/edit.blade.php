@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ckeditor-styles.css') }}">
@endsection

@section('content')
    <div class="row mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="">Editar Noticias</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form action="{{route('noticias.update', $data)}}" method="POST" enctype="multipart/form-data" onsubmit="disableButton()">
                        @method('PUT')
                        @csrf
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Titulo</label>
                                <input type="text" class="form-control" placeholder="titulo" name="titulo" id="titulo" value="{{old('titulo', $data->titulo)}}"
                                onchange="generarSlug()" onkeyup="generarSlug()" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" readonly value="{{old('slug', $data->slug)}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Portada</label>
                                <select name="portada" id="portada" class="form-control">
                                    <option {{ (old('portada', $data->portada)== 1 ? 'selected' : '') }} value="1">SI</option>
                                    <option {{ (old('portada', $data->portada)== 2 ? 'selected' : '') }} value="2">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Publicado</label>
                                <select name="publicado" id="publicado" class="form-control">
                                    <option {{ (old('publicado', $data->publicado)== 1 ? 'selected' : '') }} value="1">SI</option>
                                    <option {{ (old('publicado', $data->publicado)== 2 ? 'selected' : '') }} value="2">NO</option>
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Publicación Facebbok</label>
                                <input type="text" class="form-control" name="facebook" id="facebook" value="{{old('facebook', $data->feed_facebook)}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Publicación Instagram</label>
                                <input type="text" class="form-control" id="instagram" name="instagram" value="{{old('instagram', $data->feed_instagram)}}">
                            </div>
                        </div>

                        <h4>Tags</h4>
                        <div class="row">
                            @foreach ($tags as $item)
                                @php
                                    $si = 0;
                                    foreach ($data->tag as $a) {
                                        if ($a->tag_id == $item->id) {
                                            $si = 1;
                                        }
                                    }
                                @endphp
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                                    <label>
                                        <input type="checkbox" name="tags[]" id="tags" class=""
                                        value="{{$item->id}}" {{ $si == 1 ? 'checked' : null }}>
                                        {{$item->descripcion}}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">Contenido</label>
                                <textarea name="contenido" id="contenido" cols="30" rows="10" class="">{!! $data->contenido !!}</textarea>
                            </div>
                        </div>
                        <h4>Adjunto</h4>
                        <div class="form-row mb-2">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Foto 1</label>
                                <input type="file" class="form-control" name="file_1" id="file_1" value="{{old('file_1')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Foto 2</label>
                                <input type="file" class="form-control" name="file_2" id="file_2" value="{{old('file_1')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Foto 3</label>
                                <input type="file" class="form-control" name="file_3" id="file_3" value="{{old('file_1')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">Foto 4</label>
                                <input type="file" class="form-control" name="file_4" id="file_4" value="{{old('file_1')}}">
                            </div>

                            <div class="form-group col-md-12">
                                <label for="inputEmail4">Video</label>
                                @php
                                    $video = '';
                                    if(count($data->file_video) > 0){
                                        $video = $data->file_video[0]->file;
                                    }
                                @endphp
                                <input type="text" class="form-control" name="file_5" id="file_5" value="{{old('file_1', $video)}}">
                            </div>
                        </div>
                        <h4>Adjunto Cargado</h4>
                        <div class="col-xl-12 col-lg-12 col-sm-12">
                            <div class="widget-content widget-content-area br-6">
                                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Opcion Eliminar</th>
                                            <th>Foto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->files_fotos as $item)
                                            <tr style="font-weight: bold">
                                                <td>
                                                    <input type="checkbox" name="fotos[]" id="fotos" class=""
                                                    value="{{$item->id}}">
                                                    Eliminar Foto
                                                </td>
                                                <td> <img src="{{ Storage::url($item->file) }}" alt="" style="width: 300px;
                                                    height: 300px;"> </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                      <button type="submit" class="btn btn-success mt-3" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
        .create(document.querySelector('#contenido'))
        .then(editor => {
            editor.editing.view.change(writer => {
            writer.setStyle(' background-color', 'black', editor.editing.view.document.getRoot());
        });
        })
        .catch(error => {
            console.error(error);
        });

        function generarSlug() {
            // Obtener el valor del input del título
            const titulo = document.getElementById('titulo').value;

            // Reemplazar caracteres especiales y espacios en blanco por guiones
            const slug = titulo.toLowerCase().replace(/[^a-z0-9]+/g, '-');

            // Asignar el slug al input correspondiente
            document.getElementById('slug').value = slug;
        }

        function disableButton() {
            document.getElementById('submitBtn').disabled = true;
        }

    </script>
@endsection

