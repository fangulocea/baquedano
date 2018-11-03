
@extends('admin.propietario')


@section('contenido')
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<div class="responsive">
<br>
    <div class="row" >
        <div class="col-sm-12">
            <div class="white-box" >
                         <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="pagoarea">


                                            </div>
                                        </div>

                                    </div>
                        <div class="form-actions">
                                <center>
                                <a href="{{ route('home_propietario') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                </center>
                            </div>
                    </div>

        </div>
    </div>
</div>

<script>

var contratos=<?php echo json_encode($contratos);?>;

console.log(contratos.length);
document.getElementById("pagoarea").innerHTML="";
for(var i=0;i<contratos.length;i++){



                $.get("/contratofinal/consultapagosmensuales/"+contratos[i].id_contrato+"/"+contratos[i].id_inmueble,function(response,state){
                        var meses = ["", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

                        
                        if(response.length>0){
                            var tablearea = document.getElementById('pagoarea'),
                            div_contrato = document.createElement('div');
                            br = document.createElement('br');
                            tbl = document.createElement('table');
                            div_contrato.className='alert alert-primary';
                            div_contrato.appendChild(br);
                            div_contrato.appendChild(document.createTextNode("Detalle de Cuenta - Contrato Nro. " + response[0].id_contrato));
                            tbl.className='table';
                            tbl.style.border="1px solid black";
                            tbl.style.padding="10px";
                            tbl.style.marginTop="50px";

                            var header = tbl.createTHead();
                            var rowheader = header.insertRow(0);
                            var fecha_iniciocontrato=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                            var meses_contrato=response[0].meses_contrato;
                            var mes_inicio=response[0].mes;

                                    //HEAD
                                    var head_fecha=fecha_iniciocontrato;
                                        head_fecha.setDate(1);
                                    
                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Mes/Año';
                                        rowheader.appendChild(cell);

    

                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Pagar a Propietario';
                                        rowheader.appendChild(cell);


                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Estado';
                                        rowheader.appendChild(cell);

                                  

                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Comprobante';
                                        rowheader.appendChild(cell);

                                
                                     tbl.appendChild(rowheader);

                                    // LINEAS

                                    for (var r = 0; r < response.length; r++) {
                                        var row = document.createElement("tr");
                                     // CONTENIDO

                                         if(response.length>0)
                                         {
                                                                              
                                                    if (!$.isEmptyObject(response[r])) {
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode(meses[response[r].mes]+'/'+response[r].anio);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
   
 
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode("$ "+response[r].pago_propietario_moneda);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);

                                                            var estado="";
                                                            if(response[r].id_estado==1){
                                                                estado='No Pagado';
                                                            }
                                                            if(response[r].id_estado==2){
                                                                estado='Pago Parcial';
                                                            }
                                                            if(response[r].id_estado==3){
                                                                estado='Pagado';
                                                            }                    
                                                            if(response[r].id_estado==4){
                                                                estado='Vencido';
                                                            } 
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode(estado);
                                                            
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            var a = document.createElement("span");
                                                            var linkText1 = document.createTextNode(estado);
                                                            if(estado=='Pagado')
                                                            {a.className="label label-success label-rouded";}
                                                            else
                                                            {a.className="label label-danger label-rouded";}
                                                            a.appendChild(linkText1);
                                                            cell.appendChild(a);
                                                            row.appendChild(cell);

                                                         
                                                            
                                                            var a = document.createElement("button");
                                                            var linkText1 = document.createTextNode("C");
                                                            a.className="btn btn-success btn-circle btn-lg";
                                                            a.id=response[r].id;
                                                            a.addEventListener('click', function(){
                                                                    comprobante(this);
                                                                });
                                                            a.appendChild(linkText1);
                                                            a.style="font-size:small"
                                                            var cell = document.createElement("td");
                                                            cell.appendChild(a);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);

                                                            
                                                           
                                                            
                                                    }
                                                 
                                                tbl.appendChild(row); // AGREGA EL PAGO
                                        }
                                    }
                                tablearea.appendChild(div_contrato);
                                 tablearea.appendChild(tbl);
                        }
                
            });
}


function comprobante(obj){
    window.location.href = '/home/propietario/comprobantedepago/'+obj.id;
}



</script>