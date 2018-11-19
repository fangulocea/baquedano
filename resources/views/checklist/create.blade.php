@extends('admin.layout')
@section('contenido')


@php 
use App\Http\Controllers\ChecklistController;
@endphp

<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('plugins/bower_components/lightbox/css/lightbox.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
<link href="{{ URL::asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')}} rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">


<div class="row">
    <div class="col-md-12">
        @if(isset($Checklist->direccion))
        <center><h3 class="box-title m-b-0">{{ $Checklist->direccion or null }} # {{ $Checklist->numero or null }} Dpto {{ $Checklist->departamento or null }}, {{ $Checklist->comuna or null }}</h3></center>
        @endif
        <br><br>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> CheckList de {{ $edr }} para {{ $tipo }}</div>
        </div>
    </div>
</div>  


<table id="listusers" class="display compact" cellspacing="0" >
<thead>
    <tr>
        <th width="40px"  style="height: 30px;">Id</th>
        <th width="250px" style="height: 30px;">ítem</th>
        <th>Acción</th>
    </tr>
</thead>
<tbody>
    @foreach($listadoCheckList as $p)
        <tr>
            <td style="height: 40px;">{{ $p->id }}</td>
            <td style="height: 40px;">{{ $p->nombre }}</td>
            
                <td width="10px" style="height: 40px;" >
                    @can('checklist.edit')
                    @if(ChecklistController::Valida_boton($id_chk,$p->id))
                        <a href="{{ route('checklist.create_detalle', [ $id_contrato, $id_chk, $tipo, $edr, $p->id, $origen ]) }}">
                            <span class="btn btn-success btn-circle "><i class="ti-check-box"></i></span>
                        </a>                    
                    @else
                        <a href="{{ route('checklist.create_detalle', [ $id_contrato, $id_chk, $tipo, $edr, $p->id, $origen ]) }}">
                            <span class="btn btn-default btn-circle "><i class="ti-control-stop"></i></span>
                        </a>
                    @endif
                    @endcan
                </td>
            
        </tr>
    @endforeach
</tbody>
</table>
<br>    
<hr>
    <div class="row">
        <div class="col-md-1">
            @if($origen == 'menu')
                <a href="{{ route('checklist.index',$origen ) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
            @else
                @if($tipo == 'Propietario')
                        <a href="{{ route('checklist.checkindex',[$id_contrato,0 , 'Propietario', $origen]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                @else
                    <a href="{{ route('checklist.checkindexarr',[$id_contrato,0 , 'Arrendatario' ,$origen ]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                @endif            
            @endif
        </div>
        <div class="col-md-2">

                    <a href="{{ route('checklist.chkmanual',[$id_contrato, $id_chk, $tipo, $edr]) }}" class="btn btn-success" style="color:white"><i class="ti-pencil-alt"></i>&nbsp;&nbsp;Crear CheckList Manual</a>
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

         if ($("#descripcion1").length > 0) {
            tinymce.init({
                selector: "textarea#descripcion1",
                theme: "modern",
                height: 250,
                menubar: false,
                plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
                ],
                toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | table | styleselect formatselect fontselect fontsizeselect",
                toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | image media code | insertdatetime preview | forecolor backcolor",
                setup: function (editor) {
                    editor.on('change', function (e) {
                        editor.save();
                    });
                }
            });
        }

         if ($("#comentarios1").length > 0) {
            tinymce.init({
                selector: "textarea#comentarios1",
                theme: "modern",
                height: 250,
                menubar: false,
                plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
                ],
                toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | table | styleselect formatselect fontselect fontsizeselect",
                toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | image media code | insertdatetime preview | forecolor backcolor",
                setup: function (editor) {
                    editor.on('change', function (e) {
                        editor.save();
                    });
                }
            });
        }

</script>
@endsection

