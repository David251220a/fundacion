<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm expand-header">

        {{-- <ul class="navbar-item theme-brand flex-row  text-center">
            <li class="nav-item theme-logo">
                <a href="#">
                    <img src="{{Storage::url('iconos/logo_horizontal.png')}}" class="navbar-logo" alt="logo">
                </a>
            </li>
            <li class="nav-item theme-text">
                <a href="index.html" class="nav-link"> KATU </a>
            </li>
        </ul> --}}
        <a href="{{route('home')}}" class="text-white"><img src="{{Storage::url('iconos/logo_horizontal-1.png')}}" class="navbar-logo" alt="logo" style="width: 200px;
            margin-left: 5px;
            margin-right: 10px;">
        </a>
        <ul class="navbar-item flex-row ml-md-0 ml-auto ml-3">
            <li class="nav-item align-self-center search-animated">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" s
                    troke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <form class="form-inline search-full form-inline search" role="search">
                    <div class="search-bar">
                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">
                    </div>
                </form>
            </li>
        </ul>

        <ul class="navbar-item flex-row ml-md-auto">

            <li class="nav-item dropdown user-profile-dropdown">
                <a href="javascript:void(0);" class="nav-link dropdown-toggle user" id="userProfileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <img src="{{Storage::url('iconos/user.png')}}" alt="avatar">
                </a>
                <div class="dropdown-menu position-absolute" aria-labelledby="userProfileDropdown">
                    <div class="">
                        <div class="dropdown-item">

                            <a href="{{ url('/logout')}}" class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Cerrar Session
                            </a>
                        </div>
                    </div>
                </div>

            </li>

        </ul>
    </header>
</div>
