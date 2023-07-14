<div>
    <div class="row">
        <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Familia</label>
                            <select wire:model.defer="familia_id" class="form-control" onchange="cargar_curso()">
                                @foreach ($familia as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Curso</label>
                            <select wire:model.defer="curso_id" class="form-control">
                                <option value="0">--TODOS--</option>
                                @foreach ($cur as $item)
                                    <option value="{{$item->id}}">{{$item->descripcion}} - {{$item->modulo->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="inputEmail4">Curso</label> <br>
                            <button type="button" wire:click="filtro()" class="btn btn-info">Filtro</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        @foreach ($cursos as $item)

            <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <div class="card component-card_7 mb-4">
                    <a href="#" data-toggle="modal" data-target="#modal_buscar_{{$loop->iteration}}">
                        <div class="card-body" style="">
                            <img src="{{Storage::url('iconos/instructor.png')}}" alt="" style="width: 20%">
                            <h5 class="card-text">{{$item->curso->descripcion}}</h5>
                            <h6 class="">{{$item->curso->modulo->descripcion}}</h6>
                            <h6 class="">Familia: {{$item->tipo_curso->descripcion}}</h6>
                            <h6 class="">Cant Alumnos: {{ count($item->alumnos_cursando)}}</h6>
                            @php
                                $lunes = 'Lunes';
                                $martes = 'Martes';
                                $miercoles = 'Miercoles';
                                $jueves = 'Jueves';
                                $viernes = 'Viernes';
                                $sabado = 'Sabado';
                                $domingo = 'domingo';
                                $clases = '';
                                $ant = 0;
                                if($item->lunes){
                                    $clases = $lunes;
                                    $ant = 1;
                                }

                                if($item->martes){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $martes;
                                    }else {
                                        $clases = $martes;
                                        $ant = 1;
                                    }
                                }

                                if($item->miercoles){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $miercoles;
                                    }else {
                                        $clases = $miercoles;
                                        $ant = 1;
                                    }
                                }

                                if($item->jueves){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $jueves;
                                    }else {
                                        $clases = $jueves;
                                        $ant = 1;
                                    }
                                }

                                if($item->viernes){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $viernes;
                                    }else {
                                        $clases = $viernes;
                                        $ant = 1;
                                    }
                                }

                                if($item->sabado){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $sabado;
                                    }else {
                                        $clases = $sabado;
                                        $ant = 1;
                                    }
                                }

                                if($item->domingo){
                                    if($ant == 1){
                                        $clases = $clases . ', ' . $domingo;
                                    }else {
                                        $clases = $domingo;
                                        $ant = 1;
                                    }
                                }

                            @endphp
                            <h6 class="">Dias: {{$clases}}</h6>
                        </div>
                    </a>
                </div>
            </div>

            @include('modal.general_opciones')
        @endforeach

    </div>

</div>
