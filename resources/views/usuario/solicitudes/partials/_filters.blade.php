<form method="get" action="{{ url('solicitudes') }}">
    <div class="row pb-2">
        <div class="col-6">
            <div class="form-inline form-search">
                <div class="form-group">
                    <label class="form-label-sm">Estado:</label>&nbsp;
                    <div class="btn-group">
                        {!! Form::select('status', $statuses , null, ['id' => 'select-status' , 'class' => 'custom-select custom-select-sm']) !!}
                    </div>
                </div>
                &nbsp;
            </div>
        </div>

        <div class="col-6 float-left text-right">
            <div class="form-inline form-dates">
                <label for="from" class="form-label-sm">Fecha</label>&nbsp;
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm datepicker" name="from" id="startdate" placeholder="Desde" autocomplete="off">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm datepicker" name="to" id="enddate" placeholder="Hasta" autocomplete="off">
                </div>
                &nbsp;
                <button type="button" id="btn-limpiar" class="btn btn-sm btn-primary"> Limpiar</button>
            </div>
        </div>
    </div>
</form>
