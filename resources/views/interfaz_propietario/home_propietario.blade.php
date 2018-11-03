
@extends('admin.propietario')


@section('contenido')


<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box" >

                <div class="row" style="padding: 10px">
                    <div class="col-sm-12" style="background-color: #FFFAFA">
                        <div style="background-color: #FFFAFA">
                            <div class="row row-in">
                                <a href="{{ route('mostrar_documentos_propietario') }}">
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
                            <a href="{{ route('pagos_pendientes_propietario') }}">
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
                            <a href="{{ route('datos_propiedad_propietario') }}">
                                <div class="col-lg-4 col-sm-6  b-0">
                                    <center>
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-primary"><i class="ti-clipboard"></i></span>
                                        </li>
                                        <li class="col-last">
                                           
                                        </li>
                                        <li class="col-middle">
                                            <button class="fcbtn btn btn-outline btn-primary btn-1c"> <h4>Información Propiedad<br> Propietario</h4> </button>
                                            
 
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
                            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                                <select class="form-control pull-right row b-none">

                                </select>
                            </div>
                            <h3 class="box-title">LIQUIDACIÓN MENSUAL</h3>
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




                            <div class="row" style="background-color: #F0FFF0;" >

                                <div class="col-md-6 col-sm-6 col-xs-6" >
                                    <h2>Mes Actual</h2>
                                    <p>ESTADO</p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                    <h1 class="text-right text-info m-t-20">$3,690</h1>
                                </div>
                            </div>
                            <div class="table-responsive">
                                   <div id="tabla" >
                            <div class="white-box">
                                <div class="form-body">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="tablearea">


                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-6 col-sm-12" style="padding-left: 30px">
                    <div class="row" style="background-color: #F8F8FF;">
                         <h3 class="box-title">CHECK IN DE LA PROPIEDAD</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Elite admin</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="background-color: #E0FFFF">
                         <h3 class="box-title">AUTORIZACIONES POST ATENCIÓN</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Elite admin</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="txt-oflo">Real Homes WP Theme</td>
                                            <td><span class="label label-info label-rouded">EXTENDED</span></td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">$1250</span></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
</div>
<hr>
                 <div class="row"  >
                            <div class="panel" >
                            <div class="panel-heading">DATOS PARA TRANSFERENCIAS</div>
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
                        <div class="row">
                            <div class="panel">
                            <div class="panel-heading">CONTACTOS BAQUEDANO</div>
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
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>  

<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script>

 $("#id_contrato").change(function (event) {
        if(event.target.value!=""){
                $("#meses").empty();
                var meses = ["","Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];
                $.get("/home/propietario/consultameses/" + event.target.value + "", function (response, state) {
                    $("#meses").append("<option value=''>Seleccione Mes</option>");
                    for (i = 0; i < response.length; i++) {
                        $("#meses").append("<option value='" +  response[i].mes + "/" +  response[i].anio  + "'>" +  meses[response[i].mes]  + "/" +  response[i].anio + "</option>");
                    }
                });
            }else{
                $("#meses").empty();
            }

 });


$("#meses").change(function (event) {

        if($("#id_contrato").val()==''){

            return false;

        }

        $.get("/home/propietario/consultapagos/" + $("#id_contrato").val() + "/" + event.target.value ,function(response,state){
                        var meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

                        document.getElementById("tablearea").innerHTML="";
                        if(response.length>0){
                            var tablearea = document.getElementById('tablearea'),
                                tbl = document.createElement('table');

                            tbl.className='table';
                            tbl.style.border="1px solid black";
                            tbl.style.padding="10px";
                            tbl.style.marginTop="50px";

                            var header = tbl.createTHead();
           

                            var rowheader = header.insertRow(0);
                            var fecha_iniciocontrato=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                            var meses_contrato=response[0].meses_contrato;
                           
                                    //HEAD
                                    var head_fecha=fecha_iniciocontrato;
                                  
                                        head_fecha.setDate(1);
                                        var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Tipo de Pago';
                                        rowheader.appendChild(cell);

                                     for (var r = 0; r < meses_contrato+1; r++) {
                                        var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";

                                         cell.innerHTML = '<b>'+meses[head_fecha.getMonth()]+"/"+head_fecha.getFullYear()+'</b>';

                                        head_fecha.setMonth(head_fecha.getMonth()+1);
                                        rowheader.appendChild(cell);

                                     }
                                     tbl.appendChild(rowheader);

                                    // LINEAS
                                    for (var r = 0; r < 50; r++) 
                                    {
                                        var row = document.createElement("tr");
                                        var newArray = response.filter(function (el) {
                                              return el.idtipopago==r;
                                            });

                                        
                                     // CONTENIDO
                                         if(newArray.length>0)
                                         {
                                               var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(newArray[0].tipopago);
                                                    cell.appendChild(cellText);
                                                    cell.style.border="1px solid black";
                                                    cell.style.padding="8px"
                                                    row.appendChild(cell);
                                                 if(newArray[0].idtipopago==6){
                                                            var cell = document.createElement("td");
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
                                                 }
                                                $subtotal=0;
                                                 var fecha_inicio=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                                                            fecha_inicio.setDate(1);
                                                 for (var c = 0; c < meses_contrato+1; c++) 
                                                 {


                                                    if (!$.isEmptyObject(newArray[c])) 
                                                    {
                                                            var newArray2 = response.filter(function (el) {
                                                                  return el.idtipopago==newArray[c].idtipopago && el.mes==fecha_inicio.getMonth()+1 && el.anio==fecha_inicio.getFullYear();
                                                                });


                                                                 
                                                            if (!$.isEmptyObject(newArray2)) 
                                                            {

                                                                    var total_precio_en_moneda = 0;
                                                                    for (var i = 0; i < newArray2.length; i++) {total_precio_en_moneda += newArray2[i].precio_en_moneda;

                                                                    }
                                                                    
                                                                    var idtp=newArray2.idtipopago;
                                                                    $subtotal+=newArray2[0].precio_en_moneda;
                                                                    var a = document.createElement("button");
                                                                    var linkText = document.createTextNode(total_precio_en_moneda);
                                                                    a.appendChild(linkText);
                                                                    if(newArray2[0].E_S=='e'){
                                                                        a.className="btn btn-block btn-outline btn-success";
                                                                    }else{
                                                                        if(newArray2[0].idtipopago==11){
                                                                            a.className="btn btn-block btn-outline btn-info";
                                                                        }else{
                                                                           a.className="btn btn-block btn-outline btn-danger"; 
                                                                        }
                                                                        
                                                                    }
                                                                    if(newArray2[0].idtipopago==20 || newArray2[0].idtipopago==21 || newArray2[0].idtipopago==34 || newArray2[0].idtipopago==35 )
                                                                        a.className="btn btn-block btn-outline btn-default";
                                                                    var id=newArray2[0].id;
                                                                    a.id=id;
                                                                    if(newArray2[0].idtipopago!=20 && newArray2[0].idtipopago!=21  && newArray2[0].idtipopago!=34 && newArray2[0].idtipopago!=35 && newArray2[0].idtipopago!=11)
                                                                    a.addEventListener('click', function(){
                                                                            mostrar_modal(this);
                                                                        });
                                                                    var cell = document.createElement("td");
                                                                    cell.appendChild(a);
                                                                    cell.style.border="1px solid black";
                                                                    cell.style.padding="8px"
                                                                    cell.style.textAlign="center"
                                                                    row.appendChild(cell);
                                                                }else{
                                                                    var a = document.createElement("button");
                                                                    a.className="btn btn-block btn-outline btn-default";
                                                                    var linkText = document.createTextNode(0);
                                                                    a.appendChild(linkText);
                                                                    var cell = document.createElement("td");
                                                                    cell.appendChild(a);
                                                                    cell.style.border="1px solid black";
                                                                    cell.style.padding="8px"
                                                                    cell.style.textAlign="center"
                                                                    row.appendChild(cell);
                                                                }
                                                            
                                                    }
                                                    
                                                        
                                                  fecha_inicio.setMonth(fecha_inicio.getMonth()+1);  
                                                }           
                                                           
                                                tbl.appendChild(row); // AGREGA EL PAGO
                                        }
                                    }
                                
                                 tablearea.appendChild(tbl);
                        }
                
            });


    });
</script>
@endsection
