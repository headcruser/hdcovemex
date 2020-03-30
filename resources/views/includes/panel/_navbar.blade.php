<!-- NAVBAR -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- LEFT NAVBARS LINKS -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- RIGHT NAVBAR LINKS -->
    <ul class="navbar-nav ml-auto">

        <!-- NOTIFICACIONES -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                @if(auth()->user()->unreadNotifications->count())
                    <span class="badge badge-info navbar-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('notificaciones') }}" class="dropdown-item">
                    <i class="fas fa-bell mr-2"></i> Notificaciones
                    <span class="float-right text-muted text-sm">{{ auth()->user()->unreadNotifications->count() }}</span>
                </a>
            </div>
        </li>

        <!-- OPCIONES -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-th-large"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('perfil') }}" class="dropdown-item">
                    <i class="far fa-address-card"></i>
                    <span>Perfil</span>
                </a>

                <div class="dropdown-divider"></div>

                <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('form-logout').submit();">
                    <i class="fas fa-door-closed"></i>
                    <span>Cerrar sesión</span>
                </a>
                <form action="{{ route('logout') }}" method="POST" style="display: none;" id="form-logout">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
