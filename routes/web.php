<?php

/*
|--------------------------------------------------------------------------
| Web Routes (HDCOVEMEX)
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
|
*/

# DASHBOARD
Route::get('/', 'HomeController@index')
    ->middleware('auth')
    ->name('home');

# PERFIL
Route::group([
    'prefix'        => 'perfil',
    'middleware'    => ['auth']],
    function () {
        Route::get('/',[
            'as'    => 'perfil',
            'uses'  => 'ProfileController@edit'
        ]);

        Route::post('/',[
            'as'    => 'perfil.store',
            'uses'  => 'ProfileController@store'
        ]);
    }
);

# NOTIFICACIONES
Route::group([
    'prefix'        => 'notificaciones',
    'middleware'    => ['auth']],
    function () {

        Route::get('/', [
            'as'    => 'notificaciones',
            'uses'  => 'HomeController@notificaciones'
        ]);

        Route::post('/', [
            'as'    => 'notificaciones.delete',
            'uses'  => 'HomeController@deleteNotifications'
        ]);
    }
);


# AUTENTICATION
Auth::routes([
    'register' => false
]);

# ADMINISTRACION
Route::group([
    'prefix'        => 'administracion',
    'as'            => 'admin.',
    'namespace'     => 'Admin',
    'middleware'    => ['auth']],
    function () {
        # USUARIOS
        Route::post('usuarios/generar-password','UsersController@generar_password')->name('usuarios.generar-passowrd');
        Route::post('usuarios/datatables','UsersController@datatables')->name('usuarios.datatables');
        Route::post('usuarios/importar','UsersController@importar')->name('usuarios.importar');
        Route::post('usuarios/{usuario}/enviar-datos-acceso','UsersController@enviar_datos_acceso')->name('usuarios.enviar-datos-acceso');
        Route::resource('usuarios', 'UsersController')->parameters([
            'usuarios'  => 'model'
        ]);

        # ROLES
        Route::post('roles/datatables','RolesController@datatables')->name('roles.datatables');
        Route::resource('roles', 'RolesController')->parameters([
            'roles' => 'model'
        ]);

        # PERMISOS
        Route::get('permisos/asignar','PermisosController@asignar')->name('permisos.asignar');
        Route::post('permisos/guardar_permiso','PermisosController@guardar_permiso')->name('permisos.guardar-permiso');
        Route::post('permisos/traer_permisos','PermisosController@traer_permisos')->name('permisos.traer-permisos');
        Route::post('permisos/datatables','PermisosController@datatables')->name('permisos.datatables');
        Route::resource('permisos', 'PermisosController')->parameters([
            'permisos' => 'model'
        ]);

        # DEPARTAMENTOS
        Route::post('departamentos/datatables','DepartamentsController@datatables')->name('departamentos.datatables');
        Route::post('departamentos/select2', 'DepartamentsController@select2')->name('departamentos.select2');
        Route::resource('departamentos', 'DepartamentsController')->parameters([
            'departamentos'  => 'model'
        ]);

        # LOG EMAIL
        Route::delete('log-email/destroy', 'LogEmailController@massDestroy')->name('log-email.masive-destroy');
        Route::post('log-email/datatables','LogEmailController@datatables')->name('log-email.datatables');
        Route::resource('log-email', 'LogEmailController')->parameters([
            'log-email' => 'logEmail'
        ])->only(['index','show','destroy']);

        # OPERADORES
        Route::prefix('operadores')->name('operadores.')->group(function () {
            Route::post('datatables','OperatorsController@datatables')->name('datatables');
        });

        Route::resource('operadores', 'OperatorsController')->parameters([
            'operadores'  => 'operador'
        ]);

        # ATRIBUTOS
        Route::post('atributos/datatables','AttributesController@datatables')->name('atributos.datatables');
        Route::resource('atributos', 'AttributesController')->parameters([
            'atributos' => 'model'
        ]);

        # ESTATUS
        Route::post('estatus/datatables','StatusesController@datatables')->name('estatus.datatables');
        Route::resource('estatus', 'StatusesController')->parameters([
            'estatus' => 'model'
        ]);
    }
);

# GESTION DE INVENTARIOS
Route::group([
    'prefix'        => 'gestion-inventarios',
    'as'            => 'gestion-inventarios.',
    'namespace'     => 'GestionInventarios',
    'middleware'    => ['auth']],
    function () {

        # 👉 TIPO DE HARDWARE
        Route::prefix('tipo-hardware')->name('tipo-hardware.')->group(function () {
            Route::post('select2', 'TipoHardwareController@select2')->name('select2');
            Route::post('datatables','TipoHardwareController@datatables')->name('datatables');
        });
        Route::resource('tipo-hardware', 'TipoHardwareController')->parameters([
            'tipo-hardware'  => 'tipoHardware'
        ])->except('show');

        # 👉 HARDWARE
        Route::prefix('hardware')->name('hardware.')->group(function () {
            Route::post('select2', 'HardwareController@select2')->name('select2');
            Route::post('datatables','HardwareController@datatables')->name('datatables');
        });
        Route::resource('hardware', 'HardwareController')->parameters([
            'hardware'  => 'hardware'
        ])->except('show');

        # 👉 EQUIPOS
        Route::prefix('equipos')->name('equipos.')->group(function () {
            Route::post('buscar_componente_equipo/{componenteEquipo}','EquiposController@buscar_componente_equipo')->name('buscar_componente_equipo');
            Route::post('agregar_componente_equipo','EquiposController@agregar_componente_equipo')->name('agregar_componente_equipo');
            Route::put('actualizar_componente_equipo/{componenteEquipo}','EquiposController@actualizar_componente_equipo')->name('actualizar_componente_equipo');
            Route::delete('eliminar_componente_equipo/{componenteEquipo}','EquiposController@eliminar_componente_equipo')->name('eliminar_componente_equipo');
            Route::post('datatables_componentes_equipo','EquiposController@datatables_componentes_equipo')->name('datatables_componentes_equipo');
            Route::post('datatables_asignar_equipo','EquiposController@datatables_asignar_equipo')->name('datatables_asignar_equipo');
            Route::post('datatables','EquiposController@datatables')->name('datatables');
            Route::post('actualizar_informacion', 'EquiposController@actualizar_informacion')->name('actualizar_informacion');

            Route::post('asignar_equipo', 'EquiposController@asignar_equipo')->name('asignar_equipo');
            Route::put('editar_asignar_equipo/{equipoAsignado}', 'EquiposController@editar_asignar_equipo')->name('editar_asignar_equipo');
            Route::delete('eliminar_asignar_equipo/{equipoAsignado}', 'EquiposController@eliminar_asignar_equipo')->name('eliminar_asignar_equipo');
            Route::post('actualizar_asignacion_equipo', 'EquiposController@actualizar_asignacion_equipo')->name('actualizar_asignacion_equipo');
        });
        Route::resource('equipos', 'EquiposController')->parameters([
            'equipos'  => 'equipo'
        ]);

        # SUCURSALES
        Route::prefix('sucursales')->name('sucursales.')->group(function(){
            Route::post('datatables',"SucursalController@datatables")->name('datatables');
            Route::post('select2',"SucursalController@select2")->name('select2');
        });
        Route::resource('sucursales', 'SucursalController')->parameters([
            'sucursales'  => 'sucursal'
        ])->except('show');

        # PERSONAL
        Route::post('personal/importar',"PersonalController@importar")->name('personal.importar');
        Route::post('personal/actualizar_cuenta/{cuenta}',"PersonalController@actualizar_cuenta")->name('personal.actualizar_cuenta');
        Route::post('personal/eliminar_cuenta/{cuenta}',"PersonalController@eliminar_cuenta")->name('personal.eliminar_cuenta');
        Route::post('personal/listar_cuentas',"PersonalController@listar_cuentas")->name('personal.listar_cuentas');
        Route::post('personal/agregar_cuenta',"PersonalController@agregar_cuenta")->name('personal.agregar_cuenta');
        Route::post('personal/select2',"PersonalController@select2")->name('personal.select2');
        Route::post('personal/datatables',"PersonalController@datatables")->name('personal.datatables');
        Route::resource('personal', 'PersonalController')->parameters([
            'personal'  => 'personal'
        ]);

        # IMPRESORAS
        Route::post('impresoras/datatables','ImpresorasController@datatables')->name('impresoras.datatables');
        Route::resource('impresoras', 'ImpresorasController')->parameters([
            'impresoras'  => 'impresora'
        ]);

        # 👉 CREDENCIALES
        Route::prefix('credenciales')->name('credenciales.')->group(function () {
            Route::post('datatables', [
                'as'            => 'datatables',
                'uses'          => 'CredencialesController@datatables'
            ]);
        });

        Route::resource('credenciales', 'CredencialesController')->parameters([
            'credenciales'  => 'credencial'
        ])->middleware('permission:credenciales_access');
    }
);

# 👉 GESTION DE IMPRESIONES

Route::group([
    'prefix'        => 'gestion-impresiones',
    'as'            => 'gestion-impresiones.',
    'namespace'     => 'GestionImpresiones',
    'middleware'    => ['auth']],
    function () {
        # 👉 IMPRESIONES
        Route::prefix('impresiones')->name('impresiones.')->group(function () {
            Route::get('visualizar-impresiones','ImpresionesController@visualizar_impresiones')->name('visualizar-impresiones');
            Route::post('calcular-impresiones','ImpresionesController@calcular_impresiones')->name('calcular-impresiones');
            Route::post('generar-reportes','ImpresionesController@generar_reportes')->name('generar-reportes');
            Route::post('datatables','ImpresionesController@datatables')->name('datatables');
            Route::delete('{impresionDetalle}/eliminar-registro-impresiones','ImpresionesController@eliminar_registro_impresiones')->name('eliminar-registro-impresiones');
            Route::put('{impresionDetalle}/actualizar-registro-impresiones','ImpresionesController@actualizar_registro_impresiones')->name('actualizar-registro-impresiones');
            Route::post('{impresion}/crear-registro-impresiones','ImpresionesController@crear_registro_impresiones')->name('crear-registro-impresiones');
            Route::post('{impresion}/importar','ImpresionesController@importar')->name('importar');
            Route::post('{impresion}/agregar-registro-impresiones','ImpresionesController@agregar_registro_impresiones')->name('agregar-registro-impresiones');
            Route::delete('{impresion}/eliminar-registros-impresiones','ImpresionesController@eliminar_registros_impresiones')->name('eliminar-registros-impresiones');
        });
        Route::resource('impresiones', 'ImpresionesController')->parameters([
            'impresiones'  => 'impresion'
        ]);

        # 👉 REPORTE IMPRESIONES
        Route::get('reporte-impresiones', [
            'as'            => 'reporte-impresiones.index',
            'uses'          => 'ReporteImpresionesController@index'
        ]);

        Route::post('reporte-impresiones', [
            'as'            => 'reporte-impresiones.calcular',
            'uses'          => 'ReporteImpresionesController@calcular'
        ]);

        Route::post('reporte-impresiones/enviar-reporte-anual', [
            'as'            => 'reporte-impresiones.enviar-reporte-anual',
            'uses'          => 'ReporteImpresionesController@enviar_reporte_anual'
        ]);
    }
);

# OPERADOR
Route::group([
    'as'            => 'operador.',
    'namespace'     => 'Operador',
    'middleware'    => ['auth']],
    function () {

        # SOLICITUDES OPERADOR
        Route::prefix('gestion-solicitudes')->name('gestion-solicitudes.')->group(function () {
            Route::post('datatables','SolicitudesController@datatables')->name('datatables');

            Route::get('{model}/archivo', [
                'as'            => 'archivo',
                'uses'          => 'SolicitudesController@archivo'
            ]);

            Route::post('{solicitud}/cancelar', [
                'as'            => 'cancelar',
                'uses'          => 'SolicitudesController@cancelar_solicitud'
            ]);

            Route::post('{solicitud}/abrir-ticket', [
                'as'            => 'abrir-ticket',
                'uses'          => 'SolicitudesController@abrir_ticket'
            ]);
        });
        Route::resource('gestion-solicitudes', 'SolicitudesController')->parameters([
            'gestion-solicitudes' => 'model'
        ]);

        # TICKETS
        Route::prefix('tickets')->name('tickets.')->group(function () {
            Route::post('datatables', [
                'as'            => 'datatables',
                'uses'          => 'TicketController@datatables'
            ]);

            Route::post('comentarios/{model}',[
                'as'            => 'storeComentario',
                'uses'          => 'TicketController@storeComment'
            ]);

            Route::post('{ticket}/finalizar-ticket', [
                'as'            => 'finalizar-ticket',
                'uses'          => 'TicketController@finalizar_ticket'
            ]);

            Route::post('{ticket}/cancelar-ticket', [
                'as'            => 'cancelar-ticket',
                'uses'          => 'TicketController@cancelar_ticket'
            ]);
        });

        Route::resource('tickets', 'TicketController')->parameters([
            'tickets' => 'model'
        ]);

    }
);

# USUARIO
Route::group([
    'namespace'     => 'Usuario',
    'middleware'    => ['auth'],
],function () {

    # 👉 SOLICITUDES (EMPLEADO)
    Route::prefix('solicitudes')->name('solicitudes.')->group(function () {
        Route::post('datatables','SolicitudController@datatables')->name('datatables');

        # ARCHIVO ADJUNTO SOLICITUD
        Route::get('{model}/archivo','SolicitudController@archivo')->name('archivo');
    });

    Route::resource('solicitudes', 'SolicitudController')->parameters([
        'solicitudes' => 'model'
    ])->except(['edit','update','destroy']);



    # COMENTARIO SOLICITUD
    Route::post('solicitudes/{model}/comentario', [
        'as'            => 'solicitudes.storeComentario',
        'uses'          => 'SolicitudController@storeComment'
    ]);
});

# REPORTES
Route::group([
    'prefix'        => 'reportes',
    'as'            => 'reporte.',
    'namespace'     => 'Reportes',
    'middleware'    => ['auth']
], function () {
    Route::get('eficiencia/export', [
        'as'    => 'eficiencia.export',
        'uses'  => 'EficienciaReportController@export'
    ]);

    Route::get('eficiencia', [
        'as'    => 'eficiencia',
        'uses'  => 'EficienciaReportController@eficiencia'
    ]);

    Route::get('reporte-dinamico', [
        'as'    => 'reporte-dinamico',
        'uses'  => 'ReporteDinamicoController@index'
    ]);
});


# HERRAMIENTAS

Route::group([
    'prefix'        => 'herramientas',
    'as'            => 'herramientas.',
    'namespace'     => 'Herramientas',
    'middleware'    => ['auth']],
    function () {
        Route::get('barcode', [
            'as'            => 'barcode.index',
            'uses'          => 'BarcodeController@index'
        ]);

        Route::get('barcode/download', [
            'as'            => 'barcode.download',
            'uses'          => 'BarcodeController@download'
        ]);
    }
);
