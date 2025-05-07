<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">

        <!-- Asset Notification -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="asset_notification">
                <i class="fas fa-paste"></i>
                <span class="badge badge-danger navbar-badge" id="asset_notification_count" style="font-size: 9px;"></span>
            </a>
        </li>
    
        <!-- General Notification -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" id="notifikasi">
                <ion-icon name="notifications-sharp"></ion-icon>
                <span class="badge badge-danger navbar-badge" id="notificationCount" style="font-size: 9px;"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"
                 style="width: 400px; max-height: 400px; overflow-y: auto;"
                 id="general_notification_body">
            </div>
        </li>
    
        <!-- User Profile -->
        <li class="nav-item dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link">
                <i class="fas fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    
                @can('view-setting_password')
                <a href="{{ route('setting_password') }}" class="dropdown-item">
                    <i class="fas fa-tools mr-2"></i> Setting
                </a>
                <div class="dropdown-divider"></div>
                @endcan
    
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="dropdown-item dropdown-footer">
                    <i class="fas fa-sign-out-alt"></i> Log Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    
    </ul>
    
</nav>