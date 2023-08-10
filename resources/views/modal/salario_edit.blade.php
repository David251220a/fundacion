@include('modal.head')

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
                    | Hora: {{date('H:i', strtotime($item->hora_entrada))}}
                    a {{date('H:i', strtotime($item->hora_salida))}}
                    | Dia: {{ ($item->lunes == 1 ? 'LUNES ' : '') }}
                    {{ ($item->martes == 1 ? 'MARTES ' : '')}}
                    {{ ($item->miercoles == 1 ? 'MIERCOLES ' : '')}}
                    {{ ($item->jueves == 1 ? 'JUEVES ' : '')}}
                    {{ ($item->viernes == 1 ? 'VIERNES ' : '')}}
                    {{ ($item->sabado == 1 ? 'SABADO ' : '')}}
                    {{ ($item->domingo == 1 ? 'DOMINGO ' : '')}}
                </label>
            </div>
        @endif
    </div>

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Salario</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Anticipo</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <h4 style="margin-top: -20px">Ingreso</h4>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <label for="">Concepto</label>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <label class="text-right" for="">Monto</label>
                </div>

                @for ($i = 0; $i < count($concepto_id); $i++)
                    <div class="col-md-6 col-sm-6 mb-1" >
                        <input type="text" class="form-control" value="{{$descripcion_concepto[$i]}}" readonly>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-1">
                        <input type="text" wire:model="monto_concepto.{{$i}}" class="form-control text-right" onkeyup="punto_decimal_limite(this)">
                    </div>
                @endfor

            </div>

            <hr>

            <h4 class="">Egreso</h4>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <label for="">Concepto</label>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <label class="text-right" for="">Monto</label>
                </div>

                @for ($i = 0; $i < count($e_concepto_id); $i++)
                    <div class="col-md-6 col-sm-6 mb-1" >
                        <label for="">{{$e_descripcion_concepto[$i]}}</label>
                    </div>
                    <div class="col-md-6 col-sm-6 mb-1 text-right">
                        <label class="text-right" for="">{{$e_monto_concepto[$i]}}</label>
                    </div>
                @endfor


            </div>

            <hr>
            <div class="form-row">
                <div class="col-md-6 col-sm-6">
                    <p style="font-size: 20px;color:white"> <b>Ingreso Neto:</b></p>
                </div>
                <div class="col-md-6 col-sm-6 text-right">
                    <input type="text" style="color: white; font-weight: bold" class="form-control text-right" value="{{$neto}}" readonly>
                </div>
            </div>

        </div>

        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <p class="modal-text">Fusce ac fringilla ex. Sed ligula ipsum, fringilla ut orci nec, suscipit commodo felis. Sed imperdiet eros
                dignissim, vehicula erat vel, rutrum lorem. In porttitor id ante nec laoreet. Etiam quis sapien ac nunc ullamcorper elementum.
                Fusce ullamcorper ante convallis nisl eleifend, sit amet dapibus urna eleifend.
            </p>
        </div>

    </div>
</div>

@include('modal.footer')
