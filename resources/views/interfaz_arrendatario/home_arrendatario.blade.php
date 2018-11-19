
@extends('admin.arrendatario')


@section('contenido')

<link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">
<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box" >

                <div class="row" style="padding: 10px">
                    <div class="col-sm-12" style="background-color: #FFFAFA">
                        <div style="background-color: #FFFAFA">
                            <div class="row row-in">
                                <a href="{{ route('mostrar_documentos_arrendatario') }}">
                                <div class="col-lg-4 col-sm-6 row-in-br">
                                    <center>
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-success"><i class="ti-clipboard"></i></span>
                                        </li>
                                        <li class="col-last">

                                        </li>
                                        <li class="col-middle">
                                           <button class="fcbtn btn btn-outline btn-success btn-1c"> <h4 >Contrato Digitalizado</h4> </button>
                                            
                                        </li>
                                    </center>
                                    </ul>
                                </div>
                            </a>
                            <a href="{{ route('pagos_pendientes_arrendatario') }}">
                                <div class="col-lg-4 col-sm-6 row-in-br">
                                    <center>
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-info"><i class="fa fa-dollar"></i></span>
                                        </li>
                                        <li class="col-last">
        
                                        </li>
                                        <li class="col-middle">
                                            <button class="fcbtn btn btn-outline btn-info btn-1c"> <h4>Detalle de Pagos</h4> </button>
                                            
                                       
                                        </li>
                                    </ul>
                                </center>
                                </div>
                            </a>
                            <a href="{{ route('datos_propiedad_arrendatario') }}">
                                <div class="col-lg-4 col-sm-6  b-0">
                                    <center>
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-warning"><i class="ti-clipboard"></i></span>
                                        </li>
                                        <li class="col-last">
                                           
                                        </li>
                                        <li class="col-middle">
                                            <button class="fcbtn btn btn-outline btn-warning btn-1c"> <h4>Información Propiedad<br> Arrendatario</h4> </button>
                                            
 
                                        </li>
                                    </ul>
                                </center>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                        <hr>
<div class="row" style="padding: 10px">
<div class="col-md-12 col-lg-6 col-sm-12" style="padding-right: 30px; border-right: 1px solid #F0FFF0;">
                        <div style="background-color: #F0FFF0;" >
                            <div class="alert alert-primary">LIQUIDACIÓN MENSUAL</div>
                            
                            <div class="row">
                                    <div class="col-md-6">
                                            <label for="input-file-now-custom-1">Contrato</label>
                                            <input type="hidden" name="tab" value="3">
                                            <select class="form-control" name="id_contrato" id="id_contrato"  required="required" >
                                                <option value="0">Selecione Contrato</option>
                                                @foreach($contratos as $n)
                                                @if($n->id_estado>1)
                                                <option value="{{ $n->id_contrato }}">Contrato #{{ $n->id_contrato }} - {{ $n->alias }} </option>
                                                @endif
                                                @endforeach  
                                            </select>
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <label for="input-file-now-custom-1">Mes</label>
                                            <select class="form-control" name="meses" id="meses"  required="required" >
                                                <option value="">Seleccione Contrato</option>
                                            </select>
                                        </div>
                            </div>





                            <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="tablearea">


                                            </div>
                                        </div>

                                    </div>
                        </div>
                                                <hr>
          <div class="row"  >
                            <div class="panel" >
                            <div class="panel-heading">
                                <div class="alert alert-primary"> DATOS PARA TRANSFERENCIAS</div></div>
                            <div class="table-compact" >
                                <table class="table table-hover manage-u-table" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>BANCO</th>
                                            <th>NÚMERO DE CUENTA</th>
                                            <th>RUT</th>
                                            <th>EMAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td>BANCO ESTADO</td>
                                            <td>444444444
                                                </td>
                                            <td>44444-4</td>

                                            <td>
                                                contacto@ibaquedano.cl
                                            </td>
                                        </tr>

                                       
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-6 col-sm-12" style="padding-left: 30px">
                    <div class="row" style="background-color: #F8F8FF;">
                        <div class="alert alert-primary"> CHECK IN DE LA PROPIEDAD</div>
                         
                         <h4 class="text-center text-info m-t-20">* Para su tranquilad, debe subir Fotos de su propiedad a mas tardar 5 días de firmar su contrato </h4>
                            <div class="table-responsive">
                                <table id="listusers" class="table display compact" cellspacing="0" >

                <thead>
                    <tr>
                        
                        <th>Id Contrato</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publica as $p)

                            <tr>
                                
                                <td>{{ $p->id_contrato }} </td>
                                <td>{{ $p->direccion }} {{$p->numero }} {{$p->departamento }}</td>
                                <td>{{ $p->comuna }}</td>
                                <td>
                                    @if($p->id_estado==1)
                                    <span class="label label-danger label-rouded">Pendiente</span>
                                    @elseif($p->id_estado==3)
                                    <span class="label label-warning label-rouded">Pendiente Actualizando</span>
                                    @else
                                    <span class="label label-success label-rouded">Realizado</span>
                                    @endif
                                    </td>
                                <td width="10px">
                                    <a href="{{ route('arrendatario.checkin', $p->id_contrato)}}" class="btn btn-info" style="color:white"><i class="ti-pencil-alt"></i>&nbsp;&nbsp;Check-In</a>
                                </td>
                            </tr>


                    @endforeach

                </tbody>
            </table>
                            </div>
                        </div>
<hr>
                        <div class="row" style="background-color: #F8F8FF;">
                        <div class="alert alert-primary"> Revisión Cuentas Básicas de la Propiedad</div>
                         
                         <h4 class="text-center text-info m-t-20">* Esta información se irá actualizando periódicamente </h4>
                            <div class="table-responsive">
                                <table id="listusers" class="table display compact" cellspacing="0" >

                <thead>
                    <tr>
                        
                        
                        <th>Dirección</th>
                        <th>Fecha Revisión</th>
                        <th>Estado</th>
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($cuentas as $p)

                            <tr>
                                
                               
                                <td>{{ $p->calle }} {{$p->numero }} {{$p->departamento }} {{$p->comuna }}</td>
                                <td>{{ $p->fecha_revision }}</td>
                                <td>{{ $p->EstadoCuenta  }}    </td>
                                                              
                            </tr>


                    @endforeach

                </tbody>
            </table>
                            </div>
                        </div>

                    </div>
                    
</div>
<hr>
                 
                        <div class="row">
                            <div class="panel">
                            <div class="panel-heading">
                                <div class="alert alert-primary"> CONTACTOS BAQUEDANO</div></div>
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;" class="text-center">#</th>
                                            <th>NOMBRE</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>EMAIL</th>
                                            <th>TELÉFONO</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="text-center">1</td>
                                            <td><span class="font-medium">Neila Chavez</span>
                                                <br/><span class="text-muted">Ejecutiva Administración</span></td>
                                            <td>Departamento de Administración
                                                </td>
                                            <td>neila@ibaquedano.cl</td>

                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 2 323 07 257
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td><span class="font-medium">Ejectivos Post Atención</span>
                                                <br/><span class="text-muted">Post Venta</span></td>
                                            <td>Departamento Post Atención
                                                </td>
                                            <td>postventa@ibaquedano.cl</td>

                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 9 581 63 021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td> <span class="font-medium">Javier Faria A.</span>
                                                <br/><span class="text-muted">Agente Inmobiliario</span></td>
                                            <td>Departamento Contact Center
                                                </td>
                                            <td>javier@ibaquedano.cl
                                                </td>
                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 9 525 42 709
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

   <div class="row" style="background-color: #f4f4f4">
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/inv.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>INVERSIONES</strong></h3>
                            <p>Compra y venta de terrenos, desarrollos inmobiliarios.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/inversiones-baquedano" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/broker.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>BROKER</strong></h3>
                            <p>Compra y venta de <br>inmuebles.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-broker" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/imr.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>RENTAS</strong></h3>
                            <p>Arriendo Garantizado de departamentos.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-rentas" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/im1.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>PROPIEDADES</strong></h3>
                            <p>Compra y venta de <br>inmuebles.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-propiedades" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                        <input type="hidden" id="uf">
                        <input type="hidden" id="fecha">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>  

<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>


<script>
    $.get("/home/arrendatario/uf/",function(response,state){
                                $("#uf").val(response.valor);
                                $("#fecha").val(response.fecha);
                             });


$(function() {

 


 $("#id_contrato").change(function (event) {
        if(event.target.value!=""){
                $("#meses").empty();
                var meses = ["","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
                $.get("/home/arrendatario/consultameses/" + event.target.value + "", function (response, state) {
                    $("#meses").append("<option value=''>Seleccione Mes</option>");
                    for (i = 0; i < response.length; i++) {
                        $("#meses").append("<option value='" +  response[i].mes + "/" +  response[i].anio  + "'>" +  meses[response[i].mes]  + "/" +  response[i].anio + "</option>");
                    }
                });
            }else{
                $("#meses").empty();
            }

 });

@if(count($pagos_actual)>0)

    
    var text = '<?php echo $pagos_actual[0]->mes.'/'.$pagos_actual[0]->anio; ?>';
    tabla({{ $pagos_actual[0]->id_contratofinal or 0 }}, text );
    $('#id_contrato option[value="{{ $pagos_actual[0]->id_contratofinal or 0 }}"]').prop('selected', true);
                $("#meses").empty();
                var meses = ["","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
                $.get("/home/arrendatario/consultameses/" +{{ $pagos_actual[0]->id_contratofinal or 0 }} + "", function (response, state) {
                    $("#meses").append("<option value=''>Seleccione Mes</option>");
                    for (i = 0; i < response.length; i++) {
                        $("#meses").append("<option value='" +  response[i].mes + "/" +  response[i].anio  + "' >" +  meses[response[i].mes]  + "/" +  response[i].anio + "</option>");
                    }
                    $('#meses option[value="'+text+'"]').prop('selected', true);
     });
                
    

@endif


$("#meses").change(function (event) {

    tabla($("#id_contrato").val() , event.target.value );
        
});





function tabla(id,txt){

    if(id ==''){

            return false;

        }

        $.get("/home/arrendatario/consultapagos/" + id + "/" + txt,function(response,state){
                   
                        var meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

                        document.getElementById("tablearea").innerHTML="";
                        if(response.length>0){
                            var tablearea = document.getElementById('tablearea'),
                                tbl = document.createElement('table');

                            tbl.className='table table-hover manage-u-table';
                            

                            
                             
                            var header = tbl.createTHead();
           

                            var rowheader = header.insertRow(0);
                            var fecha_iniciocontrato=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                            var meses_contrato=response[0].meses_contrato;
                           
                                    //HEAD
                                    var head_fecha=fecha_iniciocontrato;
                                  
                                        head_fecha.setDate(1);
                                        var cell = document.createElement("th");
                                        cell.innerHTML = 'Tipo de Pago';
                                        rowheader.appendChild(cell);

                                        var cell = document.createElement("th");
                                        cell.className='txt-oflo';
                                        cell.innerHTML = 'Moneda';
                                        rowheader.appendChild(cell);

                                        var cell = document.createElement("th");
                                        cell.className='txt-oflo';
                                        cell.innerHTML = 'Valor en Moneda';
                                        rowheader.appendChild(cell);

                                        var cell = document.createElement("th");
                                        cell.className='txt-oflo';
                                        cell.innerHTML = 'Subtotal Pesos';
                                        rowheader.appendChild(cell);

                                     tbl.appendChild(rowheader);
                                     var fields = txt.split('/');
                                     var mes = fields[0];
                                     var anio = fields[1];


                                    // LINEAS
                                    for (var r = 0; r < 100; r++) 
                                    {
                                        
                                        var newArray = response.filter(function (el) {
                                              return el.idtipopago==r && el.mes==mes && el.anio==anio;
                                            });



                                        
                                     // CONTENIDO
                                         if(newArray.length>0)
                                         {


                                            var row = document.createElement("tr");
                                               var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(newArray[0].tipopago);
                                                    cell.appendChild(cellText);
                                                    cell.className='txt-oflo';
                                                    row.appendChild(cell);
                                                $subtotal=0;
                                                var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(newArray[0].moneda);
                                                    cell.appendChild(cellText);
                                                    cell.className='txt-oflo';
                                                    row.appendChild(cell);

                                                var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(newArray[0].precio_en_moneda);
                                                    cell.appendChild(cellText);
                                                    cell.className='txt-oflo';
                                                    row.appendChild(cell);


                                                if(newArray[0].moneda=='UF'){
                                                    subtotal= newArray[0].precio_en_moneda * $("#uf").val();
                                                }else{
                                                   subtotal= newArray[0].precio_en_moneda *1;
                                                }

                                                 subtotal=Math.round(subtotal);

                                                var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(Math.ceil(subtotal));
                                                    cell.appendChild(cellText);
                                                    if(newArray[0].idtipopago==35 || newArray[0].idtipopago==21 ){
                                                        cell.style="font-weight: bold;";
                                                    }
                                                    cell.className='txt-oflo';
                                                    row.appendChild(cell);

                                            if(newArray[0].idtipopago==35 || newArray[0].idtipopago==21 ){
                                                div_pago = document.createElement('div');
                                                div_pago.className='text-center text-info m-t-20';
                                                h1_pago = document.createElement('h1');
                                                br_pago = document.createElement('br');
                                                
                                                h1_pago.appendChild(document.createTextNode("Saldo a Depositar : $ " + subtotal));
                                                div_pago.appendChild(h1_pago);
                                                div_pago.appendChild(br_pago);


                                               
                                                div_uf = document.createElement('div');
                                                 h3_uf = document.createElement('h4');
                                                h3_uf.appendChild(document.createTextNode("Se utiliza el valor UF  " + $("#uf").val() + " del día " + $("#fecha").val() ));
                                                div_uf.appendChild(h3_uf);

                                                var a = document.createElement("button");
                                                            var linkText1 = document.createTextNode("Descargar Comrpobante");
                                                            a.className=" btn btn-success  btn-lg";
                                                            a.id=newArray[0].id_pm;
                                                            a.addEventListener('click', function(){
                                                                    comprobante(this);
                                                                });
                                                            a.appendChild(linkText1);
                                                            a.style="font-size:small"
                                                            var div_boton = document.createElement("div");
                                                            div_boton.appendChild(a);

                                                div_pago.appendChild(div_boton);
                                                div_pago.appendChild(h1_pago); 
                                                div_pago.appendChild(div_uf); 


                                            }
                                                tbl.appendChild(row); // AGREGA EL PAGO
                                                }           
                                                           
                                                
                                        }
                                    
                                tablearea.appendChild(div_pago);
                                tablearea.appendChild(br_pago);
                                 tablearea.appendChild(tbl);

                        }
                
            });

}

function comprobante(obj){
    window.location.href = '/home/arrendatario/comprobantedepago/'+obj.id;
}
});
</script>
@endsection
