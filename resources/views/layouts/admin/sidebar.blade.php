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

        <li class="menu">
            <a href="{{ route('noticias.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'noticias' ? 'data-active=true' : '')}}
                aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fas fa-newspaper mr-3"></i>
                    <span>Noticias</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{ route('alumno.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'alumno' ? 'data-active=true' : '')}}
                aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fas fa-user-graduate mr-3"></i>
                    <span>Alumnos</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{ route('habilitado.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'habilitado' ? 'data-active=true' : '')}}
                aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fas fa-book-reader mr-3"></i>
                    <span>Cursos Habilitados</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{ route('ingreso_matricula.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'ingreso_matricula' ? 'data-active=true' : '')}}
                aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fas fa-money-check-alt mr-3"></i>
                    <span>Ingreso Curso</span>
                </div>
            </a>
        </li>

        <li class="menu">
            <a href="{{ route('ingreso_varios.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'ingreso_varios' ? 'data-active=true' : '')}}
                aria-expanded="false" class="dropdown-toggle">
                <div class="">
                    <i class="fas fa-sack-dollar mr-3"></i>
                    <span>Ingreso Varios</span>
                </div>
            </a>
        </li>

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
                <li>
                    <a href="{{route('tipocurso.index')}}"> Familia </a>
                </li>
                <li>
                    <a href="{{route('curso.index')}}"> Curso </a>
                </li>

                <li>
                    <a href="{{route('instructor.index')}}"> Instructor </a>
                </li>
            </ul>
        </li>

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

        {{-- @can('user.index') --}}
            <li class="menu">
                <a href="{{ route('user.index') }}" {{(substr(Route::currentRouteName() , 0 , strpos(Route::currentRouteName(), '.')) == 'user' ? 'data-active=true' : '')}}
                    aria-expanded="false" class="dropdown-toggle">
                    <div class="">
                        <i class="fas fa-user-tie mr-3"></i>
                        <span>Usuario</span>
                    </div>
                </a>
            </li>
        {{-- @endcan --}}

        @can('role.index')
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
