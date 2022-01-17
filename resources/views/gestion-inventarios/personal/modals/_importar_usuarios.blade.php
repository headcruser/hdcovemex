<div class="onboarding-modal modal fade animated" id="modal-importar-personal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Importar Personal</b></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            {!! Form::open(['id' => 'form-importar-personal', 'route' => 'gestion-inventarios.personal.importar', 'method' => 'POST', 'accept-charset'=>'UTF-8','enctype'=>'multipart/form-data']) !!}
                <div class="modal-body">
                    <p>Adjunta el archivo de importación Masiva con el siguiente formato</p>
                    <p><code>Nota:</code> Las clumnas de sucursal deben existir para poder vincularlas, en caso contrario las dejará vacias</p>

                    <table class="table table-bordered table-sm">
                        <tbody>
                            <tr class="text-center">
                                <td>nombre</td>
                                <td>id_impresion</td>
                                <td>sucursal</td>
                                <td>departamento</td>
                            </tr>
                        </tbody>
                    </table>

                    <div id="errores-importar-personal"></div>

                    <input class="dropify"
                        type="file"
                        name="personal"
                        data-allowed-file-extensions="xlsx xls"
                        data-max-file-size-preview="2M"
                        accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                        required>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary dim float-right" type="submit"><i class="fas fa-upload"></i> Importar</button>
                </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>
