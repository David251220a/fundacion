@extends('layouts.admin')

@section('content')
    <div class="row mt-4">
        <div class="col-lg-10 col-md-10 col-sm-12">
            <h2 class="">Crear Noticias</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form >
                        <div class="form-row mb-2">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Titulo</label>
                                <input type="text" class="form-control" placeholder="titulo" name="titulo" id="name" value="{{old('titulo')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" readonly value="{{old('slug')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Portada</label>
                                <select name="portada" id="portada" class="form-control">
                                    <option {{ (old('portada')== 1 ? 'selected' : '') }} value="1">SI</option>
                                    <option {{ (old('portada')== 2 ? 'selected' : '') }} value="2">NO</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Publicación Facebbok</label>
                                <input type="text" class="form-control" name="facebook" id="facebook" value="{{old('facebook')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Publicación Instagram</label>
                                <input type="text" class="form-control" id="instagram" name="instagram" value="{{old('instagram')}}">
                            </div>
                        </div>

                        <h4>Tags</h4>
                        <div class="row">
                            @foreach ($tags as $item)
                                <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                                    <label>
                                        <input type="checkbox" name="tags[]" id="tags" class=""
                                        value="{{ $item->id}}">
                                        {{$item->descripcion}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                      <button type="submit" class="btn btn-succes mt-3">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

