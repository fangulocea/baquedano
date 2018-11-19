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
        @if(isset($Checklist->direccion))
        <center><h3 class="box-title m-b-0">{{ $Checklist->direccion or null }} # {{ $Checklist->numero or null }} Dpto {{ $Checklist->departamento or null }}, {{ $Checklist->comuna or null }}</h3></center>
        @endif
        <br><br>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> CheckList de {{ $edr }} para {{ $tipo }} ( {{ $NombreTipoCheckList->nombre }} )</div>
        </div>
    </div>
</div>  


<form action="{{ route('checklist.savefotos',$Checklist->id_inmueble) }}" method="post" enctype='multipart/form-data'>
    {!! csrf_field() !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id_modificador"value="{{ Auth::user()->id_persona }}">
    <input type="hidden" name="id_creador"value="{{ Auth::user()->id_persona }}">
    <input type="hidden" name="id_tipo"value="{{ $tipo }}">
    <input type="hidden" name="edr"value="{{ $edr }}">
    <input type="hidden" name="id_contrato"value="{{ $id_contrato }}">
    <input type="hidden" name="id_chk"value="{{ $id_chk }}">
    <input type="hidden" name="tipo_chk"value="{{ $tipo_chk }}">
    <input type="hidden" name="origen"value="{{ $origen }}">


    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Comentarios / Coordinaciones</label>
                    <textarea name="comentarios"  id="comentarios" cols="25" rows="10" class="form-control" required="required">{{ $NombreCheckList->comentarios or null }}</textarea>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <div class="white-box"> 
                <h3 class="box-title">Subir Imágen para: {{ $Checklist->direccion or null }}, #{{ $Checklist->numero or null }}</h3>
                <label for="input-file-now-custom-1">Imágen de CheckList</label>
                <input type="file" id="foto" name="foto"  class="dropify" />  
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
                        @foreach($imgReserva as $p)
                        <tr>
                            <td  width="10px" height="10px">
                                <center><a href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" target="_blank">BAJAR ARCHIVO<br> {{ $p->nombre }} </a></center>
                               
                                <td width="10px">
                                     @can('revisioncomercial.edit')
                                    <a href="{{ route('checklist.eliminararchivo', [$p->id,$id_contrato,$id_chk,$tipo,$edr,$tipo_chk,$origen]) }}" class="btn btn-danger btn-circle btn-lg"><i class="fa fa-check"></i></a>
                                    @endcan
                                </td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
    </div>
    <div class="form-actions">
                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>

                @if($tipo == 'Propietario')
                    <a href="{{ route('checklist.edit',[$id_contrato, $id_chk, $tipo, $edr, $origen]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                @else
                    <a href="{{ route('checklist.edit',[$id_contrato, $id_chk, $tipo, $edr, $origen]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                @endif
                
    </div>
</form>




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

