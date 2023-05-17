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

        @can('user.index')
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
