<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
        <thead>
            <tr>
                <th width="10"></th>
                <th>ID </th>
                <th>ATRIBUTO</th>
                <th>NOMBRE</th>
                <th>ACCIONES</th>
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
                        {{ $model->attribute }}
                    </td>
                    <td>
                        {{ $model->value }}
                    </td>

                    <td>
                        {{-- @can('attribute_show') --}}
                            <a class="btn btn-sm btn-primary" href="{{ route('config.atributos.show', $model->id) }}" title="Ver">
                                <i class="far fa-eye"></i>
                                {{-- {{ trans('global.view') }} --}}
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('attribute_edit') --}}
                            <a class="btn btn-sm btn-info" href="{{ route('config.atributos.edit', $model->id) }}" title="Editar">
                                {{-- {{ trans('global.edit') }} --}}
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('attribute_delete') --}}
                            <form action="{{ route('config.atributos.destroy', $model->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        {{-- @endcan --}}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
