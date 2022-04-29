@extends('layouts.panel')

@section('title','Generador Codigo Barras')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"> <a href="{{ route('home') }}">
            <i class="fas fa-home"></i> Herramientas </a>
        </li>
        <li class="breadcrumb-item active">Codigo de Barras</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Genera Tu codigo de barras</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('herramientas.barcode.index') }}">
                                <div class="form-group">
                                    <label>Datos</label>
                                    <textarea name="code" class="form-control" rows="1"  placeholder="Codigo de barras" style="margin-top: 0px; margin-bottom: 0px; height:100px;" minlength="7"></textarea>
                                </div>
                                <div class="pt-2">
                                    <button type="submit" class="btn btn-primary btn-block">Generar</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 ">
                            <div class="row justify-content-center">
                                <div id="barcode-container" style="width:310px;padding:10px;border: 1px solid #000" class="text-center">
                                    {!! DNS1D::getBarcodeHTML(request('code','ABC-123'), 'C39',2,88,'black',false) !!}
                                    <label class="text-center">{{ request('code','ABC-123') }}</label>
                                </div>
                            </div>
                            <div class="row pt-3 justify-content-center">
                                <a href="{{ route('herramientas.barcode.download',['barcode' => request('code','ABC-123') ]) }}" class="btn btn-danger btn-block">Descargar</a>
                            </div>
                            {{-- <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG('0000165', 'C39',2,88,[0,0,0],true) }}" alt="barcode"/> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
    </script>
@endpush

