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
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión Contrato Borrador</span></a></li>
                    </ul>
                </nav>


            <form id="form1_a" action="{{ route('contratoBorrador.crearBorrador') }}" method="post">                 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}"">
                <input type="hidden" name="id_publicacion" value="{{ $borrador->id_publicacion }}">
                             {!! csrf_field() !!}     
                   <div class="row">
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Comisiones</label>
                                        <select class="form-control" name="id_comisiones" required="required" >
                                            <option value="">Selecione comision</option>
                                            @foreach($comision as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select>
                                        {{-- <label class="control-label">Notaria</label>
                                        <select class="form-control" name="id_notaria" required="required" >
                                            <option value="">Selecione Notaria</option>
                                            @foreach($notaria as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Flexibilidad</label>
                                        <select class="form-control" name="id_flexibilidad" required="required" >
                                            <option value="">Selecione Flexibilidad</option>
                                            @foreach($flexibilidad as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select>
                                        {{-- <label class="control-label">Servicio</label>
                                        <select class="form-control" name="id_servicios" required="required" >
                                            <option value="">Selecione Servicio</option>
                                            @foreach($servicio as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <label>Fecha</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <label>Crar Borrador</label>
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                </div>
                    </div>
            </form>

                            <div class="content-wrap">
                    <section id="section-iconbox-5_c">

                            <br/><br/>
                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Comisión</th>
                        <th>Flexibilidad</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Correo</th>
                        <th>Ver Pdf</th>
                    </tr>
                </thead>
                <tbody>
                            @foreach($borradoresIndex as $p)
                                    <tr>
                                {{-- <td style="background: #ff7676; color:white">{{ $p->id_publicacion }}</td> --}}
                                <td>{{ $p->id }}</td>
                                <td >{{ $p->fecha }}</td>
                                <td>{{ $p->n_c }}</td>
                                <td>{{ $p->n_f }}</td>
                                <td>{{ trans_choice('mensajes.borrador', $p->id_estado) }}</td>
                                @can('revisioncomercial.edit')
                                    <td>
                                        <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                                    </td>
                                @endcan
                                @can('contratoBorrador.mail')
                                    <td>
                                        <a href="{{ route('contratoBorrador.mail', $p->id) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti ti-email"></i></span></a>
                                    </td>
                                @endcan
                                   <td>
                                        <a href="{{asset('uploads/pdf/'.$p->nombre)}}"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                    </td>
                            </tr>
                            @endforeach

                            <!-- MODAL GESTION UPDATE -->
                                    <div id="modal-contacto_edit_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice sssu información de contacto</h4> </div>


                                                 <form id="form1_e" action="{{ route('contratoBorrador.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_modificador" id="id_modificador_e" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_borrador" id="id_borrador_e">
                                                    <input type="hidden" class="form-control" name="id_publicacion" id="id_publicacion_e">
                                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label">Comision</label>
                                                    <select class="form-control" id="id_comision_e" name="id_comision_m" required="required" >
                                                        <option value="">Selecione Comision</option>
                                                        @foreach($comision as $p)
                                                             <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select>
                                                    {{-- <label class="control-label">Notaria</label>
                                                    <select class="form-control" id="id_notaria_e" name="id_notaria_m" required="required" >
                                                        <option value="">Selecione Servicio</option>
                                                        @foreach($notaria as $p)
                                                             <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label">Flexibilidad</label>
                                                    <select class="form-control" id="id_flexibilidad_e" name="id_flexibilidad_m" required="required" >
                                                        <option value="">Selecione Flexibilidad</option>
                                                        @foreach($flexibilidad as $p)
                                                            <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select>
                                                    {{-- <label class="control-label">Servicio</label>
                                                    <select class="form-control" id="id_servicio_e" name="id_servicios_m" required="required" >
                                                        <option value="">Selecione Servicio</option>
                                                        @foreach($servicio as $p)
                                                            <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    
                                                </div>
                                            </div>
                                        </div>
 
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <label>Fecha</label>
                                                <div class="input-group">
                                                    <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1" name="fecha_gestion_m" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <label>Estado</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="id_estado_e" name="id_estado_m" required="required" >
                                                        <option value="">Selecione Estado</option>    
                                                            <option value="1" >Vigente</option>
                                                            <option value="0" >Rechazdo</option>
                                                    </select> 
                                                </div>
                                            </div>                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                <textarea class="form-control" name="detalle_revision_m" id="detalle_revision_e" cols="25" rows="10" class="form-control" required="required"></textarea>
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
    });

        $('#modal-contacto1_c').on('shown.bs.modal', function () {
        $("#form1_c")[0].reset();
    });
    
    //     $('#modal-contacto_edit_c').on('hidden.bs.modal', function () {
    //     $("#form1_e")[0].reset();
    // });

});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })



function mostrar_modal(obj){
    var url= "{{ URL::to('contratoBorrador/borradorC')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-contacto_edit_c').modal('show');
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto1').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#id_servicio_e').val(response[0].id_servicios);
            $('#id_notaria_e').val(response[0].id_notaria);
            $('#id_comision_e').val(response[0].id_comisiones);
            $('#id_flexibilidad_e').val(response[0].id_flexibilidad);
            $('#id_estado_e').val(response[0].id_estado);
            $('#id_borrador_e').val(response[0].id);
            $('#id_publicacion_e').val(response[0].id_publicacion);
            $('#detalle_revision_e').val(response[0].detalle_revision);
            tinyMCE.activeEditor.setContent(response[0].detalle_revision);
        }
    });
}


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