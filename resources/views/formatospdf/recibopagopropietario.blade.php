 @php 

    function actual_date ()  
{  
    $week_days = array ("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");  
    $months = array ("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");  
    $year_now = date ("Y");  
    $month_now = date ("n");  
    $day_now = date ("j");  
    $week_day_now = date ("w");  
    $date = $week_days[$week_day_now] . ", " . $day_now . " de " . $months[$month_now] . " de " . $year_now;   
    return $date;    
}  

@endphp

<head>
    <style>
        /** Define the margins of your page **/
        @page {
            margin: 150px 25px;
        }

        header {
            position: fixed;
            top: -100px;
            left: 0px;
            right: 0px;
            height: 150px;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed; 
            bottom: -60px; 
            left: 0px; 
            right: 0px;
            height: 50px; 
            text-align: center;
            line-height: 30px;
        }
    </style>
</head>

<header>
    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td><img src="plugins/images/logo-Baquedano-small.png" width="140" height="100"  /></td>
            <td style="text-align: right"><h3>VENTAS - ARRIENDOS - ADMINISTRACIÓN</h3></td>
        </tr>
    </table>
    <hr>
</header>

<footer>
    <center>
            Dirección: Santa María 6350 Piso 1,  Vitacura, Santiago, Chile <br/>
        Sucursal: Av. Apoquindo 3669, piso 18, oficina 1801, Las Condes. Santiago, Chile<br/>
         Teléfonos: (+56 2) 2 9089010 / 2 32307257 / (+56 9) 58163021<br>
        info@ibaquedano.cl   www.ibaquedano.cl  
    </center>
</footer>
<main>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

            
                <div class="row">
                    <div class="col-md-12">
                        <center><h3>COMPROBANTE DE PAGO - ID PAGO NRO. {{ $pago->id }}</h3></center>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="text-align: right;">
                       Santiago, @php echo actual_date();  @endphp
                    </div>
                </div>

    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Propiedad</strong></td>
            <td width="80%" style="padding: 15px;">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null}} Dpto {{ $inmueble->departamento or null}}, {{ $inmueble->comuna_nombre or null}}</td>
        </tr>
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Propietario</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $persona->nombre or null}} {{ $persona->apellido_paterno or null}}, Fono : {{ $persona->telefono or null}}, Email: {{ $persona->email or null}}</td>
        </tr>
    </table>


    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="50%" style="padding: 15px;text-align: center;border: 1px solid black"><strong>MES</strong><br>{{ $mes }} / {{ $pago->anio }}</td>
            <td width="50%" style="padding: 15px;text-align: center;border: 1px solid black"><strong>ESTADO</strong><br> {{ trans_choice('mensajes.pagopropietario', $pago->id_estado) }}</td>
        </tr>
    </table>
<br>


        <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>VALOR ORIGINAL</strong> <br> $ <?= $pago->pago_propietario_moneda ?></td>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>MONEDA</strong><br> {{ $pago->moneda }}</td>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>VALOR UF</strong><br> {{ $uf->valor }}</td>
        </tr>
        <tr>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>VALOR EN PESOS</strong><br>{{ round($saldo_pesos)}}</td>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>VALOR PAGADO</strong><br> {{ $valor_pagado  }}</td>
            <td width="33%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>SALDO A PAGAR</strong><br> {{ $saldo_moneda }}</td>
        </tr>
    </table>
<br>

<div style="text-align: center">

           <strong>DETALLE DE PAGOS</strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">
                            <thead>
                                <tr><th style="border: 1px solid black;text-align: center">Concepto de Pago</th>
                                    <th style="border: 1px solid black;text-align: center">Valor en Moneda</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagospropietarios as $pi)
                                <tr>
                                    <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->tipopago }}
                                    </td>
                                    <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->precio_en_moneda }}
                                    </td>
                                  
                                   
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
<br>
           <strong>PAGOS REALIZADOS</strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">
                            <thead>
                                <tr><th style="border: 1px solid black;text-align: center">Fecha Pago</th>
                                    <th style="border: 1px solid black;text-align: center">Cheque</th>
                                    <th style="border: 1px solid black;text-align: center">Detalle</th>
                                    <th style="border: 1px solid black;text-align: center">Valor Pagado</th>
                                    <th style="border: 1px solid black;text-align: center">Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documentos as $pi)
                                <tr>
                                    <td height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->fecha_pago }}
                                    </td>
                                    <td   height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->numero }}
                                    </td>
                                    <td   height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->detalle }}
                                    </td>
                                    <td  height="10px" style="border: 1px solid black;text-align: center" >
                                        $ {{ number_format($pi->valor_pagado) }}
                                    </td>
                                    <td   height="10px" style="border: 1px solid black;text-align: center" >
                                        $ {{ number_format($pi->saldo) }}
                                    </td>
                                   
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
</div>


                
            </div>
        </div>
    </div>
</main>