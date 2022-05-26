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
                    {{-- @foreach($collection as $key => $model)
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

                            </td>

                        </tr>
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-6">
        <span class="pagination-info">Mostrando {{$collection->currentPage()}} de {{$collection->lastPage()}} páginas de {{$collection->total()}} registros</span>
    </div>
    <div class="col-6">
        <div class="float-right">
            {{ $collection->render() }}
        </div>
    </div>
</div> --}}
