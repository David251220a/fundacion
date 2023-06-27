@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/select2/select2.min.css')}}">
    <link href="{{asset('plugins/sweetalerts/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('plugins/sweetalerts/sweetalert.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/components/custom-sweetalert.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Ingreso Varios</h2>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <p>Documento: {{number_format($persona->documento, 0, ".", ".")}}</p>
                <p>Nombre y Apellido: {{$persona->nombre}} {{$persona->apellido}}</p>
            </div>
        </div>

        <form action="{{route('ingreso_varios.ingreso_persona_post', $persona)}}" method="POST" onsubmit="disableButton()">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Ingreso Concepto - <button type="button" id="add_concepto" style="    border-radius: 40%;
                        background: limegreen;
                        border-color: limegreen;
                        color: white;
                        font-weight: bold;" data-toggle="modal" data-target="#modal_agregar"> Crear</button> </label>
                    <select name="concepto" id="concepto" class="form-control basic" onchange="cambiar_precio(this)">
                        @foreach ($ingreso_concepto as $item)
                            <option value="{{$item->id}}">{{$item->descripcion}}</option>
                        @endforeach
                    </select>

                    <select name="concepto_precio" id="concepto_precio" class="form-control" hidden>
                        @foreach ($ingreso_concepto as $item)
                            <option value="{{$item->precio}}">{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-2">
                    <label for="">Ingreso Concepto</label>
                    <input type="text" id="precio" value="{{number_format($ingreso_concepto[0]->precio, 0, ".", ".")}}" class="form-control text-right"
                    onkeyup="punto_decimal(this)">
                </div>

                <div class="form-group col-md-2">
                    <label for="">Cantidad</label>
                    <input type="number" id="cantidad" value="1" class="form-control text-right" min="0">
                </div>

                <div class="form-group col-md-2">
                    <label for="" class="w-full" style="width: 100%">Accion</label>
                    <button type="button" class="btn btn-secondary" id="add_ingreso" onclick="agregar_ingreso()">Agregar</button>
                </div>

            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 mb-4">
                <div class="widget-content widget-content-area br-6 table-responsive">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Ingreso Concepto</th>
                                <th>Precio</th>
                                <th>Cantidad</th>
                                <th>Monto Total</th>
                                <th class="no-content">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="ingresos">
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-3">
                    <label for="">Total a Pagar</label>
                    <input type="text" id="total_a_pagar" name="total_a_pagar" value="0" class="form-control text-right" readonly>
                </div>

                <div class="form-group col-md-3">
                    <label for="">Monto a Pagar</label>
                    <input type="text" id="monto_a_pagar" name="monto_a_pagar" value="0" class="form-control text-right" onkeyup="punto_decimal(this)">
                </div>

                <div class="form-group col-md-3">
                    <label for="">Forma de Pago</label>
                    <select name="forma_pago" id="forma_pago" class="form-control">
                        @foreach ($forma_pago as $item)
                            <option value="{{$item->id}}">{{$item->descripcion}}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="form-row">
                <button class="btn btn-success mr-3" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Grabar</button>
                <a href="{{route('ingreso_varios.buscar')}}" class="btn btn-info mr-3">Buscar Alumno</a>
                <a href="{{route('ingreso_varios.index')}}" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>
        @include('modal.ingreso_concepto')
    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/select2/select2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js" defer></script>
    <script src="{{asset('js/ingreso/ingreso.js')}}"></script>
@endsection
