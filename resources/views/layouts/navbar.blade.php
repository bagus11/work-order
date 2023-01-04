<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
       <li class="nav-item dropdown">
            <a href="#" data-toggle ="dropdown" class="nav-link">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">  
                <div class="dropdown-divider"></div>
                <a href="{{route('setting')}}" class="dropdown-item">
                  <i class="fas fa-tools mr-2"></i>Setting<span class="float-right text-muted text-sm"></span>
                </a>

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