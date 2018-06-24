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
                    </ul>
                </nav>
                 <div class="content-wrap">
                    <section id="section-iconbox-5_c">

			                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
			                <thead>
			                    <tr>
			                        <th>ID</th>
			                        <th>Fecha</th>
			                        <th>Estado</th>
			                        <th>Correo</th>
			                        <th>Ver Pdf</th>
			                    </tr>
			                </thead>
			                <tbody>
                            @foreach($finalIndex as $p)
                                    <tr>

                                <td>{{ $p->id }}</td>
                                <td >{{ $p->fecha }}</td>
                                <td>{{ trans_choice('mensajes.borrador', $p->id_estado) }}</td>
                                @can('borradorContrato.mail')
                                    <td>
                                        <a href="{{ route('finalContrato.mail', $p->id) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti ti-email"></i></span></a>
                                    </td>
                                @endcan
                                   <td>
                                        <a href="{{asset('uploads/pdf_final/'.$p->nombre)}}" target="_blank"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                    </td>  
                            </tr>
                            @endforeach
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
  <a href="{{ route('borradorContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
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
    


        $('#modal-updatepersona').on('hidden.bs.modal', function () {
        $("#form_persona")[0].reset();
    });


    $('#modal-updateinmueble').on('hidden.bs.modal', function () {
        $("#form_inmueble")[0].reset();
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
    var url= "{{ URL::to('borradorContrato/borradorC')}}"+"/"+obj;
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
            $('#id_contrato_e').val(response[0].id_contrato);
            $('#detalle_revision_e').val(response[0].detalle_revision);
            tinyMCE.activeEditor.setContent(response[0].detalle_revision);
        }
    });
}



function mostrar_modalpersona(obj){
    var url= "{{ URL::to('persona/contratoborrador')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-updatepersona').modal('show');
            $('#id_persona').val(response.id);
            $('#pe_rut').val(response.rut);
            $('#pe_nombre').val(response.nombre);
            $('#pe_apellido_paterno').val(response.apellido_paterno);
            $('#pe_apellido_materno').val(response.apellido_materno);
            $('#pe_direccion').val(response.direccion);
            $('#pe_numero').val(response.numero);
            $('#pe_profesion').val(response.profesion);
            $('#pe_estado_civil').val(response.estado_civil);
            $('#pe_departamento').val(response.departamento);
            $('#pe_telefono').val(response.telefono);
            $('#pe_email').val(response.email);
            $("#pe_provincia").empty();
            $("#pe_comuna").empty();
            $("#pe_region").empty();
            $.get("/regiones/todas",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].region_id==response.id_region){
                        sel=' selected="selected"';
                    }
                    $("#pe_region").append("<option value='"+response1[i].region_id+"' "+sel+">"+response1[i].region_nombre+"</option>");
                }
            });
            $.get("/provincias/"+response.id_region+"",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].provincia_id==response.id_provincia){
                        sel=' selected="selected"';
                    }
                    $("#pe_provincia").append("<option value='"+response1[i].provincia_id+"' "+sel+">"+response1[i].provincia_nombre+"</option>");
                }
            });
            $.get("/comunas/"+response.id_provincia +"",function(response2,state){
                for(i=0; i< response2.length;i++){
                    sel='';
                    if(response2[i].comuna_id==response.id_comuna){
                        sel=' selected="selected"';
                    }
                    $("#pe_comuna").append("<option value='"+response2[i].comuna_id+"' "+sel+">"+response2[i].comuna_nombre+"</option>");
                }
            });
        }
    });
}


function mostrar_modalinmueble(obj){
    var url= "{{ URL::to('inmueble/contratoborrador')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-updateinmueble').modal('show');
            $('#id_inmueble').val(response.id);
            $('#in_direccion').val(response.direccion);
            $('#in_condicion').val(response.condicion);
            $('#in_numero').val(response.numero);
            $('#in_departamento').val(response.departamento);
            $('#in_dormitorio').val(response.dormitorio);
            $('#in_rol').val(response.rol);
            $('#in_bano').val(response.bano);
            $('#in_estacionamiento').val(response.estacionamiento);
            $('#in_referencia').val(response.referencia);
            $('#in_bodega').val(response.bodega);
            $('#in_nro_bodega').val(response.nro_bodega);
            $('#in_piscina').val(response.piscina);
            $('#in_precio').val(response.precio);
            $('#in_gastosComunes').val(response.gastosComunes);
            $("#in_provincia").empty();
            $("#in_comuna").empty();
            $("#in_region").empty();
            $.get("/regiones/todas",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].region_id==response.id_region){
                        sel=' selected="selected"';
                    }
                    $("#in_region").append("<option value='"+response1[i].region_id+"' "+sel+">"+response1[i].region_nombre+"</option>");
                }
            });
            $.get("/provincias/"+response.id_region+"",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].provincia_id==response.id_provincia){
                        sel=' selected="selected"';
                    }
                    $("#in_provincia").append("<option value='"+response1[i].provincia_id+"' "+sel+">"+response1[i].provincia_nombre+"</option>");
                }
            });
            $.get("/comunas/"+response.id_provincia +"",function(response2,state){
                for(i=0; i< response2.length;i++){
                    sel='';
                    if(response2[i].comuna_id==response.id_comuna){
                        sel=' selected="selected"';
                    }
                    $("#in_comuna").append("<option value='"+response2[i].comuna_id+"' "+sel+">"+response2[i].comuna_nombre+"</option>");
                }
            });
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
                toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink | print preview fullpage | forecolor backcolor  | mybutton",
                toolbar2: "Propietario | Rut | Profesion | Teléfono | Domicilio | Depto | Comuna | Región",
                toolbar3: "Propiedad | DireccionProp | DeptoProp | RolProp | ComunaProp | DormitorioProp | BanoProp ",
            setup: function (editor) 
            {
                    editor.addButton('Propietario', 
                    {   text: '{propietario}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{propietario}'); }
                    });
                    editor.addButton('Rut', 
                    {   text: '{rut}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{rut}'); }
                    });
                    editor.addButton('Profesion', 
                    {   text: '{profesion}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{profesion}'); }
                    });
                    editor.addButton('Teléfono', 
                    {   text: '{telefono}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{telefono}'); }
                    });
                    editor.addButton('Domicilio', 
                    {   text: '{domicilioDueno}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{domicilioDueno}'); }
                    });
                    editor.addButton('Depto', 
                    {   text: '{deptoDueno}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{deptoDueno}'); }
                    });
                    editor.addButton('Comuna', 
                    {   text: '{comunaDueno}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{comunaDueno}'); }
                    });
                    editor.addButton('Región', 
                    {   text: '{regionDueno}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{regionDueno}'); }
                    });
                    
                    //propiedad

                    
                    editor.addButton('Propiedad', 
                    {   text: 'Propiedad',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent(''); }
                    });
                    editor.addButton('DireccionProp', 
                    {   text: '{direccionPropiedad}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{direccionPropiedad}'); }
                    });
                    editor.addButton('DeptoProp', 
                    {   text: '{deptoPropiedad}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{deptoPropiedad}'); }
                    });
                    editor.addButton('RolProp', 
                    {   text: '{rol}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{rol}'); }
                    });
                    editor.addButton('ComunaProp', 
                    {   text: '{comunaPropiedad}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{comunaPropiedad}'); }
                    });
                    editor.addButton('DormitorioProp', 
                    {   text: '{dormitorio}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{dormitorio}'); }
                    });
                    editor.addButton('BanoProp', 
                    {   text: '{bano}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{bano}'); }
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