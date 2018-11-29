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
            height: 200px; 
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
    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="33%" height="100" style="vertical-align: top;text-align: center;border: 1px solid black">BAQUEDANO 1</td>
            <td width="33%" style="vertical-align: top;text-align: center;border: 1px solid black">{{ $firma }}</td>

            <td width="33%" style="vertical-align: top;text-align: center;border: 1px solid black">BAQUEDANO 2</td>
        </tr>
    </table>
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
                        <center><h3>REVISIÓN DE GASTOS DE INMUEBLE</h3></center>
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
        <!--
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Propietario</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $persona->nombre or null}} {{ $persona->apellido_paterno or null}}, Fono : {{ $persona->telefono or null}}, Email: {{ $persona->email or null}}</td>
        </tr>
    -->
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Arrendatario</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $arrendatario->nombre or null}} {{ $arrendatario->apellido_paterno or null}}, Fono : {{ $arrendatario->telefono or null}}, Email: {{ $arrendatario->email or null}}</td>
        </tr>
    </table>



<br>

<div style="text-align: center">

           <strong>DETALLE DE REVISIONES </strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">
                                                                             
                                         <thead>
                                            <tr>
                                                 <th style="border: 1px solid black;text-align: center">ID</th>
                                                <th style="border: 1px solid black;text-align: center">Nombre de Empresa</th>
                                                <th style="border: 1px solid black;text-align: center">Detalle</th>
                                                <th style="border: 1px solid black;text-align: center">Mes</th>
                                                <th style="border: 1px solid black;text-align: center">Año</th>
                                                <th style="border: 1px solid black;text-align: center">Valor</th>
                                                <th style="border: 1px solid black;text-align: center">Fecha Vencimiento</th>
                                           </tr>
                                        </thead>
                            <tbody>
                                @foreach($detalle as $pi)
                                <tr>
                                   
                                    <td   style="border: 1px solid black; text-align: center" >
                                        {{ $pi->id }}
                                    </td>
                                    <td   style="border: 1px solid black; text-align: center" >
                                        {{ $pi->nombreempresa }}
                                    </td>
                                    <td    style="border: 1px solid black; text-align: center" >
                                        {{ $pi->detalle }}
                                    </td>
                                    <td   style="border: 1px solid black; text-align: center" >
                                        {{ $pi->mes }}
                                    </td>   
                                     <td   style="border: 1px solid black; text-align: center" >
                                        {{ $pi->anio }}
                                    </td>  
                                 <td  style="border: 1px solid black; text-align: center" >
                                        {{ $pi->monto_responsable }}
                                    </td>  
                                     <td  style="border: 1px solid black; text-align: center" >
                                        {{ $pi->fecha_vencimiento }}
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