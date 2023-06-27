@extends('layouts.admin')

@section('styles')

@endsection

@section('content')

    <div class="layout-px-spacing mt-4">

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h2 class="">Ingreso Varios - Cobros Pendiente</h2>
            </div>
        </div>

        <form action="#" method="POST" onsubmit="disableButton()">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="">Documento</label>
                    <input type="text" class="form-control text-right" value="{{$persona->documento}}" readonly>
                </div>

                <div class="form-group col-md-4">
                    <label for="">Nombre y Apellido</label>
                    <input type="text" class="form-control text-left" value="{{$persona->nombre .' ' .$persona->apellido }}" readonly>
                </div>
            </div>

            <div class="col-xl-12 col-lg-12 col-sm-12 mb-4">
                <div class="widget-content widget-content-area br-6 table-responsive">
                    <table id="zero-config" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Accion</th>
                                <th>Total a Pagar</th>
                                <th>Monto Pagado</th>
                                <th>Saldo</th>
                                <th>Detalle Saldos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendiente as $item)
                                <tr>
                                    <td>
                                        <button type="button" class="btn btn-info btn-sm mr-2 mb-2">Cobrar</button>
                                        <button type="button" class="btn btn-info btn-sm mr-2 mb-2">Cobrar Completo</button>
                                    </td>
                                    <td class="text-right">
                                        {{number_format($item->detalle->sum('total_pagar'), 0, ".", ".")}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($item->detalle->sum('monto_pagado'), 0, ".", ".")}}
                                    </td>
                                    <td class="text-right">
                                        {{number_format($item->detalle->sum('saldo'), 0, ".", ".")}}
                                    </td>
                                    <td>
                                        @foreach ($item->detalle as $det)
                                            @if ($det->saldo > 0)
                                                {{number_format($det->saldo, 0, ".", ".")}} - {{$det->producto->descripcion}}
                                                <br>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-row">
                <button class="btn btn-success mr-3" type="submit" id="submitBtn" onclick="this.disabled = true; this.form.submit();">Siguiente</button>
                <a href="{{route('ingreso_varios.index')}}" class="btn btn-warning">Volver al Inicio</a>
            </div>
        </form>

    </div>

@endsection

@section('js')

@endsection
