@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

 <link href="{{ URL::asset('plugins/bower_components/lightbox/css/lightbox.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<link href="{{ URL::asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')}} rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        @if(isset($inmueble->direccion))
         <center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna_nombre or null }}</h3></center>
         @endif
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                        <li id="li_4_c"><a id="4" href="#section-iconbox-4_c" class="sticon ti-camera"><span>Imágenes de la Revisión</span></a></li>
                        
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-4_c">
                     <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('revisioninmueble.savefotos',$inmueble->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h3 class="box-title">Subir imágen</h3>
                                <label for="input-file-now-custom-1">Imágenes de la captación</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Foto</button>

                            </form>
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="white-box"> 
                             <table id="ssss"  cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                         
                                                            <th><center>Click Ver Imágen</center></th>
                                                            <th>Borrar</th>
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                        @foreach($imagenes as $p)
                                                        <tr>
                                                            <td  width="10px" height="10px">
                                                               
                                                            <center><a data-lightbox="image-1" href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" ><img src="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" alt="gallery" class="all studio" width="50" height="80" /> </a></center>

                                                           
                                                            
                                                            <td width="10px">
                                                                @can('captacion.show')
                                                                <a href="{{ route('captacioncorredor.eliminarfoto', [$p->id,$p->id_capcorredor]) }}" 
                                                                   class="btn btn-danger btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                                @endcan
                                                            </td>
                                                            
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                        </div>
                    </div>

                </div>
            </section>
                    <section id="section-iconbox-5_c">
                        <!-- MODAL GESTION CREAR -->
                   <div class="row">
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-primary" data-toggle="modal" id='via_sii' data-target="#modal-contacto1_c" >Revisión SII</button>
                                    <div id="modal-contacto1_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_c" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Ingrese información de contacto</h4> </div>
                                                 <form id="form1_c" action="{{ route('captacioncorredor.crearGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_creador_gestion" id="id_creador_gestion" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_capcorredor_gestion" id="id_captacion_gestion" value="{{ $captacion->id }}">
                                                    <input type="hidden" class="form-control" name="tipo_contacto" id="tipo_contacto">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                        <div class="col-sm-5">
                                                            <label>Dirección de la información</label>
                                                              <select name="dir" id=dir class='form-control' required="required">
                                                                <option value="Información Enviada">Información Enviada</option>
                                                                <option value="Información Recibida">Información Recibida</option>
                                                                <option value="Ambas">Ambas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7">
                                                        <label>Fecha/Hora de Contacto</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" placeholder="HH:MM" required="required" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                        <div class="form-group">
                                                                <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                                <textarea class="form-control" name="detalle_contacto" id="detalle_contacto" cols="25" rows="10" class="form-control" required="required"></textarea>
                                                            </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light">Guardar</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                    </div> 
                                    <!-- FIN MODAL GESTION CREAR -->
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-info" id='via_tesoreria' data-toggle="modal" data-target="#modal-contacto1_c">Revisión Tesorería</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-success" id='via_rutificador' data-toggle="modal" data-target="#modal-contacto1_c">Revisión Rutificador</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-warning" id='via_transunion' data-toggle="modal" data-target="#modal-contacto1_c">Revisión Trans Union</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-danger" id='via_otras' data-toggle="modal" data-target="#modal-contacto1_c">Otras Revisiones</button>
                                </div>
                            </div>
                            <br/><br/>
                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Tipo Contacto</th>
                        <th>Tipo de Gestion</th>
                        <th>Creador</th>
                        <th>Fecha / Hora Gestión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gestion as $p)
                            <tr>@if($p->tipo_contacto=='SII')
                                    <td style="background: #707cd2; color:white">
                                @elseif($p->tipo_contacto=='Tesorería')
                                    <td style="background: #2cabe3; color:white">
                                @elseif($p->tipo_contacto=='Rutificador')
                                    <td style="background: #ffc36d; color:white">
                                @elseif($p->tipo_contacto=='TransUnion')
                                    <td style="background: #53e69d; color:white">
                                @elseif($p->tipo_contacto=='Otras Revisiones')
                                    <td style="background: #ff7676; color:white">
                                @else
                                    <td>
                                @endif
                                {{ $p->tipo_contacto }}</td>
                                <td>{{ $p->dir }}</td>
                                <td>{{ $p->Creador }}</td>
                                <td>{{ $p->fecha_gestion }} {{ $p->hora_gestion }}</td>
                               
                                <td width="10px">
                                     @can('revisioninmueble.edit')
                                    <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                                </div>
                                    @endcan
                                </td>
                                
                            </tr>
                            @endforeach

                            <!-- MODAL GESTION UPDATE -->
                                    <div id="modal-contacto_edit_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice su información de contacto</h4> </div>
                                                 <form action="{{ route('captacioncorredor.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_modificador_gestion" id="id_modificador_gestion" value="{{ Auth::user()->id }}">
                                                     <input type="hidden" class="form-control" name="id_gestion" id="id_gestion" >
                                                    <input type="hidden" class="form-control" name="id_capcorredor_gestion" id="id_captacion_gestion" value="{{ $captacion->id }}">
                                                    <input type="hidden" class="form-control" name="tipo_contacto" id="tipo_contacto_e">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                        <div class="col-sm-5">
                                                            <label>Dirección de la información</label>
                                                              <select name="dir" id='dir_e' class='form-control' required="required">
                                                                <option value="Información Enviada">Información Enviada</option>
                                                                <option value="Información Recibida">Información Recibida</option>
                                                                <option value="Ambas">Ambas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7">
                                                        <label>Fecha/Hora de Contacto</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_C" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto_e_c" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" placeholder="HH:MM" required="required" id="hora_gestion_e" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                        <div class="form-group">
                                                                <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                                <textarea class="form-control" name="detalle_contacto" id="detalle_contacto_e" cols="25" rows="10" class="form-control" required="required"></textarea>
                                                            </div>
                                                        
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-danger waves-effect waves-light">Guardar</button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- FIN MODAL GESTION UPDATE -->
                </tbody>
            </table>
                    </section>
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>


<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script src="{{ URL::asset('js/custom.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/lightbox/js/lightbox.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />


<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/JSZip-2.5.0/jszip.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.print.min.js') }}"></script>

<script>

$(function(){
    
    $('#modal-contacto1_C').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
    });
    
     $('#modal-contacto1_c').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
    });
});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

function mostrar_modal(obj){
    var url= "{{ URL::to('captacioncorredor/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){

            $('#modal-contacto_edit_c').modal('show');
            $('#id_gestion').val(response[0].id);
            $('#detalle_contacto_e').val(response[0].detalle_contacto);
            $('#tipo_contacto_e').val(response[0].tipo_contacto);
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto_e_c').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#hora_gestion_e').val(response[0].hora_gestion);
            $('#dir_e').val(response[0].dir);
            tinyMCE.activeEditor.setContent(response[0].detalle_contacto);
        }
});
}


$('#listusers1_c').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'excel', 'pdf', 'print'

    ],
    columnDefs: [{
            "targets": [4],
            "orderable": false
        }],
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


$("#via_sii").click(function(){
    $("#tipo_contacto").val("SII");
});
$("#via_transunion").click(function(){
    $("#tipo_contacto").val("TransUnion");
});
$("#via_tesoreria").click(function(){
    $("#tipo_contacto").val("Tesoreria");
});
$("#via_rutificador").click(function(){
    $("#tipo_contacto").val("Rutificador");
});
$("#via_otras").click(function(){
    $("#tipo_contacto").val("Otras Revisiones");
});

            tinymce.init({
                selector: "textarea",
                theme: "modern",
            height: 250,
            menubar: false,
                plugins: [
                    "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking", "save table contextmenu directionality template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink | print preview fullpage | forecolor backcolor ",
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });
        
      

$(function() {

        @if(isset($persona->id))
   
            @if(isset($persona->id_region))
            $("#p_id_provincia_c").empty();
            $("#p_id_comuna_c").empty();
            $.get("/provincias/"+{{ $persona->id_region}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $persona->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#p_id_provincia_c").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            @endif
            @if(isset($persona->id_provincia))
            $.get("/comunas/"+{{ $persona->id_provincia }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $persona->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#p_id_comuna_c").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        @endif

        @if(isset($inmueble->id))
            $("#li_1_c").removeClass("tab-current");
            $("#li_2_c").addClass("tab-current");
            $("#section-iconbox-1_c").removeClass("content-current");
            $("#section-iconbox-2_c").addClass("content-current");
            $("#i_id_provincia_c").empty();
            $("#i_id_comuna_c").empty();
            $.get("/provincias/"+{{ $inmueble->id_region}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $inmueble->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_provincia_c").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $inmueble->id_provincia }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $inmueble->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_comuna_c").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        });


jQuery(document).ready(function () {


        // delegate calls to data-toggle="lightbox"
        $(document).delegate('[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
           $(this).ekkoLightbox();

        });
        //Programatically call
        $('#open-image').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        // navigateTo
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
            event.preventDefault();
            var lb;
            return $(this).ekkoLightbox({
                onShown: function() {
                    lb = this;
                    $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                        e.preventDefault();
                        lb.navigateTo(2);
                    });
                }
            });
        });
    });



</script>
@endsection