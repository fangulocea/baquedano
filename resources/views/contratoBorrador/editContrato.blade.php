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
            <h3 class="modal-title">Actualización de Contrato</h3> </div>

            <form id="form1_e" action="{{ route('borradorContrato.editarGestion') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! csrf_field() !!}
                <input type="hidden" class="form-control" name="id_modificador" id="id_modificador_e" value="{{ Auth::user()->id }}">
                <input type="hidden" class="form-control" name="id_borrador" value="{{ $gestion->id }}" id="id_borrador_e">
                <input type="hidden" class="form-control" name="id_publicacion" value="{{ $gestion->id_publicacion }}" id="id_publicacion_e">
                <div class="modal-body">
                <div class="row">
	                <div class="col-sm-3">
		                <div class="form-group">
		                    <label class="control-label">Comision</label>
		                    <select class="form-control" id="id_comision_e" name="id_comision_m" required="required" >
		                    	<option value="">Selecione Comision</option>
		                    	@foreach($comision as $p)
									@if($gestion->id_comisiones == $p->id)
									{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
									@else
									{ <option value="{{ $p->id }}">{{ $p->nombre }}</option> }
									@endif
		                    	@endforeach   
		                    </select>
		                </div>
	                </div>

	                <div class="col-sm-3">
	                    <div class="form-group">
	                        <label class="control-label">Flexibilidad</label>
	                        <select class="form-control" id="id_flexibilidad_e" name="id_flexibilidad_m" required="required" >
	                            <option value="">Selecione Flexibilidad</option>
	                            @foreach($flexibilidad as $p)
									@if($gestion->id_flexibilidad == $p->id)
									{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
									@else
									{ <option value="{{ $p->id }}" >{{ $p->nombre }}</option> }
									@endif	                            
	                            @endforeach   
	                        </select>
	                    </div>
	                </div>
	 	
	                <div class="col-sm-3">
	                    <div class="form-group">
	                    	<label class="control-label">Contrato</label>
	                    	<select class="form-control" id="id_contrato_e" name="id_contrato_m" required="required" >
	                        	<option value="">Selecione Contrato</option>
	                        	@foreach($contrato as $p)
									@if($gestion->id_contrato == $p->id)
									{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
									@else
									{ <option value="{{ $p->id }}">{{ $p->nombre }}</option> }
									@endif	                        	
	                            	
	                        	@endforeach   
	                    	</select>
	                	</div>
	                </div>

	                <div class="col-sm-3">
	                    <div class="form-group">
	                    </div>
	                </div>
                </div>
 
                <div class="row">
                    <div class="col-sm-3">
                        <label>Fecha para Firmar</label>
                        <div class="input-group">
                        	<input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_gestion" required="required" value="{{ date('d-m-Y', strtotime($gestion->fecha_gestion)) }}"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <label>Estado</label>
                        <div class="input-group">
                        	{{ Form::select('id_estado',['0'=>'Rechazdo','1'=>'Vigente','2'=>'Correo Enviado','3'=>'Reenvío Correo'], $gestion->id_estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','required'=>'required')) }}
                        </div>
                    </div>                                            
                </div>

                <div class="form-group">
                    <label for="detalle_contacto" class="control-label">Detalle:</label>
                        <textarea class="form-control" name="detalle_revision_m" id="detalle_revision_e" cols="25" rows="10" class="form-control" required="required">{{ $gestion->detalle_revision }}</textarea>
                </div>
                                                       
                </div>
                
				<div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('borradorContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                </div>

            </form>
       </div>
       





  
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    jQuery('#datepicker-fecha_contacto1_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    daysOfWeekDisabled: "0",
    daysOfWeekHighlighted: "0",
    language: "es",
    locale: "es",
});
</script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script src="{{ URL::asset('js/custom.js') }}"></script>
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

<script>

tinymce.init({
    selector: "textarea",
    theme: "modern",
	height: 250,
	menubar: false,
    plugins: [
        "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking", "save table contextmenu directionality template paste textcolor"
                ],
    toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink | print preview fullpage | forecolor backcolor  | mybutton",
    toolbar2: "Persona | Rut | Profesion | Teléfono | Domicilio | Depto | Comuna | Región",
    toolbar3: "Propiedad | DireccionProp | DeptoProp | RolProp | ComunaProp | DormitorioProp | BanoProp | ValorArriendo ",
       toolbar4: "Comisiones | Flexibilidad | Servicio | FormasDePago | Multas",

	setup: function (editor) 
	{
    	editor.addButton('Comisiones', 
    	{   text: '{Comisiones}',
     		icon: false,
     		onclick: function () 
     		{ editor.insertContent('{Comisiones}'); }
     	});

        editor.addButton('Flexibilidad', 
        {   text: '{Flexibilidad}',
            icon: false,
            onclick: function () 
        	{ editor.insertContent('{Flexibilidad}'); }
        });

        editor.addButton('Servicio', 
            {   text: '{Servicio}',
                icon: false,
                onclick: function () 
       		{ editor.insertContent('{Servicio}'); }
        });

        editor.addButton('FormasDePago', 
            {   text: '{FormasDePago}',
                icon: false,
                onclick: function () 
        	{ editor.insertContent('{FormasDePago}'); }
        });

        editor.addButton('Multas', 
            {   text: '{Multas}',
                icon: false,
                onclick: function () 
        	{ editor.insertContent('{Multas}'); }
        });

//Personas
         editor.addButton('Persona', 
         {   text: '{persona}',
             icon: false,
             onclick: function () 
             { editor.insertContent('{persona}'); }
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
        {   text: '{domicilioPersona}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{domicilioPersona}'); }
        });

        editor.addButton('Depto', 
        {   text: '{deptoPersona}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{deptoPersona}'); }
        });

        editor.addButton('Comuna', 
        {   text: '{comunaPersona}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{comunaPersona}'); }
        });

        editor.addButton('Región', 
        {   text: '{regionPersona}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{regionPersona}'); }
        });
                    
//propiedad                
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
        
        editor.addButton('diaFirma', 
        {   text: '{diaFirma}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{diaFirma}'); }
        });
        
        editor.addButton('mesFirma', 
        {   text: '{mesFirma}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{mesFirma}'); }
        });
        
        editor.addButton('anioFirma', 
        {   text: '{anioFirma}',
            icon: false,
            onclick: function () 
            { editor.insertContent('{anioFirma}'); }
        });
        
    }
});

</script>
@endsection