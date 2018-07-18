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
            <h3 class="modal-title">Actualización de Contrato</h3> 
    </div>

<form action="{{ route('cbararrendatario.editarGestion') }}" id="form1_e" method="post">
    <input name="_token" type="hidden" value="{{ csrf_token() }}">
        {!! csrf_field() !!}
        <input class="form-control" id="id_modificador_e" name="id_modificador" type="hidden" value="{{ Auth::user()->id }}">
            <input class="form-control" id="id_borrador_e" value="{{ $gestion->id }}" name="id_borrador" type="hidden">
                <input class="form-control" id="id_arrendtario_e" value="{{ $gestion->id_arrendtario }}" name="id_arrendtario" type="hidden">
                    <input id="id_cap_arr_e" name="id_cap_arr" value="{{ $gestion->id_cap_arr }}" type="hidden">
                        <div class="modal-body">
                            <div class="row">
                              <!--  <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Comisiones
                                        </label>
                                        <select class="form-control" id="id_comision_e" name="id_comision" required="required" >
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
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Flexibilidad
                                        </label>
	                        <select class="form-control" id="id_flexibilidad_e" name="id_flexibilidad" required="required" >
	                            <option value="">Selecione Flexibilidad</option>
	                            @foreach($flexibilidad as $p)
									@if($gestion->id_flexibilidad == $p->id)
									{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
									@else
									{ <option value="{{ $p->id }}" >{{ $p->nombre }}</option> }
									@endif	                            
	                            @endforeach   
	                        </select>>
                                    </div>
                                </div>-->
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Servicio
                                        </label>
                                        <select class="form-control" id="id_servicios_e" name="id_servicios" required="required">
                                            <option value="">
                                                Selecione Servicio
                                            </option>
                                            @foreach($servicio as $p)
                                           @if($gestion->id_servicios == $p->id)
												{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
												@else
												{ <option value="{{ $p->id }}" >{{ $p->nombre }}</option> }
												@endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <label>
                                        Fecha Contrato
                                    </label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_contrato" required="required" value="{{ date('d-m-Y', strtotime($gestion->fecha_contrato)) }}"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                    </div>
                                </div>
<!--
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Formas de Pago
                                        </label>
                                        <select class="form-control" id="id_formadepago_e" name="id_formadepago" required="required">
                                            <option value="">
                                                Selecione Forma de Pago
                                            </option>
                                            @foreach($formasdepago as $p)
                                           @if($gestion->id_formadepago == $p->id)
												{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
												@else
												{ <option value="{{ $p->id }}" >{{ $p->nombre }}</option> }
												@endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>-->
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Multas
                                        </label>
                                        <select class="form-control" id="id_multa_e" name="id_multa" required="required">
                                            <option value="">
                                                Selecione Multas
                                            </option>
                                            @foreach($multa as $p)
                                           @if($gestion->id_multa == $p->id)
												{ <option value="{{ $p->id }}" selected="">{{ $p->nombre }}</option> }
												@else
												{ <option value="{{ $p->id }}" >{{ $p->nombre }}</option> }
												@endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Contrato
                                        </label>
                                        <select class="form-control" id="id_contrato_e" name="id_contrato" required="required">
                                            <option value="">
                                                Selecione Contrato
                                            </option>
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
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">
                                            Día de Pago
                                        </label>
											{{ Form::select('dia_pago',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10'], $gestion->dia_pago ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona Día','required'=>'required')) }}
                                    </div>
                                </div>

                                <div  class="col-lg-3 col-sm-3 col-xs-12">
                                    <label class="control-label">
                                                Propuesta
                                            </label>
                                            <select class="form-control" name="id_simulacion" required="required">
                                                <option value="">
                                                    Selecione Propuesta
                                                </option>
                                                @foreach($propuestas as $p)
                                                    @if($gestion->id_simulacion == $p->id)
                                                    { <option value="{{ $p->id }}" selected="">{{ $p->id }} - {{ $p->tipopropuesta }}</option> }
                                                    @else
                                                    { <option value="{{ $p->id }}">{{ $p->id }} - {{ $p->tipopropuesta }}</option> }
                                                    @endif   
                                                @endforeach 
                                            </select>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <label>
                                        Valor Arriendo
                                    </label>
                                    <input class="form-control" value="{{ $gestion->valorarriendo }}" id="valorarriendo_e" name="valorarriendo" required="required" type="number">
                                    </input>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                    <label>
                                        Estado
                                    </label>
                                    <div class="input-group">
										{{ Form::select('id_estado',['0'=>'Rechazdo','1'=>'Vigente','2'=>'Correo Enviado','3'=>'Reenvío Correo','4'=>'Contrato Proceso Firma'], $gestion->id_estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','required'=>'required')) }}

                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                </div>
                                <div class="col-lg-3 col-sm-3 col-xs-12">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="detalle_contacto">
                                    Detalle:
                                </label>
                                <textarea class="form-control" cols="25" id="detalle_e" name="detalle" required="required" rows="10">{{ $gestion->detalle }}
                                </textarea>
                            </div>
                        </div>
				<div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('cbararrendatario.edit',[$gestion->id_cap_arr,3]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                </div>
                    </input>
                </input>
            </input>
        </input>
    </input>
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
       toolbar4: "Comisiones | Flexibilidad | Servicio | FormasDePago | Multas | Cheques",

	setup: function (editor) 
	{

        editor.addButton('Cheques', 
                    {   text: '{Cheques}',
                        icon: false,
                        onclick: function () 
                        { editor.insertContent('{Cheques}'); }
                    });

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