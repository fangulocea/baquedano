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
{{--         @if(isset($inmueble->direccion))
         <center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna_nombre or null }}</h3></center>
         @endif
          @if( isset($persona->telefono) && isset($persona->email))
        <center><h3 class="box-title m-b-0">{{ $persona->nombre or null }} {{ $persona->apellido_paterno or null }}, Fono : {{ $persona->telefono or null }}, Email: {{ $persona->email or null }}</h3></center>
        <br><br>
        @endif --}}
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li><a href="#section-iconbox-1" class="sticon ti ti-user"><span>Arrendatario</span></a></li>
                        <li><a id="4" href="#section-iconbox-4" class="sticon ti-camera"><span>Fotos</span></a></li>
                        <li><a id="5" href="#section-iconbox-5" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Nuevo Arrendatario</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('arrendatario.update',$arrendatario->id) }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <h3 class="box-title">Información del Arrendatario</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Rut</label>
                                                        <input type="text" name="p_rut" id="p_rut" class="form-control" placeholder=""  oninput='checkRut(this)' value='{{ $persona->rut or '' }}' > 
                                                    </div>
                                                </div>

                                                <div class="col-md-10">
                                                </div>
                                            </div>

                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre</label>
                                                        <input type="text" name="p_nombre" id="p_nombre"  class="form-control" placeholder="" required="required" value='{{ $persona->nombre or '' }}' > 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Paterno</label>
                                                        <input type="text" name="p_apellido_paterno" id="p_apellido_paterno" class="form-control" placeholder=""  value='{{ $persona->apellido_paterno or '' }}'> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Materno</label>
                                                        <input type="text" name="p_apellido_materno" id="p_apellido_materno" class="form-control" placeholder=""  value='{{ $persona->apellido_materno or '' }}'>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección</label>
                                                        <input name='p_direccion' id='p_direccion' type="text" class="form-control"  value="{{ $persona->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='p_numero' id='p_numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $persona->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='p_departamento' id='p_departamento' class="typeahead form-control" type="text" value="{{ $persona->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <input name='p_telefono' id='p_telefono' type="numero" class="form-control" value="{{ $persona->telefono or '' }}" > </div>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input name='p_email' id='p_email' type="email" class="form-control"  value="{{ $persona->email or '' }}" > </div>
                                                </div>

                                            </div>

                                            @if(!isset($persona->id_region))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $persona->id_region; ?>
                                            @endif
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Región</label>
                                                        {{ Form::select('p_id_region',$regiones, $idr,array('class'=>'form-control','style'=>'','id'=>'p_id_region','placeholder'=>'Selecciona región')) }}
                                                    </div>
                                                </div>

                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia</label>
                                                        {{ Form::select('p_id_provincia',[''=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'p_id_provincia')) }} </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Comuna</label>
                                                        {{ Form::select('p_id_comuna',[''=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'p_id_comuna')) }}
                                                    </div>
                                                </div>
                                            </div>
                            <!--/row-->
                            <div class="row">
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions">


                        <input type="hidden" name="idpersona" id="idpersona"value='{{ $persona->id or null}}'>
                        <input type="hidden" name="paso" value="2">
                        <input type="hidden" name="idarriendos" id="idarriendos" value='{{ $arrendatario->id }}'>
                        <input type="hidden" name="id_modificador"value="{{ Auth::user()->id_persona }}">

                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('arrendatario.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="section-iconbox-4">
                    <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('arrendatario.savefotos',$arrendatario->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h3 class="box-title">Subir imágen</h3>
                                <label for="input-file-now-custom-1">Imágenes del Arrendatario</label>
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

                                                           
                                                            @can('captacion.show')
                                                            <td width="10px">

                                                                <a href="{{ route('arrendatario.eliminarfoto', [$p->id,$p->id_arrendatario]) }}" 
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
                    <section id="section-iconbox-5">

                            <h3 class="box-title">Agendamiento Visitas</h3>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('arrendatario.update',$arrendatario->id) }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <h3 class="box-title">Información de Agendamiento</h3>
                                            <hr>
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre Contacto</label>
                                                        <input type="text" name="c_nombre" id="c_nombre"  class="form-control" placeholder="" required="required" value='{{ $citas->nombre or '' }}' > 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Teléfono Contacto</label>
                                                        <input name='c_telefono' id='c_telefono' type="numero" class="form-control" value="{{ $citas->telefono or '' }}" > </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email Contacto</label>
                                                        <input name='c_email' id='c_email' type="email" class="form-control"  value="{{ $citas->email or '' }}" > </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección Contacto</label>
                                                        <input name='c_direccion' id='c_direccion' type="text" class="form-control"  value="{{ $citas->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='c_numero' id='c_numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $citas->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='c_departamento' id='c_departamento' class="typeahead form-control" type="text" value="{{ $citas->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>
                                           
                                            <hr>
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre Captador</label>
                                                        <input type="text" name="cc_nombre" id="c_nombre"  class="form-control" placeholder="" required="required" value='{{ $citas->nombre_c or '' }}' > 
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Teléfono Captador</label>
                                                        <input name='cc_telefono' id='c_telefono' type="numero" class="form-control" value="{{ $citas->telefono_c or '' }}" > </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Email Captador</label>
                                                        <input name='cc_email' id='c_email' type="email" class="form-control"  value="{{ $citas->email_c or '' }}" > </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Fecha Visita</label>
                                                        <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" value="{{ $citas->fecha or '' }}" id="datepicker-fecha_contacto1" name="fecha"  required="required"><span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado</label>
                                                        @if(!isset($citas->id_estado))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $citas->id_estado; ?>
                                                        @endif
                                                        {{ Form::select('id_estado',['0'=>'Cancelado','1'=>'Pendiente','2'=>'Re Agendado','3'=>'Realizada'], $idr,array('class'=>'form-control','style'=>'','id'=>'id_estado','placeholder'=>'Seleccione estado','required'=>'required')) }}
                                                    </div>
                                                </div>
                                                
                                            </div>


                            <!--/row-->
                            <div class="row">
                                <!--/span-->
                            </div>

                        </div>
                        <div class="form-actions">

                        <input type="hidden" name="paso" value="3">
                        <input type="hidden" name="idarriendos" id="idarriendos" value='{{ $arrendatario->id }}'>
                        <input type="hidden" name="id_modificador"value="{{ Auth::user()->id_persona }}">

                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('arrendatario.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                        </div>
                                    </form>
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
    
    $('#modal-contacto1').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
    });
    
     $('#modal-contacto1').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
    });
});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })




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
            $("#p_id_provincia").empty();
            $("#p_id_comuna").empty();
            $.get("/provincias/"+{{ $persona->id_region}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $persona->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#p_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
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
                    $("#p_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
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