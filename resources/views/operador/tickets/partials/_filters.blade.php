
<div class="row pb-3">
    <div class="col-6">
        <div class="form-inline form-search">

            <label class="form-label-sm">Operador:</label>&nbsp;
            <div class="btn-group">
                <select data-filter="select" name="operator_id" id="operator_id" class="custom-select custom-select-sm">
                    <option value="">Todos</option>
                    @foreach( $operators as $key => $value)
                        <option value="{{ $key }}" {{ $userOperator == $key ? ' selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
            </div>
            &nbsp;&nbsp;

            <label class="form-label-sm">Proceso:</label>&nbsp;
            <div class="btn-group">
                <select data-filter="select" name="proceso" id="proceso" class="custom-select custom-select-sm">
                    <option value="">Todos</option>
                    @foreach($procesos as $value => $text)
                        <option value="{{ $text }}" {{ request('proceso',config('helpdesk.tickets.proceso.alias.EPS')) == $text ? ' selected' : '' }}>{{ $text }}</option>
                    @endforeach
                </select>
            </div>
            &nbsp;

        </div>
    </div>

    <div class="col-6 float-left text-right">
        <div class="form-inline form-dates">
            <label for="from" class="form-label-sm">Fecha</label>&nbsp;
            <div class="input-group">
                <input type="text" class="form-control form-control-sm datepicker" name="from" id="from" placeholder="Desde" autocomplete="off">
            </div>
            <div class="input-group">
                <input type="text" class="form-control form-control-sm datepicker" name="to" id="to" placeholder="Hasta" autocomplete="off">
            </div>
            &nbsp;
            <button type="button" id="btn-filtrar-fecha" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
        </div>
    </div>
</div>
