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
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">

            
                <div class="row">
                    <div class="col-md-12">
                        <center><h3>CHECKLIST MANUAL {{ strtoupper($tipo) }}</h3></center>
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
            <td width="80%" style="padding: 15px;">{{ $Checklist->direccion or null }} # {{ $Checklist->numero or null}} , {{ $Checklist->comuna or null}}</td>
        </tr>
        <tr>
            <td width="20%" style="padding: 15px;"><strong>{{ $tipo }}</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $Checklist->nombre or null}} {{ $Checklist->apellido_paterno or null}}, Fono : {{ $Checklist->telefono or null}}, Email: {{ $Checklist->email or null}}</td>
        </tr>
    </table>


    <table class="display nowrap" cellspacing="0" width="100%">
        <tr>
            <td width="20%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>CHECKLIST</strong><br></td>
            <td width="80%" style="padding: 5px;text-align: center;border: 1px solid black"><strong>COMENTARIOS</strong><br> </td>
        </tr>
        @php
            $contador = 1;
        @endphp
        @foreach($listadoCheckList as $pi)
            <tr>
                <td width="20%" style="padding: 5px;text-align: left;border: 1px solid black">
                    <table style="border: 1px">
                      <tr>
                        <td width="10px">{{ $contador }}</td>
                        <td width="20px">{{ $pi->nombre }}</td>
                        <td width="10px"><input class="form-check-input position-static" type="checkbox"></td>
                      </tr>
                    </table>
                      
                </td>
                <td width="80%" style="padding: 5px;text-align: center;border: 1px solid black"><br> </td>
            </tr>
            @php
            $contador ++;
            @endphp
        @endforeach
    </table>
<br>


</div>


                
            </div>
        </div>
    </div>
</main>