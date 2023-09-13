@extends('layouts.admin')

@section('styles')
@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row layout-spacing">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class=" p-3">Empleados Salarios</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
                <div class="widget-content widget-content-area br-6 table-responsive">
                    <div class="form-row">

                        <div class="col-md-3 mb-2">
                            <label for="">Fecha Pago</label>
                            <input type="text" class="form-control" value="{{date('d/m/Y', strtotime($data->created_at))}}" readonly>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label for="">Usuario</label>
                            <input type="text" class="form-control" value="{{$data->usuario->name}}" readonly>
                        </div>

                        <div class="col-md-3 mb-2">
                            <label for="">Total Pagado</label>
                            <input type="text" class="form-control text-right" value="{{number_format($data->total_neto, 0, ".", ".")}}" readonly>
                        </div>

                        <div class="col-md-3 mb-2" id="anular">
                            <label for="">Acción</label>
                            <br>
                            <button class="btn btn-danger" onclick="anular()">Anular</button>
                        </div>

                        <div class="col-md-3 mb-2" id="listo" style="display: none">
                            <label for="">Desea anular este cierre?</label>
                            <br>
                            <form action="{{route('pago_empleados.anular', $data->id)}}" method="post">
                                @csrf
                                <button type="button" onclick="no_procesar()" class="btn btn-warning mr-2">NO</button>
                                <button type="submit" class="btn btn-danger mr-2">SI</button>
                            </form>

                        </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12 mt-4">
            <div class="widget-content widget-content-area br-6 table-responsive">
                <table id="zero-config" class="table dt-table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Remuneracion</th>
                            <th>Egreso</th>
                            <th>Neto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empleado as $item)
                            <tr style="font-weight: bold">
                                <td style="text-align: right">{{number_format($item->empleado->persona->documento, 0, ".", ".")}}</td>
                                <td>{{$item->empleado->persona->nombre}}</td>
                                <td>{{$item->empleado->persona->apellido}}</td>
                                <td class="text-right">
                                    @php
                                        $sal = $salario->where('empleado_id', $item->empleado_id)->sum('salario');
                                    @endphp
                                    {{number_format($sal, 0, ".", ".")}}
                                </td>
                                <td class="text-right">
                                    @php
                                        $egre = $egreso->where('empleado_id', $item->empleado_id)->sum('egreso');
                                    @endphp
                                    {{number_format($egre, 0, ".", ".")}}
                                </td>
                                <td class="text-right">
                                    {{number_format($sal - $egre, 0, ".", ".")}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" style="font-size: 20px">Totales</th>
                            <th class="text-right" style="font-size: 20px">{{number_format($salario->sum('salario'), 0, ".", ".")}}</th>
                            <th class="text-right" style="font-size: 20px">{{number_format($egreso->sum('egreso'), 0, ".", ".")}}</th>
                            <th class="text-right" style="font-size: 20px">{{number_format($salario->sum('salario')- $egreso->sum('egreso'), 0, ".", ".")}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

@endsection

@section('js')

<script>
    function anular()
    {
        document.getElementById('anular').style = 'display: none';
        document.getElementById('listo').style = 'display: block';
    }

    function no_procesar()
    {
        document.getElementById('anular').style = 'display: block';
        document.getElementById('listo').style = 'display: none';
    }
</script>
@endsection
