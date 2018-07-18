@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nuevo Servicio</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('servicio.update', $servicio->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Servicios</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Servicio</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $servicio->nombre }}" > <span class="help-block"> Identificación del Servicio </span> </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Detalle de Servicio, se traspasara a Contrato</label>
                                            <textarea name="descripcion" id="descripcion"  cols="25" rows="10" class="form-control" required="required">{{ $servicio->descripcion }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row"> 

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label></label>
                                                <div class="input-group"> 
                                                  <!--  <span class="input-group-addon">$</span>-->
                                                    <input name='valor' type="hidden" class="form-control" required="required" value="{{ $servicio->valor or 0 }}" >
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $servicio->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required')) }}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    <a href="{{ route('servicio.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

              <script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>


        <script type="text/javascript">

               if ($("#descripcion").length > 0) {
            tinymce.init({
                selector: "textarea#descripcion",
                theme: "modern",
            height: 250,
            menubar: false,
                plugins: [
                    "advlist autolink link  lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime  nonbreaking", "save table contextmenu directionality template paste textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink  | print preview fullpage | forecolor backcolor",
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });
        }
          
    </script>


      @endsection