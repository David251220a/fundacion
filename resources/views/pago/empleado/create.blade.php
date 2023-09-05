@extends('layouts.admin')

@section('styles')
@endsection

@section('content')

    <div class="row mt-4">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <h2 class="">Empleado Salario - Cierre Planilla</h2>
        </div>
    </div>

    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <form action="{{route('pago_empleados.store')}}" novalidate method="POST" onsubmit="disableButton()">
                        @csrf
                        <div class="form-row">
                            {{-- <div class="form-group col-md-2">
                                <label for="inputEmail4">Mes</label>
                                <input type="text" name="mes" id="mes" class="form-control text-right" value="{{old('mes', $mes)}}">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputEmail4">Año</label>
                                <input type="text" name="anio" id="anio" class="form-control text-right" value="{{old('anio', $año)}}">
                            </div> --}}
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Forma Pago</label>
                                <select name="forma_pago_id" id="forma_pago_id" class="form-control">
                                    @foreach ($forma_pago as $item)
                                        <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" >
                            <table id="" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="5%">N#</th>
                                        <th width="5%">Documento</th>
                                        <th width="30%">Nombre</th>
                                        <th width="30%">Apellido</th>
                                        <th width="10%">Ingreso</th>
                                        <th width="10%">Egreso</th>
                                        <th width="13%">Neto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_ingreso = 0;
                                        $total_egreso = 0;
                                        $total_neto = 0;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr>
                                            <td class="text-right">{{$loop->iteration}}</td>
                                            <td class="text-right" style="font-size: 11px">
                                                {{number_format($item->persona->documento, 0, ".", ".")}}
                                            </td>
                                            <td style="font-size: 11px">
                                                {{$item->persona->nombre}}
                                            </td>
                                            <td style="font-size: 11px">
                                                {{$item->persona->apellido}}
                                            </td>
                                            <td class="text-right" style="font-size: 11px">
                                                {{number_format($item->ingreso->where('salario_concepto_id', 1)->sum('importe'), 0, ".", ".")}}
                                            </td>
                                            <td class="text-right" style="font-size: 11px">
                                                {{number_format($item->egreso->sum('importe'), 0, ".", ".")}}
                                            </td>
                                            <td class="text-right" style="font-size: 11px">
                                                @php
                                                    $valor = $item->ingreso->where('salario_concepto_id', 1)->sum('importe') - $item->egreso->sum('importe');
                                                    $total_ingreso += $item->ingreso->where('salario_concepto_id', 1)->sum('importe');
                                                    $total_egreso += $item->egreso->sum('importe');
                                                    $total_neto += $valor;
                                                @endphp
                                                {{number_format($valor, 0, ".", ".")}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="" style="color: :white; font-size: 15px">Total General</th>
                                        <th class="text-right">{{number_format($total_ingreso, 0, ".", ".")}}</th>
                                        <th class="text-right">{{number_format($total_egreso, 0, ".", ".")}}</th>
                                        <th class="text-right">{{number_format($total_neto, 0, ".", ".")}}</th>
                                        <input type="hidden" name="neto_importe" value="{{$total_neto}}">
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-success ml-3" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Grabar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')
    <script src="{{asset('plugins/sweetalerts/sweetalert2.min.js')}}"></script>
    <script src="{{asset('plugins/sweetalerts/custom-sweetalert.js')}}"></script>
    <script src="{{asset('js/pago/empleado.js')}}"></script>

@endsection
