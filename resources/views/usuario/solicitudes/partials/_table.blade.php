<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10">
                        </th>
                        <th>
                            FECHA
                        </th>
                        <th>
                            TITULO
                        </th>
                        <th>
                            INCIDENTE
                        </th>

                        <th>
                            ESTADO
                        </th>

                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($collection as $element)
                        <tr>
                            <td>{{ $element->id }}</td>
                            <td>{{ $element->fecha->format('d/m/Y') }}</td>
                            <td>{{ $element->titulo }}</td>
                            <td>{{ $element->incidente }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary text-sm"  style="background-color:{{ $element->status->color }}">
                                    {{ $element->status->display_name }}
                                </span>
                            </td>
                            <td>
                                @permission('solicitude_show')
                                    <a class="btn btn-sm btn-primary" href="{{ route('solicitudes.show', $element->id) }}" title="Ver">
                                        <i class="far fa-eye"></i>
                                    </a>
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


<div class="row">
    <div class="col-6">
        <span class="pagination-info">Mostrando {{$collection->currentPage()}} de {{$collection->lastPage()}} páginas de {{$collection->total()}} registros</span>
    </div>
    <div class="col-6">
        <div class="float-right">
            {{ $collection->render() }}
        </div>
    </div>
</div>
