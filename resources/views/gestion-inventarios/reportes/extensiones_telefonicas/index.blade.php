@extends('layouts.panel')

@section('title','Extensiones Telefonicas')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Inicio </a>
        </li>
        <li class="breadcrumb-item">Gestión Inventarios </li>
        <li class="breadcrumb-item">Reportes</li>
        <li class="breadcrumb-item active">Ext. Tel.</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Extensiones Registradas en <mark>Personal</mark></h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Ext. Telefonica</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($extensiones as $extension)
                            <tr>
                                <td> <a class="btn-link" href="{{ route('gestion-inventarios.personal.show',$extension->id_personal) }}">{{ $extension->nombre }}</a> </td>
                                <td>{{ $extension->extension }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
