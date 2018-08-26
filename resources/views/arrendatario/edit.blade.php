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
                        <li id="li_1" ><a href="#section-iconbox-1" class="sticon ti ti-user"><span>Arrendatario</span></a></li>
                        <li id="li_2"><a  href="#section-iconbox-2" class="sticon ti ti-alarm-clock"><span>Reserva</span></a></li>
                        <li id="li_3"><a  href="#section-iconbox-3" class="sticon ti ti-home"><span>Asignar Inmueble</span></a></li>
                        <li id="li_4"><a  href="#section-iconbox-4" class="sticon ti-camera"><span>Documentos</span></a></li>
                        <li id="li_5"><a  href="#section-iconbox-5" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Nuevo Arrendatario </div>
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
                                                        <label class="control-label">Rut / Pasaporte</label>
                                                        <input type="text" name="p_rut" id="p_rut" class="form-control" placeholder=""  value='{{ $persona->rut or '' }}' > 
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

                            <div class="row">
   
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Preferencias para el Inmueble</label>
                                        <input name='preferencias' type="text" class="form-control" maxlength="190" value="{{ $arrendatario->preferencias or '' }}"> </div>
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
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado</label>
                                                        <input type="hidden" name="id_modificador" 
                                                               value="{{ Auth::user()->id_persona }}">

                                                        @if(!isset($arrendatario->id_estado))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $arrendatario->id_estado; ?>
                                                        @endif
                                                         {{ Form::select('id_estado',['0'=>'Descartado','1'=>'Sin Gestión','2'=>'Activo','3'=>'En Espera','4'=>'Activo - Problemas de Pago','5'=>'Activo - Daño al inmueble ','6'=>'Contrato Borrador','7'=>'No Activo - Daño al inmueble','12'=>'No Activo - Problema de Pago','11'=>'Contrato Firmado'], $idr,array('class'=>'form-control','style'=>'','id'=>'id_estado','placeholder'=>'Seleccione estado','required'=>'required')) }}
                                                        
                                                    </div>
                                                </div>
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

<section id="section-iconbox-2">

<div class="panel panel-info">
    <div class="panel-heading"> Registro de Reserva </div>
</div>

@if(isset($reserva->monto_reserva))
    <div class='row'>
        <div class="col-md-4">
            <div class="form-group">
                <button class="btn btn-block btn-primary" data-toggle="modal" id='via_portal' data-target="#modal-gestion1" >Devolución</button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <button class="btn btn-block btn-primary" data-toggle="modal" id='via_portal' data-target="#modal-gestion2" >Incumplimiento Arrendatario</button>
            </div>
        </div>
        <div class="col-md-4">

        </div>
    </div>
@endif

{{-- MODAL DEVOLUCION --}}
<div id="modal-gestion1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Ingrese información para devolución</h4> 
    </div>
    <form id="form1" action="{{ route('arrendatario.crearDev',$arrendatario->id) }}" method="post" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! csrf_field() !!}
        <input type="hidden" class="form-control" name="id_creador" id="id_creador" value="{{ Auth::user()->id }}">
        <input type="hidden" class="form-control" name="id_arr_ges" id="id_arr_ges" value="{{ $arrendatario->id }}">
        <div class="modal-body">
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Monto a Devolver</label>
                        <input class="form-control" value="{{ $reserva->monto_reserva or null }}" name="monto_reserva_d" placeholder="" type="number"></input>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 ">
                <div class="form-group">
                    <label>Detalle</label>
                    <textarea name="detalle_d"  id="detalle" cols="20" class="form-control"></textarea>
                </div>
                </div>                                            
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="white-box">
                        <h3 class="box-title"> Subir Documento </h3>
                        <label for="input-file-now-custom-1"> Documentos de Reserva</label>
                        <input class="dropify" id="foto_d" name="foto_d" type="file"/>
                    </div>
                </div>
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
<!-- FIN MODAL DEVOLUCION -->

{{-- MODAL INCUMPLIMIENTO --}}
<div id="modal-gestion2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Ingrese información sobre incumplimiento de Arrendatario</h4> 
    </div>
    <form id="form1" action="{{ route('arrendatario.crearIn',$arrendatario->id) }}" method="post" enctype='multipart/form-data'>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        {!! csrf_field() !!}
        <input type="hidden" class="form-control" name="id_creador" id="id_creador" value="{{ Auth::user()->id }}">
        <input type="hidden" class="form-control" name="id_arr_ges" id="id_arr_ges" value="{{ $arrendatario->id }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Monto a Ingresar</label>
                        <input class="form-control" value="{{ $reserva->monto_reserva or null }}" name="monto_reserva_i" placeholder="" type="number"></input>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 ">
                <div class="form-group">
                    <label>Detalle</label>
                    <textarea name="detalle_i"  id="detalle" cols="20" class="form-control"></textarea>
                </div>
                </div>                                            
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="white-box">
                        <h3 class="box-title"> Subir Documento </h3>
                        <label for="input-file-now-custom-1"> Documentos de Reserva</label>
                        <input class="dropify" id="foto_i" name="foto_i" type="file"/>
                    </div>
                </div>
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
<!-- FIN MODAL INCUMPLIMIENTO -->



{{-- INICIO RESERVA --}}
<form action="{{ route('arrendatario.CrearReserva',$arrendatario->id) }}" method="post" enctype='multipart/form-data'>
{!! csrf_field() !!}
<div class="row"> 
    <div class="panel panel-info">
           <div class="panel-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {!! csrf_field() !!}
                <div class="form-body">

                    <div class="row"> 
                        <input type="hidden" name="idinmueble" id="idinmueble" value='{{ $inmueble->id or null}}'>
                        <input type="hidden" name="paso" value="2">
                        <input type="hidden" name="id_arr_ges" id="id_arr_ges" value='{{ $arrendatario->id }}'>
                        <input type="hidden" name="id_modificador"value="{{ Auth::user()->id_persona }}">
                        <input type="hidden" name="id_creador"value="{{ Auth::user()->id_persona }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Condición</label>
                                <select class="form-control" name="id_condicion" required="required" >
                                    <option value="">Selecione Condición</option>
                                    
                                    @if(!isset($reserva->id_condicion))
                                        @foreach($condicion as $p)
                                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                        @endforeach    
                                    @else
                                        @foreach($condicion as $p)
                                            @if($reserva->id_condicion == $p->id)
                                                <option selected value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @else
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Monto Reserva</label>
                                <input class="form-control" value="{{ $reserva->monto_reserva or null }}" name="monto_reserva" placeholder="" type="number" required="required"></input>
                            </div>
                        </div>
                        <div class='row'>
                            
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8"> 
                            <div class="form-group">
                                <label class="control-label">Observaciones</label>
                                <textarea name="descripcion"  id="descripcion" cols="20" class="form-control">{{ $reserva->descripcion or null }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="white-box"> 
                                    <h3 class="box-title">Subir Documento</h3>
                                    <label for="input-file-now-custom-1">Documentos de Reserva</label>
                                    <input type="file" id="foto" name="foto"  class="dropify"  />  
                                </form>
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
                                                @can('revisioncomercial.edit')
                                            <td width="10px">
                                                <a href="{{ route('arrendatario.eliminararchivo', [$p->id,$persona->id]) }}" class="btn btn-danger btn-circle btn-lg"><i class="fa fa-check"></i></a>
                                            </td>
                                                @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                                </table>
                            </div>
                        </div> 
                    </div> 
        </div> {{-- panel-heading --}}
    </div> {{-- panel-info --}}
</div> {{-- Class Row --}}
                                
        <div class="form-actions">
            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
            <a href="{{ route('arrendatario.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
        </div>
</form>

<hr>

<table id="listusers2" class="display nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Condición</th>
            <th>Monto Reserva</th>
            <th>Estado</th>
            <th>Descargar</th>
        </tr>
    </thead>

    <tbody>
        @foreach($historiaRes as $p)
            <tr>
                <td>{{ $p->condicion }}</td>
                <td>$ {{ $p->monto }}</td>
                <td>{{ trans_choice('mensajes.reserva', $p->estado ) }}</td>
                <td width="20px">
                    <div class="col-lg-2 col-sm-3 col-xs-12">     
                        <a href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" target="_blank">{{ $p->nombre }} </a>            
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<hr>
{{-- FIN RESERVA --}}
</section>    


<section id="section-iconbox-3">
    <form action="{{ route('arrendatario.updateinmueble',$arrendatario->id) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row"> 
                                <div class="panel panel-info">
                                    <div class="panel-heading"> Información del Inmueble</div>
                                    <div class="panel-body">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <div class="row"> 
                                                        <input type="hidden" name="idinmueble" id="idinmueble" value='{{ $inmueble->id or null}}'>
                                                        <input type="hidden" name="paso" value="2">
                                                        <input type="hidden" name="idcaptacion" id="idcaptacion" value='{{ $arrendatario->id }}'>
                                                        <input type="hidden" name="id_modificador"value="{{ Auth::user()->id_persona }}">

                                                        <div class="col-md-6">
                                                            <div class="form-group">

                                                                <label>Dirección</label>
                                                                <div id="direcciones">
                                                                    <input name='i_direccion' id='i_direccion' class="typeahead form-control" type="text" placeholder="Dirección" required="required" value='{{ $inmueble->direccion or '' }}'> 
                                                                </div>
                                                                
                                                            </div>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                              <label>Nro.</label>
                                                              <input name='i_numero' id='i_numero' type="text" class="form-control"  value='{{ $inmueble->numero or ''  }}'>  </div>
                                                          </div>
                                                         <div class="col-md-2">
                                                            <div class="form-group">
                                                              <label>Departamento</label>
                                                              <input name='i_departamento'  id='i_departamento' value='{{ $inmueble->departamento or ''}}' type="text" class="form-control" > </div>
                                                          </div>     
                                                             <div class="col-md-2">
                                                            <div class="form-group">
                                                               
                                                                <label>Rol</label>
                                                                <input name='i_rol' id='i_rol' type="text" class="form-control" value='{{ $inmueble->rol or '' }}'> </div>
                                                            
                                                        </div>  
                                                </div>
                                                <div class="row"> 
                                                 <div class="col-md-12">
                                                        <div class="form-group">

                                                            <label>Referencia</label>
                                                            <div id="direcciones">
                                                                <input name='i_referencia' id='i_referencia' class="form-control" type="text" placeholder="Referencia"  value='{{ $inmueble->referencia or '' }}'> 
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                           
                                            @if(!isset($inmueble->id_region))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $inmueble->id_region; ?>
                                            @endif
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Región</label>
                                                        {{ Form::select('i_id_region',$regiones, $idr,array('class'=>'form-control','style'=>'','id'=>'i_id_region','placeholder'=>'Selecciona región','required'=>'required')) }}
                                                    </div>
                                                </div>

                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia</label>
                                                        {{ Form::select('i_id_provincia',[''=>'Seleccione provincia'], null, array('class'=>'form-control','style'=>'','id'=>'i_id_provincia','required'=>'required')) }} </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Comuna</label>
                                                        {{ Form::select('i_id_comuna',[''=>'Seleccione comuna'], null, array('class'=>'form-control','style'=>'','id'=>'i_id_comuna','required'=>'required')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Dormitorio</label>
                                                        <input name='i_dormitorio' id='i_dormitorio' type="number" class="form-control" value='{{ $inmueble->dormitorio or '' }}'> </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Baños</label>
                                                        <input name='i_bano' id='i_bano' type="number" class="form-control"  value='{{ $inmueble->bano or '' }}'> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>Estacionamiento</label>
                                                        <input name='i_estacionamiento' id='i_estacionamiento' type="number" class="form-control" value='{{ $inmueble->estacionamiento or '' }}'>
                                                    </div>
                                                </div>
                                                        @if(!isset($inmueble->bodega))
                                                        <?php $idpi = null; ?>
                                                        @else
                                                        <?php $idpi = $inmueble->bodega; ?>
                                                        @endif

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Bodega</label>
                                            {{ Form::select('i_bodega',['1'=> 'SI', '0'=>'NO'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'i_bodega','placeholder'=>'Seleccione')) }}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Número de Bodega</label>
                                        <input name='i_nro_bodega' id='i_nro_bodega'  type="text" class="form-control" value='{{ $inmueble->nro_bodega or '' }}' >
                                    </div>
                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        @if(!isset($inmueble->piscina))
                                                        <?php $idpi = null; ?>
                                                        @else
                                                        <?php $idpi = $inmueble->piscina; ?>
                                                        @endif
                                                        <label>Piscina</label>
                                                        {{ Form::select('i_piscina',['SI'=> 'SI', 'NO'=>'NO'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'i_piscina','placeholder'=>'Seleccione')) }}

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Gasto Común</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='i_gastosComunes' id='i_gastosComunes' type="number" class="form-control"  value='{{ $inmueble->gastosComunes or '' }}'>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Precio</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='i_precio' id='i_precio' type="number" class="form-control" required="required" value='{{ $inmueble->precio or '' }}'>
                                                        </div>
                                                    </div>
                                                </div>
                                                 <div class="col-md-2">
                                                    <div class="form-group">
                                                        @if(!isset($inmueble->condicion))
                                                        <?php $idpi = null; ?>
                                                        @else
                                                        <?php $idpi = $inmueble->condicion; ?>
                                                        @endif
                                                        <label>Condición</label>
                                                        {{ Form::select('i_condicion',['Nuevo'=> 'Nuevo', 'Usado'=>'Usado'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'i_condicion','placeholder'=>'Seleccione','required'=>'required')) }}

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                        
                                </div>

                                
                            </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    <a href="{{ route('arrendatario.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                </div>
                        </form>
</section>

<section id="section-iconbox-4">
                    <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('arrendatario.savefotos',$arrendatario->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h3 class="box-title">Subir Documentos</h3>
                                <label for="input-file-now-custom-1">Documentos del Arrendatario</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Documento</button>

                            </form>
                        </div>
                    </div>

<div class="col-sm-6">
    <div class="white-box"> 
     <table id="ssss"  cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><center>Click Ver Documento</center></th>
                <th><center>Borrar</center></th>
            </tr>
        </thead>
        <tbody>
@foreach($imagenes as $p)
<tr>
    <td  width="10px" height="10px" style="border: 1px solid black;" >
        <center>
            <a href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" target="_blank">DESCARGAR ARCHIVO<br/> {{ $p->nombre }} </a></center>
            @can('captacion.show')
            <td width="10px" style="border: 1px solid black;">
                <center>
                    <a href="{{ route('arrendatario.eliminarfoto', [$p->id,$p->id_arrendatario]) }}" 
                     class="btn btn-danger btn-circle btn-lg">
                     <i class="fa fa-check"></i>
                 </a>
             </center>
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
                        <!-- MODAL GESTION CREAR -->
                    <div class="row">
                    <div class="col-lg-2 col-sm-3">
                    <button class="btn btn-block btn-primary" data-toggle="modal" id='via_portal' data-target="#modal-contacto1" >Nueva Cita</button>
                    </div>
                                 <div class="col-lg-2 col-sm-3">
                                   <a href="{{ route("arrendatario.crearBorrador",$arrendatario->id) }}"><button class="btn btn-block btn-secondary" id='crear_contrato' >Contrato Borrador</button></a>
                                </div>

                                    <div id="modal-contacto1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Ingrese información de la cita</h4> </div>
                                                 <form id="form1" action="{{ route('arrendatario.crearGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_creador" id="id_creador" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_arrendatario" id="id_arrendatario" value="{{ $arrendatario->id }}">
                                                    
                                                    <div class="modal-body">

                                                <div class="row">
                                                        <div class="col-sm-4">
                                                        <label>Fecha Cita</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1" name="fecha" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado</label>
                                                        <select name='estado' id='estado' class='form-control' required="required">
                                                                <option value="Cancelado">Cancelado</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="ReAgendado">ReAgendado</option>
                                                                <option value="Realizada">Realizada</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                </div>

                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección del Inmueble a Mostrar</label>
                                                        <input name='direccion' id='direccion' type="text" class="form-control"  value="{{ $citas->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='numero' id='numero' class="form-control" type="text" placeholder="Dirección" value="{{ $citas->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='departamento' id='departamento' class="form-control" type="text" value="{{ $citas->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre Captador</label>
                                                        <select class="form-control" name="nombre_c" id="nombre_c"  required="required" >
                                                            <option value="">Selecione Captador</option>
                                                            @foreach($corredores as $p)
                                                                <option value="{{ $p->Corredor }}">{{ $p->Corredor }}</option>
                                                            @endforeach                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Detalle</label>
                                                        <textarea name="detalle"  id="detalle" cols="20" class="form-control"></textarea>
                                                </div>
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
                                    <!-- FIN MODAL GESTION CREAR -->
                                
                            </div>
                            <br/><br/>
                <table id="listusers1" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Cita</th>
                        <th>Nombre</th>
                        <th>Captador</th>
                        <th>Detalle</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $p)
                            <tr>
                                <td style="background: #707cd2; color:white">
                                {{ $p->fecha }}</td>
                                <td>{{ $p->nombre }}</td>
                                <td>{{ $p->nombre_c }}</td>
                                <td>{{ $p->detalle }}</td>
                                @can('captacion.edit')
                                <td width="10px">
                                    <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                                </div>

                                </td>
                                @endcan
                            </tr>
                            @endforeach

                            <!-- MODAL GESTION UPDATE -->
                                    <div id="modal-contacto_edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice su información de contacto</h4> </div>
                                                 <form action="{{ route('arrendatario.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}

                                                    
                                                    <div class="modal-body">
                                                    <input type="hidden" class="form-control" name="id_creador" id="id_creador" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_arrendatario" id="id_arrendatario" value="{{ $arrendatario->id }}">
                                                    <input type="hidden" class="form-control" name="id_citas" id="id_citas_e">
                                                <div class="row">
    
                                                        <div class="col-sm-4">
                                                        <label>Fecha Cita</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_cita" name="fecha" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado</label>
                                                        <select name="estado" id="estado_e" class='form-control' required="required">
                                                                <option value="Cancelado">Cancelado</option>
                                                                <option value="Pendiente">Pendiente</option>
                                                                <option value="ReAgendado">ReAgendado</option>
                                                                <option value="Realizada">Realizada</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                </div>


                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección del inmueble a mostrar</label>
                                                        <input name='direccion' id='direccion_e' type="text" class="form-control" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='numero' id='numero_e' class="form-control" type="text" placeholder="Dirección"  > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='departamento' id='departamento_e' class="form-control" type="text"  placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre Captador</label>
                                                        <select class="form-control" name="nombre_c" id="nombre_c_e" required="required" >
                                                            <option value="">Selecione Captador</option>
                                                            @foreach($corredores as $p)

                                                                <option value="{{ $p->Corredor }}">{{ $p->Corredor }}</option>
                                                            @endforeach                                                            
                                                        </select> 
                                                    </div>
                                                </div>

                                            </div>
                                            
                                            <hr>

                                            <div class="row">
                                                <div class="col-md-12 ">
                                                    <div class="form-group">
                                                        <label>Detalle</label>
                                                        <textarea name="detalle"  id="detalle_e" cols="20" class="form-control"></textarea>
                                                        </div>
                                                </div>
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



<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>

<script>

var direcciones = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (dir) {
                return {value: 'Id: ' + dir.id + ', Dir: ' + dir.direccion + ', Nro: ' + dir.numero + ', Comuna: ' + dir.comuna_nombre};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/inmuebles/contratos/1/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' ' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
                    option: dir.id};
            });
        }
    }
});

$('#i_direccion').typeahead({

    hint: false,
    highlight: true,
    minLength: 1,
    val:'',
    limit: 10
},
        {
            name: 'direcciones',
            display: 'value',
            limit: 10,
            source: direcciones
        });

jQuery('#i_direccion').on('typeahead:selected', function (e, datum) {
 
        swal({   
            title: "Esta seguro que desea utilizar la siguiente dirección?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/arrendatario/agregarinmueble/'+$('#idcaptacion').val()+'/'+datum.option; 
        });

   
});

</script>
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

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

</script>

<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />


<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>


<script>

$(function() {

        @if(isset($persona->id))
            @if(isset($persona->id_region) && isset($persona->id_provincia))
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
       @if(isset($inmueble->id))
            @if(isset($inmueble->id_region) && isset($inmueble->id_provincia))
            $("#i_id_provincia").empty();
            $("#i_id_comuna").empty();
            $.get("/provincias/"+{{ $inmueble->id_region}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $inmueble->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            @endif
            @if(isset($persona->id_provincia))
            $.get("/comunas/"+{{ $inmueble->id_provincia }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $inmueble->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        @endif
        });


$(function(){

    $('#modal-garantia').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

    $('#modal-garantia').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

    $('#modal-gestion1').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

    $('#modal-gestion1').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

    $('#modal-gestion2').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });

    $('#modal-gestion2').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });





    
    $('#modal-contacto1').on('hidden.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });
    
     $('#modal-contacto1').on('shown.bs.modal', function () {
        $("#form1")[0].reset();
         var fecha =  new Date();
         var year = fecha.getFullYear();
         var mes = fecha.getMonth()+1;
         var dia = fecha.getDate();
         var hora = fecha.getHours();
         var minutos = fecha.getMinutes();
         var segundos = fecha.getSeconds();
         if(mes<10){mes='0'+mes}
         if(dia<10){dia='0'+dia}
         if(hora<10){hora='0'+hora}
         if(minutos<10){minutos='0'+minutos}
         if(segundos<10){segundos='0'+segundos}
        $('#datepicker-fecha_contacto1').val(dia+'-'+mes+'-'+year);;
        $('#hora_gestion').val(hora+':'+minutos);;
    });
});



function mostrar_modal(obj){
    var url= "{{ URL::to('arrendatario/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-contacto_edit').modal('show');
            $('#id_citas_e').val(response[0].id);
            $('#tipo_contacto_e').val(response[0].tipo_contacto);
            var d = response[0].fecha.split('-');
            $('#datepicker-fecha_cita').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#direccion_e').val(response[0].direccion);
            $('#numero_e').val(response[0].numero);
            $('#departamento_e').val(response[0].departamento);
            $('#nombre_c_e').val(response[0].nombre_c);
            $('#detalle_e').val(response[0].detalle);
            $('#estado_e').val(response[0].estado);
            
        }
});
}

<?php if($tab==1){  ?>
    $(function() {
            $("#li_1").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 
           }); 
<?php } ?>

<?php if($tab==2){  ?>
    $(function() {
            $("#li_1").removeClass("tab-current");
            $("#li_2").addClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").addClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current");
           }); 
<?php } ?>

<?php if($tab==3){  ?>
    $(function() {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").addClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").addClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 
           }); 
<?php } ?>

<?php if($tab==4){  ?>
    $(function() {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").addClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").addClass("content-current");
            $("#section-iconbox-5").removeClass("content-current");
           }); 
<?php } ?>

<?php if($tab==5){  ?>
    $(function() {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").addClass("content-current"); 
           }); 
<?php } ?>

$("#li_1").click(function (event) {
            $("#li_1").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 

            
});
$("#li_2").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").addClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").addClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 
       
});
$("#li_3").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").addClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").addClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 
       
});
$("#li_4").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").addClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").addClass("content-current");
            $("#section-iconbox-5").removeClass("content-current"); 
       
});
$("#li_5").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current");
            $("#section-iconbox-5").addClass("content-current"); 
       
});


            tinymce.init({
                selector: "textarea",
                theme: "modern",
            height: 100,
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


$('#listusers1').DataTable({
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

$('#listusers2').DataTable({
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



$("#i_id_region").change(function (event) {
    $("#i_id_provincia").empty();
    $("#i_id_comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#i_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#i_id_provincia").change(function (event) {
    $("#i_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#i_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#i_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});


   
</script>
@endsection