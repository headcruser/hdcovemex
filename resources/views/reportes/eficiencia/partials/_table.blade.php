<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">USUARIO</th>
            <th rowspan="2">NOMBRE</th>
            <th class="text-center" colspan="4">CONTACTO</th>
            <th rowspan="2">TOTAL FINALIZADOS</th>
            <th rowspan="2">ATENCION PERSONAL</th>
            <th rowspan="2">ATENCION REMOTA</th>
            <th rowspan="2">TIEMPO (HRS)</th>
        </tr>
        <tr>
            <th>WEB</th>
            <th>TELEFONICO</th>
            <th>EMAIL</th>
            <th>PERSONAL</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($usuarios as $usuario)
        <tr>
            <td>{{ $usuario->usuario }}</td>
            <td>{{ $usuario->nombre }}</td>
            <td class="text-center">
                {{ $usuario->tickets->filter(function($ticket){
                    return $ticket->contacto === 'Web';
                })->count() }}
            </td>
            <td class="text-center">
                {{ $usuario->tickets->filter(function($ticket){
                    return $ticket->contacto === 'Telefonico';
                })->count() }}
            </td>
            <td class="text-center">
                {{ $usuario->tickets->filter(function($ticket){
                    return $ticket->contacto === 'Email';
                })->count() }}
            </td>
            <td class="text-center">
                {{ $usuario->tickets->filter(function($ticket){
                        return $ticket->contacto === 'Personal';
                    })->count() }}
            </td>
            <td class="text-center">
                {{ $usuario->tickets->filter(function($ticket){
                    return $ticket->estado === 'Finalizado';
                })->count() }}
            </td>
            <td class="text-center">
                @if($usuario->tickets->count()> 0)
                    @php
                        $finalizadosPersonal = $usuario->tickets->filter(function($ticket){
                            return $ticket->estado === 'Finalizado' && $ticket->tipo === 'Personal';
                        })->count();

                        $finalizados = $usuario->tickets->filter(function($ticket){
                            return $ticket->estado === 'Finalizado';
                        })->count();

                    @endphp

                    {{ ($finalizados == 0)? 0: $finalizadosPersonal * 100 / $finalizados }} %
                @else
                    0 %
                @endif

            </td>
            <td class="text-center">
                @if($usuario->tickets->count()> 0)
                    @php
                        $remotoFinalizados = $usuario->tickets->filter(function($ticket){
                            return $ticket->estado === 'Finalizado' && $ticket->tipo === 'Remoto';
                        })->count();

                        $finalizados = $usuario->tickets->filter(function($ticket){
                            return $ticket->estado === 'Finalizado';
                        })->count();

                    @endphp

                    {{ ($finalizados == 0)?0: $remotoFinalizados * 100 / $finalizados }} %
                @else
                    0 %
                @endif
            </td>
            <td class="text-right">
                @if($usuario->tickets->count()> 0)
                    @php
                        $difMinutes = $usuario->tickets->sum(function($ticket){
                            return number_format($ticket->updated_at->diffInMinutes($ticket->created_at) / 60,2,'.','');
                        });
                    @endphp
                    {{ $difMinutes }}
                @else
                    0
                @endif

            </td>
        </tr>
       @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2" class="font-weight-bold">Totales</td>
            <td class="font-weight-bold text-center">
            @php
                $totalWeb = $usuarios->sum(function($usuario){
                    return $usuario->tickets->filter(function($ticket){
                        return $ticket->contacto === 'Web';
                    })->count();
                });
            @endphp
            {{ $totalWeb }}

            </td>
            <td class="font-weight-bold text-center">
            @php
                $totalTelefonico = $usuarios->sum(function($usuario){
                    return $usuario->tickets->filter(function($ticket){
                        return $ticket->contacto === 'Telefonico';
                    })->count();
                });
            @endphp
            {{ $totalTelefonico }}
            </td>
            <td class="font-weight-bold text-center">
            @php
                $totalEmail = $usuarios->sum(function($usuario){
                    return $usuario->tickets->filter(function($ticket){
                        return $ticket->contacto === 'Email';
                    })->count();
                });
            @endphp
            {{ $totalEmail }}
            </td>
            <td class="font-weight-bold text-center">
                @php
                    $totalPersonal = $usuarios->sum(function($usuario){
                        return $usuario->tickets->filter(function($ticket){
                            return $ticket->contacto === 'Personal';
                        })->count();
                    });
                @endphp
                {{ $totalPersonal }}
            </td>
            <td class="font-weight-bold text-center">
                @php
                    $totalFinalizados = $usuarios->sum(function($usuario){
                        return $usuario->tickets->filter(function($ticket){
                            return $ticket->estado === 'Finalizado';
                        })->count();
                    });
                @endphp

                {{ $totalFinalizados }}
            </td>
            <td colspan="2" class="text-right"></td>
            <td  class="text-right font-weight-bold">
                @php
                    $totalTiempo = $usuarios->sum(function($usuario){
                        return $usuario->tickets->sum(function($ticket){
                            return number_format($ticket->updated_at->diffInMinutes($ticket->created_at) / 60,2,'.','');
                        });
                    });
                @endphp
                {{ $totalTiempo }} Horas
            </td>
        </tr>
    </tfoot>
</table>
