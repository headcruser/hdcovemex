<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">Resumen general</div>

            <div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                <!-- SOLICITUDES -->
                <div class="row">
                    <!-- PENDIENTES -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ auth()->user()->solicitudes()->pendientes()->count() }}</h3>
                                <p>Solicitudes pendientes</p>
                            </div>
                            <div class="icon">
                                <i class="far fa-clock"></i>
                            </div>
                        </div>
                    </div>

                    <!-- EN REVISION -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-gray">
                            <div class="inner">
                                <h3>{{ auth()->user()->solicitudes()->proceso()->count() }}</h3>
                                <p>Solicitudes en revision</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>

                    <!-- CANCELADAS -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ auth()->user()->solicitudes()->canceladas()->count() }}</h3>
                                <p>Solicitudes canceladas</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-window-close"></i>
                            </div>
                        </div>
                    </div>

                    <!-- FINALIZADAS -->
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ auth()->user()->solicitudes()->finalizadas()->count() }}</h3>

                                <p>Solicitudes Finalizadas</p>
                            </div>
                            <div class="icon">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
