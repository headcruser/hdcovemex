<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-User">
        <thead>
            <tr>
                <th width="10"></th>
                <th>ID </th>
                <th>NOMBRE</th>
                <th>ACCIONES    </th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $key => $user)
                <tr data-entry-id="{{ $user->id }}">
                    <td></td>
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>
                        {{ $user->nombre }}
                    </td>

                    <td>
                        {{-- @can('user_show') --}}
                            <a class="btn btn-xs btn-primary" href="{{ route('admin.roles.show', $user->id) }}" title="Ver">
                                <i class="far fa-eye"></i>
                                {{-- {{ trans('global.view') }} --}}
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('user_edit') --}}
                            <a class="btn btn-xs btn-info" href="{{ route('admin.roles.edit', $user->id) }}" title="Editar">
                                {{-- {{ trans('global.edit') }} --}}
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('user_delete') --}}
                            <form action="{{ route('admin.roles.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" style="display: inline-block;">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        {{-- @endcan --}}

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
