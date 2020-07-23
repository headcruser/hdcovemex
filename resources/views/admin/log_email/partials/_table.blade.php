<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID </th>
                        <th>OPERADOR </th>
                        <th>ASUNTO</th>
                        <th>MENSAJE DE ERROR</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collection as $key => $element)
                        <tr data-entry-id="{{ $element->id }}">
                            <td>
                                {{ $element->id }}
                            </td>
                            <td>
                                {{ $element->operador->nombre }}
                            </td>
                            <td>
                                {{ $element->subject->titulo }}
                            </td>
                            <td>
                                {{ $element->description }}
                            </td>
                            <td class="py-0 align-middle text-center">
                                <div class="btn-group btn-group-sm">
                                    @permission('log_email_show')
                                        <a class="btn btn-sm btn-primary" href="{{ route('admin.log-email.show', $element) }}" title="Ver">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endpermission


                                    @permission('log_email_delete')
                                        <form class="btn btn-sm btn-danger d-inline-block" action="{{ route('admin.log-email.destroy', $element) }}" method="POST" onsubmit="return confirm('Deseas eliminar el registro');" >
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

