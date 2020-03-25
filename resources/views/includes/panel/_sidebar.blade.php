 <!-- MAIN SIDEBAR CONTAINER -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- BRAND LOGO -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('img/AdminLTELogo.png') }}"
            alt="{{ config('app.name') }}"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <!-- END BRAND LOGO -->

    <!-- SIDEBAR -->
    <div class="sidebar">
        <!-- SIDEBAR USER-->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{  auth()->user()->avatar }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->nombre }}</a>
            </div>
        </div>

        <!-- SIDEBAR MENU  -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">Navegación</li>

                <!-- ADMINISTRACION -->
                <li class="nav-header">Administrativo</li>

                <li class="nav-item has-treeview {{ active('administracion/*', 'menu-open') }} ">
                    <a href="#" class="nav-link {{ active('administracion/*') }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Administracion
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ routeIs(['admin.usuarios.index','admin.usuarios.*']) }}">
                                <i class="nav-icon fas fa-user-friends"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}" class="nav-link {{ routeIs(['admin.roles.index','admin.roles.*']) }}">
                                <i class="nav-icon fas fa-user-lock"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a  href="{{ route('admin.permisos.index') }}" class="nav-link {{ routeIs(['admin.permisos.index','admin.permisos.*']) }} class="nav-link">
                                <i class="nav-icon fas fa-key"></i>
                                <p>Permisos</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- GESTION -->
                <li class="nav-header">Gestión</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>Tickets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>Asignación</p>
                    </a>
                </li>

                <!-- CONFIGURACION-->
                <li class="nav-header">Configuracion</li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Tipos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Prioridades</p>
                    </a>
                </li>

                <!-- REPORTES -->
                <li class="nav-header">Reportes</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-plus-circle"></i>
                        <p>Creados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-clock nav-icon"></i>
                        <p>Pendientes</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- ENDSIDEBAR -->
</aside>
<!-- END MAIN SIDEBAR CONTAINER -->
