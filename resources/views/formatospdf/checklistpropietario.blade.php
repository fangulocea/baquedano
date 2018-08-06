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
                        <center><h3>CHECKLIST PROPIETARIO</h3></center>
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
            <td width="80%" style="padding: 15px;">{{ $ChkInmueble->direccion or null }} # {{ $ChkInmueble->numero or null}} , {{ $ChkInmueble->comuna or null}}</td>
        </tr>
        <tr>
            <td width="20%" style="padding: 15px;"><strong>Propietario</strong></td>
            <td width="20%" style="padding: 15px;"> {{ $persona->nombre or null}} {{ $persona->apellido_paterno or null}}, Fono : {{ $persona->telefono or null}}, Email: {{ $persona->email or null}}</td>
        </tr>
    </table>
<br>

<div style="text-align: center">
           <strong>DETALLE CHECKLIST</strong>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">

                            <tbody>
                                <tr>
                                    <th style="border: 1px solid black;text-align: center">
                                        {{ $descripcion or null }}
                                        
                                    </th>
                                </tr>
                            </tbody>
                        </table>
<br>

<strong>FOTOS </strong>
    <table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table; margin: 0 auto;">
    <thead>
        <tr>
            <th style="border: 1px solid black;text-align: center;" colspan="2"></th>
        </tr>
    
    </thead>
    
    <tbody>
        <tr>
            @php 
                $contador = 0;
            @endphp
            @foreach($foto as $i)
                    @if($contador == 2)
                    <tr>
                        <td height="10px" style="border: 1px solid black; text-align: center" >
                            <img src="{{ $i->ruta }}/{{ $i->nombre }}" width="300" >
                        </td>

                    
                    @else
                        <td height="10px" style="border: 1px solid black; text-align: center" >
                            <img src="{{ $i->ruta }}/{{ $i->nombre }}" width="300" >
                        </td>
                    @endif

                    @if($contador == 3)
                            </tr>
                            @php 
                                $contador = 0;
                            @endphp    
                    @endif

                    @php 
                        $contador ++;
                    @endphp
            @endforeach
        </tr>
    </tbody>
</table>
<br>
<strong>Comentarios / Coordinaciones</strong>
<table id="listusers1" class="display nowrap" cellspacing="0" width="80%" style="display: table;
  margin: 0 auto;">

                            <tbody>
                                <tr>
                                    <th style="border: 1px solid black;text-align: center">
                                        {{ $comentarios or null }}
                                        
                                    </th>
                                </tr>
                            </tbody>
                        </table>

</div>


                
            </div>
        </div>
    </div>


</main>