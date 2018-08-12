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
                        <center><h3>COMPROBANTE DE PAGO - TERMINO DE CONTRATO</h3></center>
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
            <td width="80%" style="padding: 15px;">{{ $arrendatario_propiedad->direccion or null }} # {{ $arrendatario_propiedad->numero or null}} Dpto {{ $arrendatario_propiedad->departamento or null}}, {{ $arrendatario_propiedad->comuna or null}}</td>
        </tr>
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Arrendatario</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $arrendatario_propiedad->nombre or null}} {{ $arrendatario_propiedad->apellido_paterno or null}}, Fono : {{ $arrendatario_propiedad->telefono or null}}, Email: {{ $arrendatario_propiedad->email or null}}</td>
        </tr>
    </table>


    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="50%" style="padding: 15px;text-align: center;border: 1px solid black"><strong>FECHA</strong><br>{{ $fecha or null }}</td>
            <td width="50%" style="padding: 15px;text-align: center;border: 1px solid black"><strong>ESTADO</strong><br>{{ $estado or null }}</td>
        </tr>
    </table>
<br>

<div style="text-align: center">

           <strong>DETALLE DE PAGOS</strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">
                            <thead>
                                <tr><th style="border: 1px solid black;text-align: center">Concepto de Pago</th>
                                    <th style="border: 1px solid black;text-align: center">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @if(isset($garantia_a->valor))
                                        <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                            Garantia
                                        </td>
                                        <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                            {{ $garantia_a->valor or null }}
                                        </td>
                                    @endif
                                </tr>
                                @foreach($cuadraturas as $p)
                                <tr>
                                    
                                    <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $p->descripcion or null }}
                                    </td>
                                    <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                        ${{ $p->valor or null }}
                                    </td>
                                  
                                   
                                </tr>
                                @endforeach
                                <tr><th style="border: 1px solid black;text-align: center">TOTAL</th>
                                    <th style="border: 1px solid black;text-align: center">${{ $totalFinal }}</th>
                                </tr>

                            </tbody>
                        </table>
<br>
           <strong>PAGOS REALIZADOS</strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">
                            <thead>
                                <tr><th style="border: 1px solid black;text-align: center">Id</th>
                                    <th style="border: 1px solid black;text-align: center">Fecha Pago</th>
                                    <th style="border: 1px solid black;text-align: center">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pagos as $pi)
                                <tr>
                                    <td height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->id_pago }}
                                    </td>
                                    <td   height="10px" style="border: 1px solid black; text-align: center" >
                                        {{ $pi->fecha }}
                                    </td>
                                    <td  height="10px" style="border: 1px solid black;text-align: center" >
                                        $ {{ $pi->monto }}
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