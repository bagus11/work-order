<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="brand-link">
                <img src="{{asset('icon_1.png')}}" width="60px" height="25px" style="margin-left:auto;margin-right:auto;display:block;margin-top:0;margin-bottom:0;padding:0%" alt="" class="mb-0 mt-0">
             </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
       <li class="nav-item dropdown">
            <a href="#" data-toggle ="dropdown" class="nav-link">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">  
             
                <div class="dropdown-divider"></div>
                @can('view-setting_password')
                <a href="{{route('setting_password')}}" class="dropdown-item">
                    <i class="fas fa-tools mr-2"></i>Setting<span class="float-right text-muted text-sm"></span>
                </a>
                @endcan

                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item dropdown-footer">
                    <i class="fas fa-sign-out-alt "></i> Log Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
              </div>
       </li>
    </ul>
</nav>