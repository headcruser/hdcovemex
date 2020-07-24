 <!-- MAIN SIDEBAR CONTAINER -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- BRAND LOGO -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('img/logo-corporativo.jpg') }}"
            alt="{{ config('app.name') }}"
            class="brand-image img-circle elevation-2"
            style="opacity: .9">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>
    <!-- END BRAND LOGO -->

    <!-- SIDEBAR -->
    <div class="sidebar">
        <!-- SIDEBAR USER-->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img id="avatar-image" src="{{  auth()->user()->avatar }}" class="img-circle elevation-2" alt="User Image" style="width:35px;height:35px;">
            </div>
            <div class="info">
                <a href="{{ route('perfil') }}" class="d-block"> <span>{{ auth()->user()->nombre }}</span> </a>
                <span class="description text-gray">{{ auth()->user()->nameRoleUser }}</span>
            </div>
        </div>

        <!-- SIDEBAR MENU  -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-header">Navegación</li>

                <!-- ADMINISTRACION -->
                @permission('user_management_access')
                    <li class="nav-header">Administrativo</li>

                    <li class="nav-item has-treeview {{ active('administracion/*', 'menu-open') }} ">
                        <a href="#" class="nav-link {{ active('administracion/*') }}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Administración
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @permission('user_access')
                                <li class="nav-item ">
                                    <a href="{{ route('admin.usuarios.index') }}" class="nav-link {{ routeIs(['admin.usuarios.index','admin.usuarios.*']) }}">
                                        <i class="nav-icon fas fa-user-friends"></i>
                                        <p>Usuarios</p>
                                    </a>
                                </li>
                            @endpermission

                            @permission('role_access')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link {{ routeIs(['admin.roles.index','admin.roles.*']) }}">
                                    <i class="nav-icon fas fa-user-lock"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            @endpermission

                            @permission('permission_access')
                            <li class="nav-item">
                                <a  href="{{ route('admin.permisos.index') }}" class="nav-link {{ routeIs(['admin.permisos.index','admin.permisos.*']) }}">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Permisos</p>
                                </a>
                            </li>
                            @endpermission


                            @permission('departament_access')
                            <li class="nav-item">
                                <a  href="{{ route('admin.departamentos.index') }}" class="nav-link {{ routeIs(['admin.departamentos.index','admin.departamentos.*']) }}">
                                    <i class="nav-icon fas fa-hotel"></i>
                                    <p>Departamentos</p>
                                </a>
                            </li>
                            @endpermission

                            @permission('log_email_access')
                            <li class="nav-item">
                                <a  href="{{ route('admin.log-email.index') }}" class="nav-link {{ routeIs(['admin.log-email.index','admin.log-email.*']) }}">
                                    <i class="nav-icon fas fa-envelope-open-text"></i>
                                    <p>Log Email</p>
                                </a>
                            </li>
                            @endpermission

                            @permission('operator_access')
                            <li class="nav-item">
                                <a  href="{{ route('admin.operadores.index') }}" class="nav-link {{ routeIs(['admin.operadores.index','admin.operadores.*']) }}">
                                    <i class="nav-icon fas fa-people-carry"></i>
                                    <p>Operadores</p>
                                </a>
                            </li>
                            @endpermission

                        </ul>
                    </li>
                @endpermission

                <!-- GESTION -->
                <li class="nav-header">Gestión</li>

                @role('soporte')
                    @permission('solicitude_access')
                    <li class="nav-item">
                        <a  href="{{ route('operador.gestion-solicitudes.index') }}" class="nav-link {{ routeIs(['operador.gestion-solicitudes.index','operador.gestion-solicitudes.*']) }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Solicitudes</p>
                        </a>
                    </li>
                    @endpermission
                @endrole

                @role('empleado')
                    @permission('solicitude_access')
                    <li class="nav-item">
                        <a href="{{ route('solicitudes.index') }}" class="nav-link {{ routeIs(['solicitudes.index','solicitudes.*']) }}">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>Solicitudes</p>
                        </a>
                    </li>
                    @endpermission
                @endrole

                @ability('admin,soporte,ti', 'ticket_access')
                <li class="nav-item">
                    <a href="{{ route('operador.tickets.index') }}" class="nav-link {{ routeIs(['operador.tickets.index','operador.tickets.*']) }} ">
                        <i class="nav-icon fas fa-sticky-note"></i>
                        <p>Tickets</p>
                    </a>
                </li>
                @endpermission

                <!-- CONFIGURACION-->
                @permission('user_config_access')
                    <li class="nav-header">Configuración</li>

                    @permission('attribute_access')
                        <li class="nav-item" >
                            <a href="{{ route('config.atributos.index') }}" class="nav-link {{ routeIs(['config.atributos.index','config.atributos.*']) }}">
                                <i class="nav-icon fas fa-check-square"></i>
                                <p>Atributos</p>
                            </a>
                        </li>
                    @endpermission

                    @permission('status_access')
                        <li class="nav-item" >
                            <a href="{{ route('config.estatus.index') }}" class="nav-link {{ routeIs(['config.estatus.index','config.estatus.*']) }}">
                                <i class="nav-icon fas fa-info-circle"></i>
                                <p>Estatus</p>
                            </a>
                        </li>
                    @endpermission
                @endpermission

                <!-- REPORTES -->
                @ability('admin,ti', 'report_access')
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
                @endability

                <!-- OPCIONES -->
                <li class="nav-header">Opciones</li>
                <li class="nav-item">
                    <a href="{{ route('perfil') }}" class="nav-link {{ routeIs(['perfil','perfil.*']) }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Perfil</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- ENDSIDEBAR -->
</aside>
<!-- END MAIN SIDEBAR CONTAINER -->
