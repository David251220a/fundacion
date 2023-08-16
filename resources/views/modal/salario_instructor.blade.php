<div wire:ignore.self class="modal fade bd-example-modal-lg" id="modal_salario_instructor" tabindex="-1" role="dialog" aria-labelledby="tabsModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tabsModalLabel">Pago a Instructor</h5>
                <button wire:click="resetUI()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="mb-2 ml-3">

                    @if (!(empty($instructor)))
                        <div class="row">
                            <label for="">
                                Nombre y Apellido: {{number_format($instructor->persona->documento, 0, ".", ".")}}
                                {{$instructor->persona->nombre}} {{$instructor->persona->apellido}}
                            </label>
                        </div>
                        <div class="row" style="margin-top: -10px">
                            <label for="">
                                Curso: {{$curso->id}} - {{$curso->tipo_curso->descripcion}}:
                                {{$curso->curso->descripcion}} - {{$curso->curso->modulo->descripcion}}
                            </label>
                        </div>
                        <div class="row" style="margin-top: -10px">
                            <label for="">
                                Periodo: {{date('d/m/Y', strtotime($curso->periodo_desde))}}
                                a {{date('d/m/Y', strtotime($curso->periodo_hasta))}}
                                | Hora: {{date('H:i', strtotime($curso->hora_entrada))}}
                                a {{date('H:i', strtotime($curso->hora_salida))}}
                                | Dia: {{ ($curso->lunes == 1 ? 'LUNES ' : '') }}
                                {{ ($curso->martes == 1 ? 'MARTES ' : '')}}
                                {{ ($curso->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                {{ ($curso->jueves == 1 ? 'JUEVES ' : '')}}
                                {{ ($curso->viernes == 1 ? 'VIERNES ' : '')}}
                                {{ ($curso->sabado == 1 ? 'SABADO ' : '')}}
                                {{ ($curso->domingo == 1 ? 'DOMINGO ' : '')}}
                            </label>
                        </div>
                    @endif
                </div>

                <div class="table-responsive mt-1">
                    <table id="" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    Ingreso
                                </th>
                            </tr>
                            <tr>
                                <th>Concepto</th>
                                <th class="text-right">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!(empty($ingreso)))
                                @foreach ($ingreso as $item)
                                    <tr>
                                        <td>{{$item->concepto->descripcion}}</td>
                                        <td class="text-right">{{number_format($item->importe, 0, ".", ".")}}</td>
                                    </tr>
                                @endforeach
                            @endif

                            <tr>
                                <td style="font-weight: bold; color: white; font-size: 15px" colspan="2">Egreso</td>
                            </tr>
                            @if (!(empty($egreso)))
                                @foreach ($egreso as $item)
                                    <tr>
                                        <td>{{$item->concepto->descripcion}}</td>
                                        <td class="text-right"> -{{number_format($item->importe, 0, ".", ".")}}</td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        <tfoot style="color: white;">
                            <tr>
                                <td>
                                    <b>Total Ingreso Neto:</b>
                                </td>
                                <td class="text-right">
                                    @php
                                        if (!(empty($ingreso))) {
                                            $neto = $ingreso->sum('importe') - $egreso->sum('importe');
                                        }else {
                                            $neto = 0;
                                        }

                                    @endphp
                                    <b>{{number_format($neto, 0, ".", ".")}}</b>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="form-row">
                    <div class="col-6">
                        <label for="">Forma Pago</label>
                        <select wire:model.defer="forma_pago_id" class="form-control">
                            @foreach ($forma_pago as $item)
                                <option value="{{$item->id}}">{{$item->descripcion}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button wire:click="resetUI()" class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
                <button wire:click="save_salario()" type="button" class="btn btn-primary">Pagar</button>

            </div>
        </div>
    </div>
</div>

