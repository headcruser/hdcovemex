@extends('layouts.panel')

@section('title','Administrar Permisos')

@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.permisos.index') }}">Permisos</a>
    </li>
    <li class="breadcrumb-item active">Asignar permisos</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de permisos</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.permisos.index') }}"
                        class="btn btn-success btn-sm"
                        title="Crear">
                        Permisos <i class="fas fa-check"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">

                <div class="row ">
                    <div class="col-lg-12 col-md-12">
                        <div class="pt-2 ">
                            <table class="table table-bordered table-striped" id="table_permisos">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th >Permisos/Roles</th>
                                            @foreach ($roles as $role)
                                                <th class="text-nowrap">{{$role->display_name}}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permisos as $permiso)
                                            <tr>
                                                <td class="bg-primary text-white" nowrap>{{$permiso->display_name}}</td>
                                                @foreach ($roles as $role)
                                                    <td style="font-size:14px; font-weight:bold" class="toggle_permiso text-center text-danger" id="celda_{{$role->id}}_{{$permiso->id}}" data-role="{{$role->id}}" data-permission="{{$permiso->id}}"></td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js') }}"></script>

    <script type="text/javascript">
        $(function(){
            function traer_permisos() {
                $('.toggle_permiso').html('');

                $.post('{{ route("admin.permisos.traer-permisos") }}',{}, function(result){
                    roles = result.roles;

                    $.each(roles, function(index, rol){
                        const permisos = rol.perms;

                        $.each(permisos, function(index, permiso){
                            $('#celda_'+rol.id+'_'+permiso.id).html('<i class="text-bold text-lg">X</i>');
                        })
                    })
                })
            }

            $('#table_permisos').DataTable({
                pageLength: 25,
                responsive: false,
                ordering: false,
                paging: false,
                info:false,
                searching: true,
                scrollCollapse: true,
                scrollY: "500px",
                fixedColumns: true,
                dom: 'Tfgt',
                drawCallback: function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
                },
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No se encontro ningún registro",
                "info": "Mostrando del _START_ al _END_ de _TOTAL_ registros. (Página _PAGE_ de _PAGES_)",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(Filtrado de un total de _MAX_ registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primera",
                        "last":       "Última",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                },
            });

            $('.toggle_permiso').click(function(){
                id_role = $(this).data('role');
                id_permission = $(this).data('permission');

                $.post('{{ route("admin.permisos.guardar-permiso") }}', {id_role: id_role, id_permission: id_permission }, function(result){
                    traer_permisos();
                })
            });

            $(document).ready(function () {
                traer_permisos();
            });
        });
    </script>
@endsection

