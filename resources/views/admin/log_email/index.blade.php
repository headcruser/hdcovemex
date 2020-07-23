@extends('layouts.panel')

@section('title','Log Email')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item"> Administración </li>
    <li class="breadcrumb-item active">Log Email</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Elementos fallidos</h3>
                @permission('log_email_all_delete')
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <form class="nav-link bg-danger d-inline-block" action="{{ route('admin.log-email.masive-destroy') }}" method="POST" onsubmit="return confirm('Deseas eliminar todos los registros');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <button type="submit" class="btn btn-sm p-0 m-0 text-white" title="Eliminar">
                                        Borrar Log <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>

                            </li>
                        </ul>
                    </div>
                @endpermission
            </div>

            <div class="card-body">
                @include('admin.log_email.partials._table')
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript">
</script>
@endsection

