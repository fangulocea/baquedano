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
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Revisiones</span></a></li>
                        <li id="li_4_c"><a id="4" href="#section-iconbox-4_c" class="sticon ti-camera"><span>Documentos de la Revisión</span></a></li>
                        
                    </ul>
                </nav>
                <div class="content-wrap">
                    
                    <section id="section-iconbox-5_c">
                        <!-- MODAL GESTION CREAR -->
                   <div class="row">
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-primary" data-toggle="modal" id='via_sii' data-target="#modal-contacto1_c" >SII</button>
                                    <div id="modal-contacto1_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_c" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Ingrese información de revisión</h4> </div>
                                                 <form id="form1_c" action="{{ route('revisioninmueble.crearGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_creador" id="id_creador" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_inmueble" id="id_inmueble" value="{{ $inmueble->id }}">
                                                    <input type="hidden" class="form-control" name="tipo_revision" id="tipo_revision">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                                  <div class="col-sm-7">
                                                        <label>Fecha/Hora de Revisión</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion"  id="hora_gestion" placeholder="HH:MM" required="required" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                        <div class="form-group">
                                                                <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                                <textarea class="form-control" name="detalle_revision" id="detalle_revision" cols="25" rows="10" class="form-control" required="required"></textarea>
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
                                    <button class="btn btn-block btn-info" id='via_tesoreria' data-toggle="modal" data-target="#modal-contacto1_c">Tesorería</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-success" id='via_rutificador' data-toggle="modal" data-target="#modal-contacto1_c">Rutificador</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-warning" id='via_transunion' data-toggle="modal" data-target="#modal-contacto1_c">Trans Union</button>
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
                        <th>Creador</th>
                        <th>Fecha / Hora Gestión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gestion as $p)
                            <tr>@if($p->tipo_revision=='SII')
                                    <td style="background: #707cd2; color:white">
                                @elseif($p->tipo_revision=='Tesoreria')
                                    <td style="background: #2cabe3; color:white">
                                @elseif($p->tipo_revision=='Rutificador')
                                    <td style="background: #ffc36d; color:white">
                                @elseif($p->tipo_revision=='TransUnion')
                                    <td style="background: #53e69d; color:white">
                                @elseif($p->tipo_revision=='Otras Revisiones')
                                    <td style="background: #ff7676; color:white">
                                @else
                                    <td>
                                @endif
                                {{ $p->tipo_revision }}</td>
                                <td>{{ $p->Creador }}</td>
                                <td>{{ $p->fecha_gestion }} {{ $p->hora_gestion }}</td>
                                @can('revisioncomercial.edit')
                                <td width="10px">
                                    <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                                </div>

                                </td>
                                @endcan
                            </tr>
                            @endforeach

                            <!-- MODAL GESTION UPDATE -->
                                    <div id="modal-contacto_edit_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice su información de contacto</h4> </div>
                                                 <form id="form1_e" action="{{ route('revisioninmueble.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_modificador" id="id_modificador_e" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_inmueble" id="id_inmueble_e" value="{{ $inmueble->id }}">
                                                     <input type="hidden" class="form-control" name="id_revisioninmueble" id="id_revisioninmueble_e" >
                                                    <input type="hidden" class="form-control" name="tipo_revision" id="tipo_revision_e">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                           <div class="col-sm-7">
                                                        <label>Fecha/Hora de Revisión</label>
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
                                                                <textarea class="form-control" name="detalle_revision" id="detalle_revision_e" cols="25" rows="10" class="form-control" required="required"></textarea>
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
                    <section id="section-iconbox-4_c">
                     <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('revisioninmueble.savefotos',$inmueble->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h3 class="box-title">Subir Archivo</h3>
                                <label for="input-file-now-custom-1">Archivos de la captación</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
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
                                                         
                                                            <th><center>Click Ver Imágen</center></th>
                                                            <th>Borrar</th>
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                        @foreach($imagenes as $p)
                                                        <tr>
                                                            <td  width="10px" height="10px">
                                                               
                                                            <center><a href="{{ URL::asset($p->ruta.'/'.$p->nombre) }} " target="_blank">BAJAR ARCHIVO<br> {{ $p->nombre }} </a></center>

                                                           
                                                            @can('revisioncomercial.edit')
                                                            <td width="10px">

                                                                <a href="{{ route('revisioninmueble.eliminarfoto', [$p->id,$inmueble->id]) }}" 
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
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>
  <a href="{{ route('revisioninmueble.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
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
    
    $('#modal-contacto1_c').on('hidden.bs.modal', function () {
        $("#form1_c")[0].reset();
 var fecha =  new Date();
 var year = fecha.getFullYear();//el año se puede quitar de este ejemplo
 var mes = fecha.getMonth();//pero ya que estamos lo ponemos completo
 var dia = fecha.getDate();
 var hora = fecha.getHours();
 var minutos = fecha.getMinutes();
 var segundos = fecha.getSeconds();
 //aquí se hace lo 'importante'
 if(mes<10){mes='0'+mes}
 if(dia<10){dia='0'+dia}
 if(hora<10){hora='0'+hora}
 if(minutos<10){minutos='0'+minutos}
 if(segundos<10){segundos='0'+segundos}

        $('#datepicker-fecha_contacto1_c').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

        $('#modal-contacto1_c').on('shown.bs.modal', function () {
        $("#form1_c")[0].reset();
 var fecha =  new Date();
 var year = fecha.getFullYear();//el año se puede quitar de este ejemplo
 var mes = fecha.getMonth();//pero ya que estamos lo ponemos completo
 var dia = fecha.getDate();
 var hora = fecha.getHours();
 var minutos = fecha.getMinutes();
 var segundos = fecha.getSeconds();
 //aquí se hace lo 'importante'
 if(mes<10){mes='0'+mes}
 if(dia<10){dia='0'+dia}
 if(hora<10){hora='0'+hora}
 if(minutos<10){minutos='0'+minutos}
 if(segundos<10){segundos='0'+segundos}


        $('#datepicker-fecha_contacto1_c').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });
    
    $('#modal-contacto_edit_c').on('hidden.bs.modal', function () {
        $("#form1_e")[0].reset();
    });

});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

function mostrar_modal(obj){
    var url= "{{ URL::to('revisioninmueble/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){

            $('#modal-contacto_edit_c').modal('show');
            $('#id_revisioninmueble_e').val(response[0].id);
            $('#detalle_revision_e').val(response[0].detalle_revision);
            $('#tipo_revision_e').val(response[0].tipo_revision);
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto_e_c').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#hora_gestion_e').val(response[0].hora_gestion);
            tinyMCE.activeEditor.setContent(response[0].detalle_revision);
        }
});
}


$('#listusers1_c').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'excel', 'pdf', 'print'

    ],
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
    $("#tipo_revision").val("SII");
});
$("#via_transunion").click(function(){
    $("#tipo_revision").val("TransUnion");
});
$("#via_tesoreria").click(function(){
    $("#tipo_revision").val("Tesoreria");
});
$("#via_rutificador").click(function(){
    $("#tipo_revision").val("Rutificador");
});
$("#via_otras").click(function(){
    $("#tipo_revision").val("Otras Revisiones");
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