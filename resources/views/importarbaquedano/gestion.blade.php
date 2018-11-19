@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<link href="{{ URL::asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')}} rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">


<div class="row">
    <div class="col-md-12">
<div class="white-box">
        <center><h3 class="box-title m-b-0">{{ $inmueble->direccion }} # {{ $inmueble->numero }} Dpto {{ $inmueble->departamento }}, {{ $inmueble->comuna_nombre }}</h3></center>
        <center><h3 class="box-title m-b-0">{{ $persona->nombre }} {{ $persona->apellido_paterno }}, Fono : {{ $persona->telefono }}, Email: {{ $persona->email }}</h3></center>
        <br><br>
        <div class="col-lg-2 col-sm-3 col-xs-12">
            <button class="btn btn-block btn-info" id='via_correo' data-toggle="modal" data-target="#modal-contacto1">Vía Correo</button>
        </div>
        <div class="col-lg-2 col-sm-3 col-xs-12">
                <button class="btn btn-block btn-primary" data-toggle="modal" id='via_portal' data-target="#modal-contacto1" >Vía Portal</button>
            </div>
        <div class="col-lg-2 col-sm-3 col-xs-12">
            <button class="btn btn-block btn-success" id='via_fono' data-toggle="modal" data-target="#modal-contacto1">Vía Teléfonico/WSP</button>
        </div>
        <div class="col-lg-2 col-sm-3 col-xs-12">
            <button class="btn btn-block btn-warning" id='via_presencial' data-toggle="modal" data-target="#modal-contacto1">Vía presencial</button>
        </div>
        <div class="col-lg-2 col-sm-3 col-xs-12">
            <button class="btn btn-block btn-danger" id='via_otras' data-toggle="modal" data-target="#modal-contacto1">Otras Gestiones</button>
        </div>
        <br><br>
        <br/><br/>
        <table id="listusers1" class="display nowrap" cellspacing="0" width="100%">
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
                <tr>@if($p->tipo_contacto=='Portal')
                    <td style="background: #707cd2; color:white">
                        @elseif($p->tipo_contacto=='Correo Eléctronico')
                    <td style="background: #2cabe3; color:white">
                        @elseif($p->tipo_contacto=='Presencial')
                    <td style="background: #ffc36d; color:white">
                        @elseif($p->tipo_contacto=='Teléfono/WhatsApp')
                    <td style="background: #53e69d; color:white">
                        @elseif($p->tipo_contacto=='Otras Gestiones')
                    <td style="background: #ff7676; color:white">
                        @else
                    <td>
                        @endif
                        {{ $p->tipo_contacto }}</td>
                    <td>{{ $p->dir }}</td>
                    <td>{{ $p->Creador }}</td>
                    <td>{{ $p->fecha_gestion }} {{ $p->hora_gestion }}</td>
                    
                    <td width="10px">
                        @can('captacion.edit')
                        <div class="col-lg-2 col-sm-3 col-xs-12">
                            <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                        </div>
                        @endcan
                    </td>
                    
                </tr>
                @endforeach

            </tbody>
        </table>
<a href="{{ route('captacion.volver_proceso',$id) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
</div>

    </div>  
</div>

<!-- MODAL GESTION CREAR -->
<div id="modal-contacto1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Ingrese información de contacto</h4> </div>
            <form id="form1" name="form1" action="{{ route('captacion.crearGestion_proceso') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="id_creador_gestion" id="id_creador_gestion" value="{{ Auth::user()->id }}">
                <input type="hidden" class="form-control" name="id_captacion_gestion" id="id_captacion_gestion" value="{{ $id }}">
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
                                <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
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
<!-- MODAL GESTION UPDATE -->
<div id="modal-contacto_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Actualice su información de contacto</h4> </div>
            <form action="{{ route('captacion.editarGestion_proceso') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="id_modificador_gestion" id="id_modificador_gestion" value="{{ Auth::user()->id }}">
                <input type="hidden" class="form-control" name="id_gestion" id="id_gestion" >
                <input type="hidden" class="form-control" name="id_captacion_gestion" id="id_captacion_gestion" value="{{ $id }}">
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
                                <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto_e" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
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

<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script src="{{ URL::asset('js/custom.js') }}"></script>

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
    
    $('#modal-contacto1').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
    });
    
     $('#modal-contacto1').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
    });
});


function mostrar_modal(obj){
    var url= "{{ URL::to('captacion/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){

            $('#modal-contacto_edit').modal('show');
            $('#id_gestion').val(response[0].id);
            $('#detalle_contacto_e').val(response[0].detalle_contacto);
            $('#tipo_contacto_e').val(response[0].tipo_contacto);
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto_e').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#hora_gestion_e').val(response[0].hora_gestion);
            $('#dir_e').val(response[0].dir);
            tinyMCE.activeEditor.setContent(response[0].detalle_contacto);
        }
});
}


$('#listusers1').DataTable({
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


$("#via_portal").click(function(){
    $("#tipo_contacto").val("Portal");
});
$("#via_correo").click(function(){
    $("#tipo_contacto").val("Correo Eléctronico");
});
$("#via_fono").click(function(){
    $("#tipo_contacto").val("Teléfono/WhatsApp");
});
$("#via_presencial").click(function(){
    $("#tipo_contacto").val("Presencial");
});
$("#via_otras").click(function(){
    $("#tipo_contacto").val("Otras Gestiones");
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
        
      




</script>
@endsection