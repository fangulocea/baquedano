@extends('admin.layout')

@section('contenido')

<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<div class="row">
    <div class="col-md-12"> 
        @if(isset($borrador->direccion))
         <center><h3 class="box-title m-b-0">{{ $borrador->direccion or null }}</h3></center>
         @endif
          @if( isset($borrador->propietario) )
        <center><h3 class="box-title m-b-0">{{ $borrador->propietario or null }} </h3></center>
        <br><br>
        @endif
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión Contrato Final</span></a></li>
                        <li id="li_6_c"><a id="6" href="#section-iconbox-6_c" class="sticon ti-agenda"><span>Documentos de Contrato Inicial</span></a></li>
                        <li id="li_7_c"><a id="7" href="#section-iconbox-7_c" class="sticon ti-agenda"><span>Generación de Pagos</span></a></li>
                        <li id="li_8_c"><a id="8" href="#section-iconbox-8_c" class="sticon ti-money"><span>Pagos Mensuales</span></a></li>
                        <li id="li_9_c"><a id="8" href="#section-iconbox-9_c" class="sticon ti-money"><span>Gestionar Pago</span></a></li>

                    </ul>
                </nav>
                 <div class="content-wrap">
                    <section id="section-iconbox-5_c">

			                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
			                <thead>
			                    <tr>
			                        <th>ID</th>
			                        <th>Estado</th>
			                        <th>Ver Pdf</th>
                                    <th>Alias</th>
                                    <th>Notaria</th>
                                    <th>Fecha Firma</th>
                                    <th>Guardar</th>
                                    <th>Eliminar</th>
			                    </tr>
			                </thead>
			                <tbody>
                            @foreach($finalIndex as $p)
                                    <tr>
                        <form id="form1_a" action="{{ route('finalContrato.asignarNotaria',$p->id) }}" method="post">                 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_modificador" value="{{ Auth::user()->id }}"">
                            <input type="hidden" name="id_publicacion" value="{{ $p->id_publicacion }}"">
                            <input type="hidden" name="id_borrador" value="{{ $p->id_borrador }}"">
                            <input type="hidden" name="id_pdf" value="{{ $p->id_pdf }}"">
                            @if($p->id_estado>1)
                                <?php $flag=1; ?>
                            @endif

                             
                                <td>{{ $p->id }}</td>
                                <td>{{ trans_choice('mensajes.contratofinal', $p->id_estado) }}</td>
                                   <td>
                                        <a href="{{asset('uploads/pdf_final/'.$p->nombre)}}" target="_blank"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                    </td>  
                                    <td>
                                    <input type="text" name="alias" id="alias" value='{{ $p->alias }}' class="form-control" required="required">
                                </td>
                                <td>
                                        <select class="form-control" name="id_notaria" required="required" >
                                            <option value="">Selecione Notaria</option>
                                            @foreach($notaria as $n)
                                                @if($n->id==$p->id_notaria)
                                                    <option value="{{ $n->id }}" selected>{{ $n->nombre }} </option>
                                                @else
                                                    <option value="{{ $n->id }}">{{ $n->nombre }} </option>
                                                @endif
                                            @endforeach   
                                        </select> 
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="fecha_firma" id="fecha_firma" value='{{ $p->fecha }}' required="required">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                </td>
                                <td>
                                    <a href="{{ route('finalContrato.destroy',[$p->id,$p->id_pdf]) }}"> <button type="button" class="btn btn-danger"> <i class="fa fa-check"></i> Eliminar</button></a>
                                </td>
                            </form>
                            </tr>
                            @endforeach
                             
                </tbody>
            </table>
            <input type="hidden" name="verifica_estado" id="verifica_estado" value="{{ $flag }}">
                    </section>
<section id="section-iconbox-6_c">
     <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('finalContrato.savedocs',$borrador->id_publicacion) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="tab" value="2">
                                <h3 class="box-title">Subir Archivo</h3>
                                <label for="input-file-now-custom-1">Contratos</label>
                                        <select class="form-control" name="id_final" required="required" >
                                            <option value="">Selecione ID Contrato</option>
                                            @foreach($finalIndex as $n)
                                                    @if($n->id_estado>1)
                                                    <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                                    @endif
                                            @endforeach  
                                        </select>
                                <label for="input-file-now-custom-1">Tipo Documento</label>
                                        <select class="form-control" name="tipo" required="required" >
                                                    <option value="">Selecione Tipo de Documento</option>
                                                    <option value="Contrato Digitalizado">Contrato Digitalizado </option>
                                                    <option value="Gastos Notario">Gastos Notario </option>
                                                    <option value="Documentos Garantías">Documentos Garantías </option>
                                                    <option value="Comprobantes de Pagos">Comprobantes de Pagos </option>
                                                    <option value="Otros Documentos">Otros Documentos </option>
                                        </select>
                                <label for="input-file-now-custom-1">Archivo del contrato</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                <input type="hidden" id="id_publicacion" name="id_publicacion" value="{{ $borrador->id_publicacion }}"  /> 
                                <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Archivo</button>

                            </form>
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="white-box"> 
                             <table id="ssss"  cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                         
                                                            <th><center>Click Ver Documento</center></th>
                                                            <th>Borrar</th>
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                        @foreach($documentos as $pi)
                                                        <tr>
                                                            <td  width="10px" height="10px">
                                                               
                                                            <center><a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO<br> {{ $pi->nombre }} </a></center>

                                                           
                                                            @can('finalContrato.edit')
                                                            <td width="10px">

                                                                <a href="{{ route('finalContrato.eliminarfoto', $pi->id) }}" 
                                                                   class="btn btn-danger btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                            </td>
                                                            @endcan
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                        </div>
                    </div>

                </div>
            </section>

         <section id="section-iconbox-7_c">
                    <div class="panel panel-info">
                            <div class="panel-heading"> Gestión de pagos del Contrato</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('finalContrato.generarpagos',[$borrador->id_publicacion]) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3 class="box-title m-b-0">Complete Campos generales para generar pago</h3><br/>
                                                    <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Contrato</label>
                                                        <input type="hidden" name="tab" value="3">
                                                        <select class="form-control" name="id_final_pagos" id="id_final_pagos"  required="required" >
                                                            <option value="">Selecione Contrato</option>
                                                            @foreach($finalIndex as $n)
                                                                    @if($n->id_estado>1)
                                                                    <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                                                    @endif
                                                            @endforeach  
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Meses</label>
                                                        <input type="number" name="cant_meses" id="cant_meses" value="12" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Fecha Inicio Contrato</label>
                                                        <input type="date" name="fecha_firmapago" id="fecha_firmapago" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-group">
                                                        <label for="input-file-now-custom-1">Moneda</label>
                                                       <select class="form-control" name="moneda" required="required" >
                                                            <option value="CLP">CLP</option>
                                                            <option value="UF">UF</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="form-group">
                                                        <label for="input-file-now-custom-1">Valor Moneda</label>
                                                       <input name='valormoneda' id='valormoneda' type="number" class="form-control" required="required" value='1'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h3 class="box-title m-b-0">Generar pagos por Item</h3><br/>
                                             <div class="row">
                                                <div class="col-md-3"><label for="input-file-now-custom-1">Gasto Comun</label> </div>
                                                <div class="col-md-7">
                                                     
                                                  <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='gastocomun' id='gastocomun' type="number" class="form-control"   value='{{ $borrador->gastosComunes or '' }}'>
                                                        </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="input-file-now-custom-1">Canon de Arriendo</label> </div>
                                                <div class="col-md-7">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='precio' id='precio' type="number" class="form-control"   value='{{ $borrador->precio or '' }}'>
                                                        </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-3"><label for="input-file-now-custom-1">Comisión Rentas</label> </div>
                                                <div class="col-md-4">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='comision' id='comision' type="number" class="form-control"   value=''>
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="input-group"> 
                                                            <input name='mes_comision' id='mes_comision' type="number" class="form-control"   placeholder="C/Mes">
                                                        </div>
                                                </div>

                                            </div>
                                        <div class="row">
                                                <div class="col-md-3"><label for="input-file-now-custom-1">Comisión % Mensual</label> </div>
                                                <div class="col-md-4">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">%</span>
                                                            <input name='porcentaje' id='porcentaje' type="number" class="form-control"   placeholder="%">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="input-group"> 
                                                            <input name='mes_porcentaje' id='mes_porcentaje' type="number" class="form-control"   placeholder="C/Mes">
                                                        </div>
                                                </div>

                                            </div>
                                        <div class="row">
                                                <div class="col-md-3"><label for="input-file-now-custom-1">Pago por Notaría</label> </div>
                                                <div class="col-md-4">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='pagonotaria' id='pagonotaria' type="number" class="form-control"  placeholder="$">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="input-group"> 
                                                            <input name='mes_notaria' id='mes_notaria' type="number" class="form-control"   placeholder="C/Mes">
                                                        </div>
                                                </div>
  
                                            </div>
                                   <div class="row">
                                                <div class="col-md-3"><input name='nombre_otropago' id='nombre_otropago' type="text" class="form-control"   placeholder="Otro Pago"> </div>
                                                <div class="col-md-4">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='pagootro' id='pagootro' type="number" class="form-control"   placeholder="$">
                                                        </div>
                                                </div>
                                                <div class="col-md-3">
                                                        <div class="input-group"> 
                                                            <input name='mes_otro' id='mes_otro' type="number" class="form-control"   placeholder="C/Mes">
                                                        </div>
                                                </div>
 
                                            </div>
                                   <div class="row">
                                                <br>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Generar Pagos</button>
                                                </div>
 
                                            </div>
                                        </div>
                                            </div>
                                            <hr>
                                </div>
                            </form>
                            </div>
                        </div>
        </section>
        <section id="section-iconbox-8_c">

        </section>
        <section id="section-iconbox-9_c">
        </section>

                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>

    </div>
</div>
  <a href="{{ route('finalContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script>
    
            // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Esta seguro de eliminar  \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('Archivo Borrado');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
</script>


<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />


<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>



<script>



$('#listusers1_c').DataTable({
    dom: 'Bfrtip',
    buttons: [ ],
    language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "buttons": {
            "copy": 'Copiar',
            "csv": 'Exportar a CSV',
            "print": 'Imprimir'},
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});

 $("#id_final_pagos").change(function (event) {

        $.get("/contratofinal/consulta/"+this.value+"",function(response,state){
                    $("#porcentaje").val(response.comision);
                    $("#fecha_firmapago").val(response.fecha_firma);
                
            });

    });


var SweetAlert = function () {};

//examples 
SweetAlert.prototype.init = function () {

    //Basic
    $("#6").click(function (event) {
        if($("#verifica_estado").val()=="0"){
            swal("El contrato aún se encuentra en proceso de firma");
            return false;
        }

    });

    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);
 
<?php
if($tab==2){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").addClass("content-current");
           }); 
<?php
}
?>


<?php
if($tab==3){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_7_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-7_c").addClass("content-current");
           }); 
<?php
}
?>

$("#li_5_c").click(function (event) {
             $("#li_5_c").addClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
            $("#section-iconbox-5_c").addClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-7_c").removeClass("content-current");
            
});
$("#li_6_c").click(function (event) {
             $("#li_6_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
             $("#section-iconbox-6_c").addClass("content-current");
            $("#section-iconbox-5_c").removeClass("content-current");    
            $("#section-iconbox-7_c").removeClass("content-current");         
});
$("#li_7_c").click(function (event) {
             $("#li_7_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#section-iconbox-7").addClass("content-current");
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            
});
</script>
@endsection