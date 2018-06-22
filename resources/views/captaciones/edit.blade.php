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
        @if(isset($inmueble->direccion))
         <center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna_nombre or null }}</h3></center>
         @endif
          @if( isset($persona->telefono) && isset($persona->email))
        <center><h3 class="box-title m-b-0">{{ $persona->nombre or null }} {{ $persona->apellido_paterno or null }}, Fono : {{ $persona->telefono or null }}, Email: {{ $persona->email or null }}</h3></center>
        <br><br>
        @endif
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_1"> <a href="#section-iconbox-1" class="sticon ti-bookmark"><span>Portal Aviso</span></a></li>
                        <li id="li_2"><a id="2" href="#section-iconbox-2" class="sticon ti-home"><span>Propiedad / Propietario</span></a></li>
                        <li id="li_4"><a id="4" href="#section-iconbox-4" class="sticon ti-camera"><span>Imágenes del Portal</span></a></li>
                        <li id="li_5"><a id="5" href="#section-iconbox-5" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Nuevo Aviso Portal Inmobiliario</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('captacion.update',$captacion->id) }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="paso" value="1">
                                        <div class="form-body">
                                            <h3 class="box-title">Información de la publicación web del portal</h3>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">URL</label>
                                                        <input type="hidden" name="paso" value="1">
                                                        <input type="text" name="url" class="form-control" required="required" placeholder="http://portal.dominio.com/publicacion" value="{{ $captacion->url }}"> <span class="help-block"> Url del Portal </span> </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Portal</label>
                                                         @if(!isset($captacion->portal))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $captacion->portal; ?>
                                                        @endif
                                                        {{ Form::select('portal',$portales, $idr,array('class'=>'form-control','style'=>'','id'=>'portal','placeholder'=>'Seleccione portal','required'=>'required')) }}
                                                     </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Código publicación</label>
                                                        <input name='codigo_publicacion' value="{{ $captacion->codigo_publicacion }}" type="text" class="form-control"> </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Publicación</label>
                                                        <div class="input-group">
                                                            <input name="fecha_publicacion" autocomplete="off" value="{{ date('d/m/Y', strtotime($captacion->fecha_publicacion)) }}" type="text" class="form-control" id="datepicker-fecha_publicacion" placeholder="dd/mm/yyyy" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                                    </div>
                                                </div>
                                                @if(isset($captacion->fecha_expiracion))
                                               <?php     $exp = date('d/m/Y', strtotime($captacion->fecha_expiracion)); ?>
                                               @else
                                               <?php $exp=''; ?>
                                               @endif
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Fecha Expiración</label>
                                                        <div class="input-group">
                                                            <input name="fecha_expiracion" autocomplete="off" type="text" class="form-control" id="datepicker-fecha_expiracion" value="{{ $exp }}" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Estado</label>
                                                        <input type="hidden" name="id_modificador" 
                                                               value="{{ Auth::user()->id_persona }}">

                                                        @if(!isset($captacion->id_estado))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $captacion->id_estado; ?>
                                                        @endif


<<<<<<< HEAD
                                                        {{ Form::select('id_estado',['0'=>'Descartado','1'=>'Sin Gestión','2'=>'Sin Respuesta','3'=>'Reenvio de Correo','8'=>'Seguimiento Correo','9'=>'Captación Terreno','4'=>'Publicación Expirada','5'=>'Negociación','6'=>'Contrato Borrador','7'=>'Contrato Cerrado'], $idr,array('class'=>'form-control','style'=>'','id'=>'id_estado','placeholder'=>'Seleccione estado','required'=>'required')) }}
=======
                                                        {{ Form::select('id_estado',['0'=>'Descartado','1'=>'Sin Gestión','2'=>'Sin Respuesta','3'=>'Reenvio','4'=>'Expirado','5'=>'Segunda Gestión ','6'=>'Contrato Borrador','7'=>'Contrato Cerrado','8'=>'Seguimiento Correo','9'=>'Captación Terreno'], $idr,array('class'=>'form-control','style'=>'','id'=>'id_estado','placeholder'=>'Seleccione estado','required'=>'required')) }}
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            <a href="{{ route('captacion.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="section-iconbox-2" >
                        <form action="{{ route('captacion.update',$captacion->id) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row"> 
                                <div class="panel panel-info">
                                    <div class="panel-heading"> Información del Inmueble</div>
                                    <div class="panel-body">

                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <div class="row"> 
                                                        <input type="hidden" name="idpersona" id="idpersona"value='{{ $persona->id or null}}'>
                                                        <input type="hidden" name="idinmueble" id="idinmueble" value='{{ $inmueble->id or null}}'>
                                                        <input type="hidden" name="paso" value="2">
                                                        <input type="hidden" name="idcaptacion" id="idcaptacion" value='{{ $captacion->id }}'>
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
                                            <input name='i_referencia' id='i_referencia' class="typeahead form-control" type="text" placeholder="Referencia"  value='{{ $inmueble->referencia or '' }}'> 
                                        </div>
                                        
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
<<<<<<< HEAD
                         @if(isset($inmueble->id))
=======
                         @if(isset($persona->id))
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
                                    @if (count($captaciones_inmueble)>1)
                                    <div class="alert alert-danger">

                                        El inmueble cuenta con {{ count($captaciones_inmueble) }} captaciones vigentes  
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" class="model_img img-responsive">
                                            Ver Captaciones
                                        </button>
                                    </div>                
                                    @endif
                                </div>

                                <!--  modal content -->
                                <div id="myModal" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Captaciones existentes inmuebles</h4> </div>
                                            <div class="modal-body">
                                                <table id="listusers" class="display nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Dirección/ #Nro</th>
                                                            <th>Propietario</th>
                                                            <th>Fecha Creación</th>
                                                            <th>Creador</th>
                                                            <th>Portal</th>
                                                            <th>Ver</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($captaciones_inmueble as $p)
                                                        <tr>
                                                            <td>{{ $p->id_publicacion }}</td>
                                                            <td>{{ $p->direccion }} #{{ $p->numero }}</td>
                                                            <td>{{ $p->Propietario }}</td>
                                                            <td>{{ $p->fecha_creacion }}</td>
                                                            <td>{{ $p->Creador }}</td>
                                                            <td>{{ $p->portal }}</td>
                                                            @can('captacion.show')
                                                            <td width="10px">
                                                                <a href="{{ route('captacion.edit', $p->id_publicacion) }}" 
                                                                   class="btn btn-success btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                            </td>
                                                            @endcan

                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->

                                    
                                    </div>
                                @endif
                                </div>

                                <div class="col-md-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading"> Información del Propietario</div>
                                        <div class="panel-body">


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Rut</label>
                                                        <input type="text" name="p_rut" id="p_rut" class="form-control" placeholder=""  oninput='checkRut(this)' value='{{ $persona->rut or '' }}' > 
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
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Profesión / Ocupación</label>
                                        <div id="profesion">
                                                    <input name='p_profesion' id='p_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $persona->profesion or ''}}"> 
                                            </div>
                                    </div>
                                </div>
                                  <div class="col-md-4 ">
                                    <div class="form-group">
                                            @if(!isset($persona->estado_civil))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $persona->estado_civil; ?>
                                            @endif
                                        <label>Estado civil</label>
                                            {{ Form::select('p_estado_civil',['Soltero/a'=>'Soltero/a','Casado/a'=>'Casado/a','Viudo/a'=>'Viudo/a','Divorciado/a'=>'Divorciado/a','Separado/a'=>'Separado/a','Conviviente'=>'Conviviente'], $idr ,array('class'=>'form-control','style'=>'','id'=>'p_estado_civil')) }}
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
                                        </div>
                                    </div>
                                    @if(isset($captacion->id))

                                    @if (count($captaciones_persona)>1)
                                    <div class="alert alert-danger">

                                        El propietario cuenta con {{ count($captaciones_persona) }} captaciones vigentes 

                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal2" class="model_img img-responsive">
                                            Ver Captaciones
                                        </button>
                                    </div>                
                                    @endif
                                </div>

                                <!--  modal content -->
                                <div id="myModal2" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title" id="myModalLabel">Captaciones existentes propietario</h4> </div>
                                            <div class="modal-body">
                                                <table id="listusers" class="display nowrap" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Dirección/ #Nro</th>
                                                            <th>Propietario</th>
                                                            <th>Fecha Creación</th>
                                                            <th>Creador</th>
                                                            <th>Portal</th>
                                                            <th>Ver</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($captaciones_persona as $p)
                                                        <tr>
                                                            <td>{{ $p->id_publicacion }}</td>
                                                            <td>{{ $p->direccion }} #{{ $p->numero }}</td>
                                                            <td>{{ $p->Propietario }}</td>
                                                            <td>{{ $p->fecha_creacion }}</td>
                                                            <td>{{ $p->Creador }}</td>
                                                            <td>{{ $p->portal }}</td>
                                                            @can('captacion.show')
                                                            <td width="10px">
                                                                <a href="{{ route('captacion.edit', $p->id_publicacion) }}" 
                                                                   class="btn btn-success btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                            </td>
                                                            @endcan

                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                        @endif
                                </div>
                                
                            </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    <a href="{{ route('captacion.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                </div>
                        </form>
                    </section>
                    <section id="section-iconbox-4">
                     <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('captacion.savefotos',$captacion->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <h3 class="box-title">Subir imágen</h3>
                                <label for="input-file-now-custom-1">Imágenes de la publicación</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Foto</button>

                            </form>
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="white-box"> 
                             <table id="ssss"  cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                         
                                                            <th><center>Click Ver Imágen</center></th>
                                                            <th>Borrar</th>
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                        @foreach($imagenes as $p)
                                                        <tr>
                                                            <td  width="10px" height="10px">
                                                               
                                                            <center><a data-lightbox="image-1" href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" ><img src="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" alt="gallery" class="all studio" width="50" height="80" /> </a></center>

                                                           
                                                            @can('captacion.show')
                                                            <td width="10px">

                                                                <a href="{{ route('captacion.eliminarfoto', [$p->id,$p->id_captacion]) }}" 
                                                                   class="btn btn-danger btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                            </td>
                                                            @endcan
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                        </div>
                    </div>

                </div></section>
                    <section id="section-iconbox-5">
                        <!-- MODAL GESTION CREAR -->
                   <div class="row">
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-primary" data-toggle="modal" id='via_portal' data-target="#modal-contacto1" >Vía Portal</button>
                                    <div id="modal-contacto1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Ingrese información de contacto</h4> </div>
                                                 <form id="form1" action="{{ route('captacion.crearGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_creador_gestion" id="id_creador_gestion" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_captacion_gestion" id="id_captacion_gestion" value="{{ $captacion->id }}">
                                                    <input type="hidden" class="form-control" name="tipo_contacto" id="tipo_contacto">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                        <div class="col-sm-5">
                                                            <label>Dirección de la información</label>
                                                              <select name="dir" id=dir class='form-control' required="required">
                                                                <option value="Información Enviada">Información Enviada</option>
                                                                <option value="Información Recibida">Información Recibida</option>
                                                                <option value="Ambas">Ambas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7">
                                                        <label>Fecha/Hora de Contacto</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" id="hora_gestion" placeholder="HH:MM" required="required" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                        <div class="form-group">
                                                                <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                                <textarea class="form-control" name="detalle_contacto" id="detalle_contacto" cols="25" rows="10" class="form-control" required="required"></textarea>
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
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-info" id='via_correo' data-toggle="modal" data-target="#modal-contacto1">Vía Correo</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-success" id='via_fono' data-toggle="modal" data-target="#modal-contacto1">Vía Teléfonico/WSP</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-warning" id='via_presencial' data-toggle="modal" data-target="#modal-contacto1">Vía presencial</button>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-danger" id='via_otras' data-toggle="modal" data-target="#modal-contacto1">Otras Gestiones</button>
                                </div>
<<<<<<< HEAD
                               <div class="col-lg-2 col-sm-3 col-xs-12">
                                   <a href="{{ route("captacion.crearBorrador",$captacion->id) }}"> <button class="btn btn-block btn-secondary" id='crear_contrato' >Contrato Borrador</button> </a>
                                </div>
=======
>>>>>>> 4679f853b0fcb2262a0e335c0f5b7340c138e65c
                            </div>
                            <br/><br/>
                <table id="listusers1" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Tipo Contacto</th>
                        <th>Tipo de Gestion</th>
                        <th>Creador</th>
                        <th>Fecha / Hora Gestión</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($gestion as $p)
                            <tr>@if($p->tipo_contacto=='Portal')
                                    <td style="background: #707cd2; color:white">
                                @elseif($p->tipo_contacto=='Correo Eléctronico')
                                    <td style="background: #2cabe3; color:white">
                                @elseif($p->tipo_contacto=='Presencial')
                                    <td style="background: #ffc36d; color:white">
                                @elseif($p->tipo_contacto=='Teléfono/WhatsApp')
                                    <td style="background: #53e69d; color:white">
                                @elseif($p->tipo_contacto=='Otras Gestiones')
                                    <td style="background: #ff7676; color:white">
                                @else
                                    <td>
                                @endif
                                {{ $p->tipo_contacto }}</td>
                                <td>{{ $p->dir }}</td>
                                <td>{{ $p->Creador }}</td>
                                <td>{{ $p->fecha_gestion }} {{ $p->hora_gestion }}</td>
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
                                                 <form action="{{ route('captacion.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_modificador_gestion" id="id_modificador_gestion" value="{{ Auth::user()->id }}">
                                                     <input type="hidden" class="form-control" name="id_gestion" id="id_gestion" >
                                                    <input type="hidden" class="form-control" name="id_captacion_gestion" id="id_captacion_gestion" value="{{ $captacion->id }}">
                                                    <input type="hidden" class="form-control" name="tipo_contacto" id="tipo_contacto_e">
                                                    <div class="modal-body">

                                                            <div class="row">
                                                        <div class="col-sm-5">
                                                            <label>Dirección de la información</label>
                                                              <select name="dir" id='dir_e' class='form-control' required="required">
                                                                <option value="Información Enviada">Información Enviada</option>
                                                                <option value="Información Recibida">Información Recibida</option>
                                                                <option value="Ambas">Ambas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-7">
                                                        <label>Fecha/Hora de Contacto</label>
                                                        <div class="input-group">
                                                            <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto_e" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" placeholder="HH:MM" required="required" id="hora_gestion_e" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                        <div class="form-group">
                                                                <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                                <textarea class="form-control" name="detalle_contacto" id="detalle_contacto_e" cols="25" rows="10" class="form-control" required="required"></textarea>
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
    
    $('#modal-contacto_edit_c').on('hidden.bs.modal', function () {
        $("#form1_e")[0].reset();
    });

});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })

function mostrar_modal(obj){
    var url= "{{ URL::to('captacion/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){

            $('#modal-contacto_edit').modal('show');
            $('#id_gestion').val(response[0].id);
            $('#detalle_contacto_e').val(response[0].detalle_contacto);
            $('#tipo_contacto_e').val(response[0].tipo_contacto);
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto_e').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#hora_gestion_e').val(response[0].hora_gestion);
            $('#dir_e').val(response[0].dir);
            tinyMCE.activeEditor.setContent(response[0].detalle_contacto);
        }
});
}


$('#listusers1').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'excel', 'pdf', 'print'

    ],
    columnDefs: [{
            "targets": [4],
            "orderable": false
        }],
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


$("#via_portal").click(function(){
    $("#tipo_contacto").val("Portal");
});
$("#via_correo").click(function(){
    $("#tipo_contacto").val("Correo Eléctronico");
});
$("#via_fono").click(function(){
    $("#tipo_contacto").val("Teléfono/WhatsApp");
});
$("#via_presencial").click(function(){
    $("#tipo_contacto").val("Presencial");
});
$("#via_otras").click(function(){
    $("#tipo_contacto").val("Otras Gestiones");
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
        
      

$(function() {

        @if(isset($persona->id))
   
            @if(isset($persona->id_region))
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
            $("#li_1").removeClass("tab-current");
            $("#li_2").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").addClass("content-current");
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