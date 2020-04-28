<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10"></th>
                        <th>ID </th>
                        <th>NOMBRE</th>
                        <th>ALIAS</th>
                        <th>COLOR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $key => $model)
                        <tr data-entry-id="{{ $model->id }}">
                            <td></td>
                            <td>
                                {{ $model->id }}
                            </td>
                            <td>
                                {{ $model->name }}
                            </td>
                            <td>
                                {{ $model->display_name }}
                            </td>
                            <td style="background-color:{{ $model->color ?? '#FFFFFF' }}"></td>

                            <td class="py-0 align-middle text-center">
                                <div class="btn-group btn-group-sm">
                                    @permission('status_show')
                                        <a class="btn btn-sm btn-primary" href="{{ route('config.estatus.show', $model->id) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission

                                    @permission('status_edit')
                                        <a class="btn btn-sm btn-info" href="{{ route('config.estatus.edit', $model->id) }}" title="Editar">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    @endpermission

                                    @permission('status_delete')
                                        <form class="btn btn-xs btn-danger" action="{{ route('config.estatus.destroy', $model->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-sm p-0 m-0 text-white" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    @endpermission
                                </div>
                            </td>

                        </tr>
                    @endforeach
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
