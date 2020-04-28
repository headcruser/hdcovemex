@extends('layouts.panel')

@section('title','Solicitudes')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Inicio </a>
    </li>
    <li class="breadcrumb-item active">Gestinar Solicitudes</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Gestionar Solcicitudes</h3>
            </div>
            <div class="card-body">
                @include('operador.solicitudes.partials._filters')

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="10">
                                </th>
                                <th>
                                    TITULO
                                </th>
                                <th>
                                    FECHA
                                </th>
                                <th>
                                   AUTOR
                                </th>

                                <th>
                                    DEPARTAMENTO
                                </th>

                                <th>
                                    ESTADO
                                </th>

                                <th>
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($collection as $element)
                                <tr>
                                    <td>{{ $element->id }}</td>
                                    <td>{{ $element->titulo }}</td>
                                    <td>{{ $element->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $element->empleado->nombre }}</td>
                                    <td>{{ $element->empleado->departamento->nombre }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-primary text-sm"  style="background-color:{{ $element->status->color }}">
                                            {{ $element->status->display_name }}
                                        </span>
                                    </td>
                                    <td>
                                        @permission('solicitude_show')
                                            <a class="btn btn-sm btn-primary" href="{{ route('operador.gestion-solicitudes.show', $element->id) }}" title="Ver">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        @endpermission

                                        @permission('solicitude_edit')
                                            <a class="btn btn-sm btn-info" href="{{ route('operador.gestion-solicitudes.edit', $element->id) }}" title="Editar">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        @endpermission

                                        @permission('solicitude_delete')
                                            <form action="{{ route('operador.gestion-solicitudes.destroy', $element->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        @endpermission
                                    </td>
                                </tr>
                            @empty
                                <tr >
                                    <td colspan="7" class="text-center">No hay solicitudes</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

<script>
    const locale = {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizar",
        "daysOfWeek": [
            "Do",
            "Lu",
            "Ma",
            "Mi",
            "Ju",
            "Vi",
            "Sa"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
    }

    const from = "{{ request('from') }}",
          to = "{{ request('to') }}";

    $('#from').daterangepicker({
        singleDatePicker: true,
        startDate: (!from) ? moment().subtract(6, 'days'): from,
        locale: locale
    });

    $('#to').daterangepicker({
        singleDatePicker: true,
        locale: locale,
        startDate: (!to) ? moment(): to
    });
</script>
@endsection

