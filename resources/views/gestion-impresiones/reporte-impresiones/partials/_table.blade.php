<div class="table-responsive" style="height: 70vh">
    <table id="tb-reporte-mensual" class="table table-bordered table-sm">
        <thead>
            <tr>
                <th rowspan="2" style="vertical-align: middle;" class="text-center p-3">
                    DEPARTAMENTOS
                </th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">
                    NOMBRE
                </th>
                <th rowspan="2" style="vertical-align: middle;" class="text-center">
                    ID
                </th>
                @foreach ($meses as $id => $mes)
                    <th class="text-center" colspan="3">
                        {{ $mes }}
                    </th>
                @endforeach
                <th rowspan=2>TOTAL ANUAL</th>
            </tr>

            <tr class="text-bold bg-gray-light">
                @foreach ($meses as $th => $mes)
                    <th>Negro</th>
                    <th class="text-danger">Color</th>
                    <th>Total</th>
                @endforeach
            </tr>
        </thead>



        @foreach ($personal_por_departamento as $departamento => $lista_personal)
            <tbody>
                <tr>
                    <td style="vertical-align: middle;" rowspan="{{ $lista_personal->count() + 1 }}" class="text-center bg-purple">{{ $departamento }}</td>
                </tr>

                @php
                    $total_anual = 0;
                @endphp

                @foreach ($lista_personal as $personal)
                    <tr>
                        <td class="text-nowrap">{{ $personal->nombre }}</td>
                        <td>{{ $personal->id_impresion }}</td>
                        @php
                            $total_por_personal = 0;
                        @endphp
                        @foreach ($meses as $id => $mes)
                            <td>{{ $reporte[$mes][$personal->id_impresion]['negro'] }}</td>
                            <td>{{ $reporte[$mes][$personal->id_impresion]['color'] }}</td>
                            <td>{{ $reporte[$mes][$personal->id_impresion]['total'] }}</td>
                            @php
                                $total_por_personal += $reporte[$mes][$personal->id_impresion]['total'];
                            @endphp
                        @endforeach
                        <td class="text-bold">{{ $total_por_personal }}</td>
                        @php
                            $total_anual+= $total_por_personal;
                        @endphp
                    </tr>
                @endforeach

                <tr class="text-bold bg-gray-light">
                    <th colspan="3" class="text-center">TOTAL</th>
                    @foreach ($meses as $id => $mes)
                        <td>
                            {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                return $item['departamento'] == $departamento;
                            })->sum('negro') }}
                        </td>
                        <td class="text-danger">
                            {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                return $item['departamento'] == $departamento;
                            })->sum('color') }}
                        </td>
                        <td>
                            {{ collect($reporte[$mes])->filter(function($item) use($departamento){
                                return $item['departamento'] == $departamento;
                            })->sum('total') }}
                        </td>
                    @endforeach
                    <td>
                        {{ $total_anual }}
                    </td>
                </tr>
            </tbody>
        @endforeach
    </table>
</div>
