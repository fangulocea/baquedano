@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Editar Contrato</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('contrato.update', $contrato->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información del Contrato</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Contrato</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $contrato->nombre }}" > <span class="help-block"> Identificación del Contrato </span> </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Detalle del Contrato</label>
                                            <textarea name="descripcion" id="descripcion"  cols="25" rows="10" class="form-control" required="required">{{ $contrato->descripcion }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row"> 

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $contrato->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required')) }}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    <a href="{{ route('contrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
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
        }
          
    </script>


      @endsection