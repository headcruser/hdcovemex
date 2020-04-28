<form method="get" action="{{ url('gestion-solicitudes') }}">
    <div class="row pb-2">
        <div class="col-6">
            <div class="form-inline form-search">
                <label class="form-label-sm"># Solicitud:</label>&nbsp;&nbsp;
                <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                    placeholder="Buscar..." autocomplete="off">
                &nbsp;&nbsp;
                <label class="form-label-sm">Estado:</label>&nbsp;
                <div class="btn-group">
                    <select name="status" id="status" class="custom-select custom-select-sm">
                        <option value="">Todos</option>
                        @foreach( $statuses as $value => $text)
                            <option value="{{ $value }}" {{ $status == $value ? ' selected' : '' }}>{{ $text }}</option>
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
                    <input type="text" class="form-control form-control-sm" name="from" id="from" placeholder="Desde" autocomplete="off">
                </div>
                <div class="input-group">
                    <input type="text" class="form-control form-control-sm" name="to" id="to" placeholder="Hasta" autocomplete="off">
                </div>
                &nbsp;
                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
        </div>
    </div>
</form>
