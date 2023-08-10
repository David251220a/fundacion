<div>
    <div class="mt-4">
        <div class="table-responsive col-xl-12 col-lg-12 col-sm-12" style="margin-top: -40px">
            <table id="" class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th width="5%">Documento</th>
                        <th width="20%">Instructor</th>
                        <th width="30%">Curso</th>
                        <th width="8%">Fecha</th>
                        <th width="5%">Horario</th>
                        <th width="5%">Dias</th>
                        <th width="">Salario</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cursos as $item)
                        <tr>
                            <td class="text-right; font-size: 11px">
                                {{number_format($item->instructor->persona->documento, 0, ".", ".")}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->instructor->persona->nombre}} {{$item->instructor->persona->apellido}}
                            </td>
                            <td style="font-size: 11px">
                                {{$item->id}} - {{$item->tipo_curso->descripcion}}:
                                {{$item->curso->descripcion}} <br> {{$item->curso->modulo->descripcion}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('d/m/Y', strtotime($item->periodo_desde))}}
                                a <br> {{date('d/m/Y', strtotime($item->periodo_hasta))}}
                            </td>
                            <td style="font-size: 11px">
                                {{date('H:i', strtotime($item->hora_entrada))}}
                                a <br> {{date('H:i', strtotime($item->hora_salida))}}
                            </td>
                            <td style="font-size: 11px">
                                {{ ($item->lunes == 1 ? 'LUNES ' : '') }}
                                {{ ($item->martes == 1 ? 'MARTES ' : '')}}
                                {{ ($item->miercoles == 1 ? 'MIERCOLES ' : '')}}
                                {{ ($item->jueves == 1 ? 'JUEVES ' : '')}}
                                {{ ($item->viernes == 1 ? 'VIERNES ' : '')}}
                                {{ ($item->sabado == 1 ? 'SABADO ' : '')}}
                                {{ ($item->domingo == 1 ? 'DOMINGO ' : '')}}
                            </td>
                            <td class="text-right" style="font-size: 11px">
                                {{-- {{$item->salario_instructor($item->instructor_id)}} --}}
                                @php
                                    $sal = 0;
                                    if ($item->salario_instructor($item->instructor_id)->count() <> 0){
                                        $valor = $item->salario_instructor($item->instructor_id)->pluck('importe');
                                        $sal = str_replace('["', '', $valor);
                                        $sal = str_replace('"]', '', $sal);
                                        $sal = number_format($sal, 0, ".", ".");
                                    }

                                @endphp
                                {{$sal}}
                            </td>
                            <td style="font-size: 11px">
                                <a wire:click="datos({{$item->id}})" data-toggle="modal" data-target="#modal_heredado_tab">
                                    <i class="fas fa-pen mr-2" style="font-size: 15px;
                                    color: rgb(247, 168, 50);"></i>
                                </a>

                                <a wire:click="datos_anticipo({{$item->id}})" data-toggle="modal" data-target="#modal_anticipo_heredado_tab">
                                    <i class="fas fa-comments-dollar" style="font-size: 15px;
                                    color: rgb(200, 236, 70);"></i>
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-2">
        {{$cursos->links()}}
    </div>

    @include('modal.salario_edit')
    @include('modal.salario_anticipo')
</div>
