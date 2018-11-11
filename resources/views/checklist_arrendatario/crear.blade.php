@extends('admin.layout')
@section('contenido')


<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('plugins/bower_components/lightbox/css/lightbox.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">


<div class="row">
    <div class="col-md-12">
        <center><h3 class="box-title m-b-0">{{ $contratos->direccion or null }} </h3></center>
        <br>
    </div>
</div>


<form action="{{ route('checklist.savefotos_arrendatario',$contratos->id_contrato) }}" method="post" enctype='multipart/form-data'>
    {!! csrf_field() !!}
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="id_modificador" value="{{ Auth::user()->id_persona }}">
    <input type="hidden" name="id_creador" value="{{ Auth::user()->id_persona }}">
    <input type="hidden" name="id_chk" value="{{ $checklist->id}}">
    <input type="hidden" name="id_inmueble" value="{{ $checklist->id_inmueble}}">

    <div class="row">
        <div class="col-md-6">
            <div class="white-box"> 
                <h3 class="box-title">Complete los siguientes campos</h3>
                <div class="form-group">
                    <label>Comentarios / Coordinaciones</label>
                    <input name="comentarios"  id="comentarios"  maxlength="190" class="form-control" required="required">
                </div>
                <div class="form-group">
                    <label>Tipo de Checkin</label>
                    <select name="tipo" class="form-control" required="required">
                        <option value="">Seleccione Tipo de CheckIn</option>
                        <option value="1">Recepción</option>
                        <option value="2">Revisión</option>
                        <option value="3">Devolución</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Habitación</label>
                     <select name="habitacion" class="form-control" required="required">
                        <option value="">Seleccione Habitación</option>
                        <option value="Baño en Suite">Baño en Suite</option>
                        <option value="Baño Principal">Baño Principal</option>
                        <option value="Baño Niños">Baño Niños</option>
                        <option value="Baño Visita">Baño Visita</option>
                        <option value="Living">Living</option>
                        <option value="Cocina">Cocina</option>
                        <option value="Logia">Logia</option>
                        <option value="Balcón">Balcón</option>
                        <option value="Entrada">Entrada</option>
                        <option value="Pasillo Principal">Pasillo Principal</option>
                        <option value="Pasillo Dormitorios">Pasillo Dormitorios</option>
                        <option value="Dormitorio Principal">Dormitorio Principal</option>
                        <option value="Dormitorio Mediano">Dormitorio Mediano</option>
                        <option value="Dormitorio Pequeño">Dormitorio Pequeño</option>
                        <option value="Dormitorio Servicio">Dormitorio Servicio</option>
                        <option value="Sala de Estar">Sala de Estar</option>
                    </select>
                </div>                                                                                                                                                          
            </div>
        </div>

          <div class="col-sm-6">
            <div class="white-box"> 
                <h3 class="box-title">Seleccione Imágen</h3>
                <input type="file" id="foto" name="foto"  class="dropify" />  
            </div>
        </div>
    </div>
    <div class="form-actions">
             <center>   <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button> 
                <a href="{{ route('checklist.index_arrendatario') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                <a href="{{ route('checklist.finalizar_arrendatario', $checklist->id) }}" class="btn btn-primary" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Finalizar CheckIn</a>
             </center>
    </div>
    </form>
<hr>
    <div class="row">
      


        <div class="col-sm-12">
            <div class="white-box"> 
                 <center><h3 class="box-title">Listado de Check In Realizando a la Propiedad</h3></center><br>
                <table id="ssss" class="table compact"  cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Comentarios</th>
                            <th>Tipo Checkin</th>
                            <th>Habitación</th>
                             <th>Fecha Creación</th>
                            <th>Ver Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($imagenes as $p)
                        <tr>
                            <td > {{ $p->comentarios }}</td>
                            <td >@if($p->tipo_chk==1)
                                      Recepción
                                @elseif($p->tipo_chk==2) 
                                      Revisión
                                @else
                                      Devolución
                                @endif
                                </td>
                             <td > {{ $p->habitacion }}</td>
                              <td > {{ $p->created_at }}</td>
                              
                            <td  width="10px" height="20px">
                                <center><a class="btn btn-primary" href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" target="_blank">BAJAR ARCHIVO</a></center>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> 
    </div>






<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/lightbox/js/lightbox.js') }}"></script>


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

