<nav id="sidebar">
    <div class="shadow-bottom"></div>
    <ul class="list-unstyled menu-categories" id="accordionExample">

        <li class="menu">
            <a href="{{ route('home') }}" {{(Route::currentRouteName() == 'home' ? 'data-active=true' : '')}}  aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fa-solid fa-house mr-3"></i>
                    <span>Inicio</span>
                </div>
            </a>
        </li>

        @can('noticias.index')
            <li class="menu">
                <a href="{{ route('noticias.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'noticias' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-newspaper mr-3"></i>
                        <span>Noticias</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('alumno.index')
            <li class="menu">
                <a href="{{ route('alumno.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'alumno' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-user-graduate mr-3"></i>
                        <span>Alumnos</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('habilitado.index')
            <li class="menu">
                <a href="{{ route('habilitado.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'habilitado' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-book-reader mr-3"></i>
                        <span>Cursos Habilitados</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('ingreso_matricula.index')
            <li class="menu">
                <a href="{{ route('ingreso_matricula.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'ingreso_matricula' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-money-check-alt mr-3"></i>
                        <span>Ingreso Curso</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('ingreso_varios.index')
            <li class="menu">
                <a href="{{ route('ingreso_varios.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'ingreso_varios' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-sack-dollar mr-3"></i>
                        <span>Ingreso Varios</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('agenda.index')
            <li class="menu">
                <a href="{{ route('agenda.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'agenda' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Agenda</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('agenda.general')
            <li class="menu">
                <a href="{{ route('agenda.general') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'agenda' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-bookmark mr-3"></i>
                        <span>Agenda General</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('cierre.cajero')
            <li class="menu">
                <a href="{{ route('cierre.cajero') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'cierre' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-trending-up"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18">
                            </polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                        <span>Cierre Caja</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('profesor.index')
            <li class="menu">
                <a href="{{ route('profesor.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'profesor' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-user-tie mr-3"></i>
                        <span>Instructor</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('general.index')
            <li class="menu">
                <a href="{{ route('general.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'general' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-info-circle mr-3"></i>
                        <span>General</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('ver_anulacion')
            <li class="menu">
                <a href="#anulacion" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        <span>Anulaciones</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="anulacion" data-parent="#accordionExample">
                    @can('anulacion.cursos')
                        <li>
                            <a href="{{route('anulacion.cursos')}}"> Cursos </a>
                        </li>
                    @endcan

                    @can('anulacion.ingreso_varios')
                        <li>
                            <a href="{{route('anulacion.ingreso_varios')}}"> Ingresos </a>
                        </li>
                    @endcan

                    @can('anulacion.anticipo')
                        <li>
                            <a href="{{route('anulacion.anticipo')}}"> Anticipo </a>
                        </li>
                    @endcan

                    @can('anulacion.otros_pago')
                        <li>
                            <a href="{{route('anulacion.otros_pago')}}"> Otros Pagos </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('ver_gerencia')
            <li class="menu">
                <a href="#gerencia" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                        <span>Gerencia</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="gerencia" data-parent="#accordionExample">
                    @can('cierre.falta_cierre')
                        <li>
                            <a href="{{route('cierre.falta_cierre')}}"> Falta Cajero </a>
                        </li>
                    @endcan

                    @can('cierre.consulta_gerente')
                        <li>
                            <a href="{{route('cierre.consulta_gerente')}}"> Consulta </a>
                        </li>
                    @endcan

                </ul>
            </li>
        @endcan

        @can('ver_opciones')
            <li class="menu">
                <a href="#components" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Mas Opciones</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="components" data-parent="#accordionExample">
                    @can('tipocurso.index')
                        <li>
                            <a href="{{route('tipocurso.index')}}"> Familia </a>
                        </li>
                    @endcan

                    @can('curso.index')
                        <li>
                            <a href="{{route('curso.index')}}"> Curso </a>
                        </li>
                    @endcan

                    @can('instructor.index')
                        <li>
                            <a href="{{route('instructor.index')}}"> Instructor </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan


        @can('ver_salario')
            <li class="menu">
                <a href="#ele" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-target"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                        <span>Salario</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="ele" data-parent="#accordionExample">
                    @can('pago_instructor.index')
                        <li>
                            <a href="{{route('pago_instructor.index')}}"> Instructores </a>
                        </li>
                    @endcan
                    @can('pago_empleados.index')
                        <li>
                            <a href="{{route('pago_empleados.index')}}"> Empleados </a>
                        </li>
                    @endcan
                    @can('pago_varios.index')
                        <li>
                            <a href="{{route('pago_varios.index')}}"> Varios </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('ver_consulta')
            <li class="menu">
                <a href="#consu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        <span>Consulta</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled" id="consu" data-parent="#accordionExample">
                    @can('consulta.curso_deuda')
                        <li>
                            <a href="{{route('consulta.curso_deuda')}}"> Cursos </a>
                        </li>
                    @endcan

                    @can('consulta.pago')
                        <li>
                            <a href="{{route('consulta.pago')}}"> Pago </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('persona.index')
            <li class="menu">
                <a href="{{ route('persona.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'persona' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-user mr-3"></i>
                        <span>Persona</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('usuario.index')
            <li class="menu">
                <a href="{{ route('user.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'user' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-user-tie mr-3"></i>
                        <span>Usuario</span>
                    </div>
                </a>
            </li>
        @endcan

        @can('rol.index')
            <li class="menu">
                <a href="{{ route('role.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'role' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-users mr-3"></i>
                        <span>Grupo Usuario</span>
                    </div>
                </a>
            </li>
        @endcan

    </ul>
    <!-- <div class="shadow-bottom"></div> -->

</nav>
