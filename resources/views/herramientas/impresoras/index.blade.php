@extends('layouts.panel')

@section('title','Reporte Impresoras')

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"> <a href="{{ route('home') }}">
        <i class="fas fa-home"></i> Herramientas </a>
    </li>
    <li class="breadcrumb-item active">Impresoras</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Genera Reporte de impresoras</h3>
                @if(session('tb_printer'))
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                      <div class="input-group-append">
                        <button id="btn-report" type="button" class="btn btn-primary" title="Imprimir">Imprimir Reporte</button>
                        <a class="btn btn-default" href="{{ route('herramientas.impresoras.index') }}">Regresar</a>
                      </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        @if (!session('tb_printer'))
                            <form class="form" action="{{ route('herramientas.impresoras.calcular') }}" method="POST">
                                @csrf
                                <div class="form-group @error('info') has-error @enderror">
                                    <label>Ingresa la informacion de la impresora</label>
                                    <textarea id="info" class="form-control" name="info" cols="30" rows="15" required title="Información Impresiones">{{ old('info','') }}</textarea>
                                    <div class="help-block with-errors">
                                        @error('info')
                                            <span>{{ $errors->first('info') }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <input class="btn btn-primary" type="submit" value="Generar">
                            </form>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (session('tb_printer'))
                            {!! session('tb_printer') !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')

    @if(session('tb_printer'))
        <script src="{{ mix('js/vendor/table-html/table-html.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                const d = document;
                const date = new Date().toLocaleDateString().replaceAll('/','-');
                const filename = `reporte_impresiones_${date}.xls`;

                const dom = {
                    btn_report: $('#btn-report'),
                    tb_report: $("#tbImpr"),
                };

                d.addEventListener('click',function(e) {
                    if (e.target === dom.btn_report[0]) {
                        dom.tb_report.table2excel({
                            filename: filename
                        });
                    }
                });
            });
        </script>
    @endif
@endsection

