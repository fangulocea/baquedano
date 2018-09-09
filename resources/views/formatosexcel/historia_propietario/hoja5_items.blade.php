
 @foreach($itemsdepagos as $items)
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">
            Item de Pago
        </th>
        @php
         $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fecha_firma)) . '-' . date("m", strtotime($fecha_firma)) . '-' . 1));
        @endphp
        @for($i=0; $i<=12; $i++)
        @php
                   
                    $dia = date("d", strtotime($fecha_ini));
                    $mes = date("m", strtotime($fecha_ini));
                    $anio = date("Y", strtotime($fecha_ini));

                    $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
        @endphp
        <th style="background-color: #F2F4F4;text-align: center">
            {{ $mes }}/{{ $anio }}
        </th>
        @endfor
    </tr>
    </thead>
    <tbody>

        @for ($i = 0; $i < 50; $i++)
            @php 
                $fila=$items->where("idtipopago",'=',$i);
                 $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fecha_firma)) . '-' . date("m", strtotime($fecha_firma)) . '-' . 1));
                  $flag=0;
            @endphp
            @if(count($fila)>0)
                <tr>
                    @for($z=0; $z<=12; $z++)
                            @php
                                        $dia = date("d", strtotime($fecha_ini));
                                        $mes = date("m", strtotime($fecha_ini));
                                        $anio = date("Y", strtotime($fecha_ini));
                                        $montos=$fila->where("mes","=",$mes)->where("anio","=",$anio);
                                        $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                            @endphp
                            @if(count($montos)>0)
                             @foreach($montos as $p)
                                   @if($flag==0)
                                            <td style="background-color: #F2F4F4;text-align: center">{{  $p->tipopago }} </td>
                                            <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos or 0}}  </td>
                                            @php
                                                $flag=1;
                                            @endphp
                                     @else
                                                <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos or 0}}  </td>
                                    @endif
                                @endforeach
                            @else
                                <td style="background-color: #F2F4F4;text-align: center">0 </td>
                            @endif
                    @endfor
                </tr>
            @endif
        @endfor
    </tbody>
</table>
   @endforeach

<br><br>

 @foreach($pagosmensuales as $pagos)
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">
            PAGOS REALIZADOS
        </th>
        @php
         $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fecha_firma)) . '-' . date("m", strtotime($fecha_firma)) . '-' . 1));
        @endphp
        @for($i=0; $i<=12; $i++)
        @php
                   
                    $dia = date("d", strtotime($fecha_ini));
                    $mes = date("m", strtotime($fecha_ini));
                    $anio = date("Y", strtotime($fecha_ini));

                    $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
        @endphp
        <th style="background-color: #F2F4F4;text-align: center">
            {{ $mes }}/{{ $anio }}
        </th>
        @endfor
    </tr>
    </thead>
    <tbody>


            @php 
                 $fecha_ini = date('Y-m-j', strtotime(date("Y", strtotime($fecha_firma)) . '-' . date("m", strtotime($fecha_firma)) . '-' . 1));
                  $flag=0;
            @endphp
            @if(count($pagos)>0)
                <tr>
                    @for($z=0; $z<=12; $z++)
                            @php
                                        $dia = date("d", strtotime($fecha_ini));
                                        $mes = date("m", strtotime($fecha_ini));
                                        $anio = date("Y", strtotime($fecha_ini));
                                        $montos=$pagos->where("mes","=",$mes)->where("anio","=",$anio);
                                        $fecha_ini = date("d-m-Y", strtotime("+1 month", strtotime($fecha_ini)));
                            @endphp
                            @if(count($montos)>0)
                             @foreach($montos as $p)
                                   @if($flag==0)
                                            <td style="background-color: #F2F4F4;text-align: center">Total Pagado </td>
                                            <td style="background-color: #F2F4F4;text-align: center">{{  $p->valor_pagado or 0}}  </td>
                                            @php
                                                $flag=1;
                                            @endphp
                                     @else
                                                <td style="background-color: #F2F4F4;text-align: center">{{  $p->valor_pagado or 0}}  </td>
                                    @endif
                                @endforeach
                            @else
                                <td style="background-color: #F2F4F4;text-align: center">0 </td>
                            @endif
                    @endfor
                </tr>
            @endif

    </tbody>
</table>
   @endforeach

