@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<style>
#scrollable-dropdown-menu .tt-dropdown-menu {
  max-height: 130px;
  overflow-y: auto;
}
</style>
<div class="row" >
    <center><h3 class="box-title m-b-0">SOLICITUD NRO {{ $postventa->id }}<br></h3>
        @if($postventa->id_modulo==1)
            CONTRATO PROPIETARIO
        @else
            CONTRATO ARRENDATARIO
        @endif
        </center>
    @if(isset($inmueble->direccion))
    <center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna_nombre or null }}</h3></center>

    @endif

    <div class="col-md-12">
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_1"><a id="1" href="#section-iconbox-1" class="sticon ti-bookmark"><span>Post Atención</span></a></li>
                        <li id="li_2"><a id="2" href="#section-iconbox-2" class="sticon ti-home"><span>Propiedad</span></a></li>
                        <li id="li_3"><a id="3" href="#section-iconbox-3" class="sticon ti-user"><span>Propietario</span></a></li>
                        <li id="li_4"><a id="4" href="#section-iconbox-4" class="sticon ti-user"><span>Arrendatario</span></a></li>
                        <li id="li_5"><a id="5" href="#section-iconbox-5" class="sticon ti-user"><span>Aval</span></a></li>
                        <li id="li_6"><a id="6" href="#section-iconbox-7" class="sticon ti-clip"><span>Documentos</span></a></li>
                        <li id="li_7"><a id="7" href="#section-iconbox-8" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                        <li id="li_8"><a id="8" href="#section-iconbox-9" class="sticon ti-money"><span>Presupuestos</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1" style="height: 500px">
                        <form action="{{ route('postventa.update',$postventa->id) }}" method="post" id="form">
                            {!! csrf_field() !!}
                            <div class="panel panel-info">
                                <div class="panel-heading"> Datos de la Atención</div>
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                    <div class="panel-body">
                                        <div class="row">


                                            <div class="col-md-3">
                                                <label>Fecha Solicitud</label>

                                                <input type="hidden" name="id_contrato" id="id_contrato" >
                                                <input type="hidden" name="id_modulo" id="id_modulo" >
                                                <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ $postventa->fecha_solicitud }}"  class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Asignado</label>
                                                <select name="asignado" id="asignado" class="form-control">
                                                    <option value="">Seleccione</option>

                                                    @foreach($empleados as $e )
                                                    <option value="{{ $e->id }}" <?= $e->id == $postventa->id_asignacion ? 'Selected' : ''; ?>>{{ $e->empleado }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Estado</label>
                                                <select name="estado" id="estado" class="form-control">
                                                    <option value="">Seleccione</option>
                                                    @foreach($estados as $e )
                                                    <option value="{{ $e->id_estado }}" <?= $e->id_estado == $postventa->id_estado ? 'Selected' : ''; ?>>{{ $e->nombre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                           <div class="col-md-3">
                                                <label>Responsable del pago</label>
                                                <select name="id_cobro" id="id_cobro" class="form-control" required="required">
                                                    <option value="">Seleccione</option>
                                                    <option value="1" <?= 1 == $postventa->id_cobro ? 'Selected' : ''; ?>>Propietario</option>
                                                    <option value="2" <?= 2 == $postventa->id_cobro ? 'Selected' : ''; ?>>Arrendatario</option>
                                                     <option value="3" <?= 3 == $postventa->id_cobro ? 'Selected' : ''; ?>>Baquedano</option>
                                                    <option value="4" <?= 4 == $postventa->id_cobro ? 'Selected' : ''; ?>>Garantía de Proveedor</option>
                                                    <option value="5" <?= 5 == $postventa->id_cobro ? 'Selected' : ''; ?>>Sin Cobro</option>
                                                    <option value="5" <?= 5 == $postventa->id_cobro ? 'Selected' : ''; ?>>En Evaluación</option>

                                                </select>
                                            </div>

                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Nombre de la Solicitud POST VENTA</label>
                                                <input type="text" name="nombre_caso" id="nombre_caso" value="{{ $postventa->nombre_caso or null }}" required="required" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label>Detalle de la Solicitud POST VENTA</label>
                                                <input type="text" name="descripcion_del_caso" id="descripcion_del_caso" value="{{ $postventa->descripcion_del_caso or null }}" required="required" class="form-control">
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            <a href="{{ route('postventa.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>

                    <section id="section-iconbox-2">
                        <form action="{{ route('inmueble.update_postventa',$inmueble->id) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row"> 
                                <div class="panel panel-primary">
                                    <div class="panel-heading"> Información del Inmueble</div>
                                    <div class="panel-body">
                                        <div class="form-body">
                                            <div class="row"> 
                                                <div class="col-md-6">
                                                    <div class="form-group">

                                                        <label>Dirección</label>
                                                        <div id="scrollable-dropdown-menu">
                                                            <input name='i_direccion' id='i_direccion' type="text" placeholder="Dirección" required="required" class="form-control" value='{{ $inmueble->direccion or '' }}'> 
                                                            <input name='i_postventa' id='i_postventa' type="hidden" value='{{ $postventa->id}}'> 
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
                                                        <div >
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
                                                    <input name='i_dormitorio' type="number" class="form-control" value='{{ $inmueble->dormitorio }}' required="required"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Baños</label>
                                                    <input name='i_bano' type="number" class="form-control" value='{{ $inmueble->bano }}' required="required"> </div>
                                            </div>
                                            <!--/span-->



                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Piscina</label>
                                                    {{ Form::select('i_piscina',['SI'=>'SI','NO'=>'NO'], $inmueble->piscina ,array('class'=>'form-control','style'=>'','id'=>'piscina','placeholder'=>'Seleccione piscina','required'=>'required')) }}
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    @if(!isset($inmueble->bodega))
                                                    <?php $idpi = null; ?>
                                                    @else
                                                    <?php $idpi = $inmueble->bodega; ?>
                                                    @endif
                                                    <label>Bodega</label>
                                                    {{ Form::select('i_bodega',['1'=> 'SI', '0'=>'NO'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'bodega','placeholder'=>'Seleccione','required'=>'required')) }}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Número de Bodega</label>
                                                    <input name='i_nro_bodega' type="text" class="form-control" value='{{ $inmueble->nro_bodega or '' }}' >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Estacionamiento</label>
                                                    <input name='i_estacionamiento' type="number" class="form-control" value='{{ $inmueble->estacionamiento }}' required="required">
                                                </div>
                                            </div>                                <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nro. Estacionamiento</label>
                                                    <input name='i_nro_estacionamiento' type="text" class="form-control" value='{{ $inmueble->nro_estacionamiento or '' }}'>
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
                                                        <input name='i_precio' id='i_precio' type="number" class="form-control" required="required"  step="any" value='{{ $inmueble->precio or '' }}'>
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
                                        <hr>
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombre Edificio</label>
                                                    <input name='i_edificio' type="text" class="form-control" value='{{ $inmueble->edificio or '' }}'>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Año Antiguedad</label>
                                                    <input name='i_anio_antiguedad' type="number" class="form-control" value='{{ $inmueble->anio_antiguedad or '' }}'>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Administrador</label>
                                                    <input name='i_nom_administrador' type="text"  class="form-control" value='{{ $inmueble->nom_administrador or '' }}'>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Teléfono</label>
                                                    <input name='i_tel_administrador' type="text"  class="form-control" value='{{ $inmueble->tel_administrador or '' }}'>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input name='i_email_administrador' type="email"  class="form-control" value='{{ $inmueble->email_administrador or '' }}'>

                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="section-iconbox-3">
                        @php
                        if(isset($propietario->id)){
                        $idpropietario= $propietario->id;
                        }else{
                        $idpropietario=0;
                        }

                        @endphp
                        <form action="{{ route('persona.update_postventa_p',$idpropietario) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-info">
                                        <div class="panel-heading"> Información del Propietario</div>
                                        <div class="panel-body">


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Rut</label>
                                                        <input type="text" name="p_rut" id="p_rut" class="form-control" placeholder=""  oninput='checkRut(this)' value='{{ $propietario->rut or '' }}' > 
                                                        <input name='i_postventa_p' id='i_postventa_p' type="hidden" value='{{ $postventa->id}}'> 
                                                    </div>
                                                </div>

                                                <div class="col-md-10">
                                                </div>
                                            </div>

                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre</label>
                                                        <input type="text" name="p_nombre" id="p_nombre"  class="form-control" placeholder="" required="required" value='{{ $propietario->nombre or '' }}' > 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Paterno</label>
                                                        <input type="text" name="p_apellido_paterno" id="p_apellido_paterno" class="form-control" placeholder=""  value='{{ $propietario->apellido_paterno or '' }}'> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Materno</label>
                                                        <input type="text" name="p_apellido_materno" id="p_apellido_materno" class="form-control" placeholder=""  value='{{ $propietario->apellido_materno or '' }}'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Profesión / Ocupación</label>
                                                        <div id="profesion">
                                                            <input name='p_profesion' id='p_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $propietario->profesion or ''}}"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        @if(!isset($propietario->estado_civil))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $propietario->estado_civil; ?>
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
                                                        <input name='p_direccion' id='p_direccion' type="text" class="form-control"  value="{{ $propietario->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='p_numero' id='p_numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $propietario->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='p_departamento' id='p_departamento' class="typeahead form-control" type="text" value="{{ $propietario->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <input name='p_telefono' id='p_telefono' type="numero" class="typeahead form-control" class="form-control" value="{{ $propietario->telefono or '' }}" > </div>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <div id="scrollable-dropdown-menu">
                                                            <label>Email</label>
                                                            <input name='p_email' id='p_email' type="email" class="form-control"  value="{{ $propietario->email or '' }}" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @if(!isset($propietario->id_region))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $propietario->id_region; ?>
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
                                            <hr>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="section-iconbox-4">
                        @php
                        if(isset($arrendatario->id)){
                        $idarrendatario= $arrendatario->id;
                        }else{
                        $idarrendatario=0;
                        }

                        @endphp
                        <form action="{{ route('persona.update_postventa_a',$idarrendatario) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-success">
                                        <div class="panel-heading"> Información del Arrendatario</div>
                                        <div class="panel-body">


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Rut</label>
                                                        <input type="text" name="a_rut" id="a_rut" class="form-control" placeholder=""  oninput='checkRut(this)' value='{{ $arrendatario->rut or '' }}' > 
                                                        <input name='i_postventa_a' id='i_postventa_a' type="hidden" value='{{ $postventa->id}}'> 
                                                    </div>
                                                </div>

                                                <div class="col-md-10">
                                                </div>
                                            </div>

                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre</label>
                                                        <input type="text" name="a_nombre" id="a_nombre"  class="form-control" placeholder="" required="required" value='{{ $arrendatario->nombre or '' }}' > 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Paterno</label>
                                                        <input type="text" name="a_apellido_paterno" id="a_apellido_paterno" class="form-control" placeholder=""  value='{{ $arrendatario->apellido_paterno or '' }}'> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Materno</label>
                                                        <input type="text" name="a_apellido_materno" id="a_apellido_materno" class="form-control" placeholder=""  value='{{ $arrendatario->apellido_materno or '' }}'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Profesión / Ocupación</label>
                                                        <div id="profesion">
                                                            <input name='a_profesion' id='a_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $arrendatario->profesion or ''}}"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        @if(!isset($arrendatario->estado_civil))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $arrendatario->estado_civil; ?>
                                                        @endif
                                                        <label>Estado civil</label>
                                                        {{ Form::select('a_estado_civil',['Soltero/a'=>'Soltero/a','Casado/a'=>'Casado/a','Viudo/a'=>'Viudo/a','Divorciado/a'=>'Divorciado/a','Separado/a'=>'Separado/a','Conviviente'=>'Conviviente'], $idr ,array('class'=>'form-control','style'=>'','id'=>'a_estado_civil')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección</label>
                                                        <input name='a_direccion' id='a_direccion' type="text" class="form-control"  value="{{ $arrendatario->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='a_numero' id='a_numero' class="form-control" type="text" placeholder="Dirección" value="{{ $arrendatario->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='a_departamento' id='a_departamento' class="form-control" type="text" value="{{ $arrendatario->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <input name='a_telefono' id='a_telefono' type="numero" class="form-control" class="form-control" value="{{ $arrendatario->telefono or '' }}" > </div>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <div>
                                                            <label>Email</label>
                                                            <input name='a_email' id='a_email' type="email" class="form-control"  value="{{ $arrendatario->email or '' }}" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @if(!isset($arrendatario->id_region))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $arrendatario->id_region; ?>
                                            @endif
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Región</label>
                                                        {{ Form::select('a_id_region',$regiones, $idr,array('class'=>'form-control','style'=>'','id'=>'a_id_region','placeholder'=>'Selecciona región')) }}
                                                    </div>
                                                </div>

                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia</label>
                                                        {{ Form::select('a_id_provincia',[''=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'a_id_provincia')) }} </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Comuna</label>
                                                        {{ Form::select('a_id_comuna',[''=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'a_id_comuna')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="section-iconbox-5">
                        @php
                        if(isset($aval->id)){
                        $idaval=$aval->id;
                        }else{
                        $idaval=0;
                        }

                        @endphp
                        <form action="{{ route('persona.update_postventa_v',$idaval) }}" method="post">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-warning">
                                        <div class="panel-heading"> Información del Aval</div>
                                        <div class="panel-body">


                                            <div class="row">
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="control-label">Rut</label>
                                                        <input type="text" name="v_rut" id="v_rut" class="form-control" placeholder=""  oninput='checkRut(this)' value='{{ $aval->rut or '' }}' > 
                                                        <input name='i_postventa_v' id='i_postventa_v' type="hidden" value='{{ $postventa->id}}'> 
                                                    </div>
                                                </div>

                                                <div class="col-md-10">
                                                </div>
                                            </div>

                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label">Nombre</label>
                                                        <input type="text" name="v_nombre" id="v_nombre"  class="form-control" placeholder="" required="required" value='{{ $aval->nombre or '' }}' > 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Paterno</label>
                                                        <input type="text" name="v_apellido_paterno" id="v_apellido_paterno" class="form-control" placeholder=""  value='{{ $aval->apellido_paterno or '' }}'> 
                                                    </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Apellido Materno</label>
                                                        <input type="text" name="v_apellido_materno" id="v_apellido_materno" class="form-control" placeholder=""  value='{{ $aval->apellido_materno or '' }}'>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Profesión / Ocupación</label>
                                                        <div id="profesion">
                                                            <input name='v_profesion' id='v_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $aval->profesion or ''}}"> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        @if(!isset($aval->estado_civil))
                                                        <?php $idr = null; ?>
                                                        @else
                                                        <?php $idr = $aval->estado_civil; ?>
                                                        @endif
                                                        <label>Estado civil</label>
                                                        {{ Form::select('v_estado_civil',['Soltero/a'=>'Soltero/a','Casado/a'=>'Casado/a','Viudo/a'=>'Viudo/a','Divorciado/a'=>'Divorciado/a','Separado/a'=>'Separado/a','Conviviente'=>'Conviviente'], $idr ,array('class'=>'form-control','style'=>'','id'=>'v_estado_civil')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label>Dirección</label>
                                                        <input name='v_direccion' id='v_direccion' type="text" class="form-control"  value="{{ $aval->direccion or '' }}" > </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Número</label>
                                                        <input name='v_numero' id='v_numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $aval->numero or '' }}" > 
                                                    </div>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <label>Departamento</label>
                                                        <input name='v_departamento' id='v_departamento' class="typeahead form-control" type="text" value="{{ $aval->departamento or ''}}" placeholder="Dirección" > 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <label>Teléfono</label>
                                                        <input name='v_telefono' id='v_telefono' type="numero" class="typeahead form-control" class="form-control" value="{{ $aval->telefono or '' }}" > </div>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <div >
                                                            <label>Email</label>
                                                            <input name='v_email' id='v_email' type="email" class="form-control"  value="{{ $aval->email or '' }}" >
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @if(!isset($aval->id_region))
                                            <?php $idr = null; ?>
                                            @else
                                            <?php $idr = $aval->id_region; ?>
                                            @endif
                                            <div class="row"> 
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Región</label>
                                                        {{ Form::select('v_id_region',$regiones, $idr,array('class'=>'form-control','style'=>'','id'=>'v_id_region','placeholder'=>'Selecciona región')) }}
                                                    </div>
                                                </div>

                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Provincia</label>
                                                        {{ Form::select('v_id_provincia',[''=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'v_id_provincia')) }} </div>
                                                </div>
                                                <!--/span-->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Comuna</label>
                                                        {{ Form::select('v_id_comuna',[''=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'v_id_comuna')) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="section-iconbox-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="white-box"> 
                                    <form action="{{ route('postventa.subir_documentos',$postventa->id) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <h3 class="box-title">Subir Documentos</h3>
                                        <label for="input-file-now-custom-1">Documentos de la publicación</label>
                                        <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                        <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Documento</button>

                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="white-box"> 


                                    <table id="ssss"  cellspacing="0" width="100%" style="border: 1px solid black;" >
                                        <thead>
                                            <tr>

                                                <th><center>Click Ver Documento</center></th>
                                        <th><center>Borrar</center></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($docs as $pi)
                                            <tr>
                                                <td  width="10px" height="10px" style="border: 1px solid black;" >
                                        <center>{{ $pi->direccion }}
                                            <br/>
                                            <b>{{ $pi->tipo }}</b>
                                            <br/>
                                            <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO {{ $pi->nombre }} </a></center>


                                        @can('postventa.edit')
                                        <td width="10px" style="border: 1px solid black;" >
                                        <center>
                                            <a href="{{ route('postventa.eliminardoc', [$pi->id,$postventa->id]) }}" 
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
                    <section id="section-iconbox-7">
                        <div class="row">
                            <div class="col-md-2">
                                <button class="btn btn-block btn-info" id='gestion' data-toggle="modal" data-target="#modal-gestion">Crear Gestión</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="listgestion" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tipo Contacto</th>
                                            <th>Contacto Con</th>
                                            <th>Gestionador</th>
                                            <th>Fecha / Hora Gestión</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gestion as $p)
                                        <tr>
                                            <td>{{ $p->id }}</td>
                                            <td>{{ $p->tipo_contacto }}</td>
                                            <td>{{ $p->contacto_con }}</td>
                                            <td>{{ $p->Gestionador }}</td>
                                            <td>{{ $p->fecha_gestion }} {{ $p->hora_gestion }}</td>
                                            @can('postventa.edit')
                                            <td >
          
                                                    <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>

                                                    <a href="/postventa/eliminargestion/{{ $p->id }}"><span class="btn btn-danger btn-circle btn-lg"><i class="ti-trash"></i></span></a>

                    
                                       

                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                <!-- MODAL GESTION CREAR -->
                                <div id="modal-gestion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Ingrese información de la gestión</h4> </div>
                                            <form id="form1" action="{{ route('postventa.creargestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" class="form-control" name="id_solicitud_gestion" id="id_solicitud_gestion" value="{{ $postventa->id }}">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Gestionador</label>
                                                            <select name="gestionador" id=gestionador class='form-control' required="required">
                                                                   <option value="">Seleccione</option>
                                                                                @foreach($empleados as $e )
                                                                                <option value="{{ $e->id }}" >{{ $e->empleado }}</option>
                                                                                @endforeach
                                                            </select>
                                                        </div>
                                                       <div class="col-md-3">
                                                            <label>Tipo de Contacto</label>
                                                            <select name="tipo_contacto" id=tipo_contacto class='form-control' required="required">
                                                                <option value="">Seleccione</option>
                                                                <option value="Información Inicial">Información Inicial</option>
                                                                <option value="Detectar Responsable">Detectar Responsable</option>
                                                                <option value="Seguimiento">Seguimiento</option>
                                                                <option value="Reinsistir">Reinsistir</option>
                                                                <option value="Información de Cierre">Información de Cierre</option>
                                                                <option value="Otro">Otro</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Contacto con </label>
                                                            <select name="contacto_con" id=contacto_con class='form-control' required="required">
                                                                <option value="">Seleccione</option>
                                                                <option value="Arrendatario">Arrendatario</option>
                                                                <option value="Propietarios">Propietario</option>
                                                                <option value="Propietarios">Administración</option>
                                                                <option value="Proveedor">Proveedor</option>
                                                                <option value="Empresa de Servicios">Empresa de Servicio</option>
                                                                <option value="Empresa de Garantía">Empresa de Garantía</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Fecha/Hora de Contacto</label>
                                                            <div class="input-group">
                                                                @php
                                                                $hoy = date("Y-m-d"); 
                                                                $hora=date("G:i"); 
                                                                @endphp
                                                                <input type="date" autocomplete="off" class="form-control" id="fecha_gestion" name="fecha_gestion" required="required" value="{{ $hoy }}"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" id="hora_gestion" placeholder="HH:MM" required="required" value="{{ $hora }}" > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Información adicional del Contacto</label>
                                                            <div class="form-group">
                                                                <input type="text" name="detalle_contacto" id="detalle_contacto" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detalle_gestion" class="control-label">Detalle de la gestión</label>
                                                                <textarea class="form-control" name="detalle_gestion" id="detalle_gestion" cols="25" rows="10" class="form-control" required="required"></textarea>
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
                                <!-- FIN MODAL GESTION CREAR -->
                                <!-- MODAL GESTION UPDATE -->
                                <div id="modal-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Actualice información de la gestión</h4> </div>
                                            <form id="form1" action="{{ route('postventa.updategestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                <input type="hidden" class="form-control" name="id_solicitud_gestion" id="e_id_solicitud_gestion" value="{{ $postventa->id }}">
                                                <input type="hidden" class="form-control" name="id_gestion" id="e_id_gestion">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Gestionador</label>
                                                            <select name="gestionador" id=e_gestionador class='form-control' required="required">
                                                                   <option value="">Seleccione</option>
                                                                                @foreach($empleados as $e )
                                                                                <option value="{{ $e->id }}" >{{ $e->empleado }}</option>
                                                                                @endforeach
                                                            </select>
                                                        </div>
                                                       <div class="col-md-3">
                                                            <label>Tipo de Contacto</label>
                                                            <select name="tipo_contacto" id=e_tipo_contacto class='form-control' required="required">
                                                                <option value="">Seleccione</option>
                                                                <option value="Información Inicial">Información Inicial</option>
                                                                <option value="Detectar Responsable">Detectar Responsable</option>
                                                                <option value="Seguimiento">Seguimiento</option>
                                                                <option value="Reinsistir">Reinsistir</option>
                                                                <option value="Información de Cierre">Información de Cierre</option>
                                                                <option value="Otro">Otro</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label>Contacto con </label>
                                                            <select name="contacto_con" id=e_contacto_con class='form-control' required="required">
                                                                <option value="">Seleccione</option>
                                                                <option value="Arrendatario">Arrendatario</option>
                                                                <option value="Propietarios">Propietario</option>
                                                                <option value="Propietarios">Administración</option>
                                                                <option value="Proveedor">Proveedor</option>
                                                                <option value="Empresa de Servicios">Empresa de Servicio</option>
                                                                <option value="Empresa de Garantía">Empresa de Garantía</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Fecha/Hora de Contacto</label>
                                                            <div class="input-group">
                                                           
                                                                <input type="date" autocomplete="off" class="form-control" id="e_fecha_gestion" name="fecha_gestion" required="required" > <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                                <div class="input-group clockpicker">
                                                                    <input type="time" class="form-control" name="hora_gestion" id="e_hora_gestion" placeholder="HH:MM" required="required"  > <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Información adicional del Contacto</label>
                                                            <div class="form-group">
                                                                <input type="text" name="detalle_contacto" id="e_detalle_contacto" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="detalle_gestion" class="control-label">Detalle de la gestión</label>
                                                                <textarea class="form-control" name="detalle_gestion" id="e_detalle_gestion" cols="25" rows="10" class="form-control" required="required"></textarea>
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
                                <!-- FIN MODAL GESTION CREAR -->
                            </div>
                        </div>
                    </section>
                    <section id="section-iconbox-8">
                        <form id="form1" action="{{ route('presupuesto.store') }}" method="post">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              {!! csrf_field() !!}
                              <input type="hidden" class="form-control" name="id_postventa_presupuesto" id="id_postventa_presupuesto" value="{{ $postventa->id }}">
                              <input type="hidden" class="form-control" name="id_inmueble_presupuesto" id="id_inmueble_presupuesto" value="{{ $postventa->id_inmueble }}">
                              <input type="hidden" class="form-control" name="id_propietario_presupuesto" id="id_propietario_presupuesto" value="{{ $postventa->id_propietario }}">
                              <input type="hidden" class="form-control" name="id_arrendatario_presupuesto" id="id_arrendatario_presupuesto" value="{{ $postventa->id_arrendatario }}">
                            <div class="row">
                                            <div class="col-md-3">
                                                <label>Responsable del pago</label>
                                                <select name="id_cobro" id="id_cobro" class="form-control" required="required">
                                                    <option value="">Seleccione</option>
                                                    <option value="1" <?= 1 == $postventa->id_cobro ? 'Selected' : ''; ?>>Propietario</option>
                                                    <option value="2" <?= 2 == $postventa->id_cobro ? 'Selected' : ''; ?>>Arrendatario</option>
                                                    <option value="3" <?= 3 == $postventa->id_cobro ? 'Selected' : ''; ?>>Baquedano</option>
                                                </select>
                                            </div>

                            <div class="col-md-2">
                                <label>&nbsp;</label>
                                <button class="btn btn-block btn-info" id='gestion' >Crear Presupuesto</button>
                            </div>
                        </div>
                       </form>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <table id="listgestion" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Responsable Pago</th>
                                            <th>Creador</th>
                                            <th>Fecha Creación</th>
                                            <th>Total</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($presupuestos as $p)
                                        <tr>
                                            <td>{{ $p->id }}</td>
                                            <td>{{ $p->responsable_pago }}</td>
                                            <td>{{ $p->Creador }}</td>
                                            <td>{{ $p->created_at }}</td>
                                            <td>{{ $p->total }}</td>
                                            <td>{{ $p->estado }}</td>
                                            @can('presupuesto.edit')
                                            <td >
                                                    <a href="/presupuesto/edit/{{ $p->id }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti-pencil"></i></span></a>

                                                    <a href="/postventa/eliminarpresupuesto/{{ $p->id }}"><span class="btn btn-danger btn-circle btn-lg"><i class="ti-trash"></i></span></a>
                                                <a href="/presupuesto/export/{{ $p->id }}"><span class="btn btn-info btn-circle btn-lg">P</span></a>

                                            </td>
                                            @endcan
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script >


 $('.dropify').dropify();

$(function() {
 


        @if(isset($propietario->id))
   
            @if(isset($propietario->id_region))
            $("#p_id_provincia").empty();
            $("#p_id_comuna").empty();
            $.get("/provincias/"+{{ $propietario->id_region or 0}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $propietario->id_provincia or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#p_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            @endif
            @if(isset($propietario->id_provincia))
            $.get("/comunas/"+{{ $propietario->id_provincia or 0 }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $propietario->id_comuna or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#p_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        @endif

         @if(isset($arrendatario->id))
   
            @if(isset($arrendatario->id_region))
            $("#a_id_provincia").empty();
            $("#a_id_comuna").empty();
            $.get("/provincias/"+{{ $arrendatario->id_region or 0}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $arrendatario->id_provincia or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#a_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            @endif
            @if(isset($propietario->id_provincia))
            $.get("/comunas/"+{{ $arrendatario->id_provincia or 0 }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $arrendatario->id_comuna or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#a_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        @endif


        @if(isset($aval->id))
   
            @if(isset($aval->id_region))
            $("#v_id_provincia").empty();
            $("#v_id_comuna").empty();
            $.get("/provincias/"+{{ $aval->id_region or 0}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $aval->id_provincia or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#v_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            @endif
            @if(isset($aval->id_provincia))
            $.get("/comunas/"+{{ $aval->id_provincia or 0 }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $aval->id_comuna or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#v_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        @endif

        @if(isset($inmueble->id))

            $("#i_id_provincia").empty();
            $("#i_id_comuna").empty();
            $.get("/provincias/"+{{ $inmueble->id_region or 0}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $inmueble->id_provincia or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_provincia").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $inmueble->id_provincia or 0 }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $inmueble->id_comuna or 0 }}){
                        sel=' selected="selected"';
                    }
                    $("#i_id_comuna").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
            @endif
        });


<?php
if($tab==2){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_2").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").addClass("content-current");
           }); 
<?php
}
?>


<?php
if($tab==3){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_3").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-3").addClass("content-current");
           }); 
<?php
}
?>

<?php
if($tab==4){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_4").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-4").addClass("content-current");
           }); 
<?php
}
?>

<?php
if($tab==5){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_5").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-5").addClass("content-current");
           }); 
<?php
}
?>
<?php
if($tab==6){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_6").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-6").addClass("content-current");
           }); 
<?php
}
?>
<?php
if($tab==7){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_7").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-7").addClass("content-current");
           }); 
<?php
}
?>
<?php
if($tab==8){
    ?>
    $(function() {

            $("#li_1").removeClass("tab-current");
            $("#li_8").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-8").addClass("content-current");
           }); 
<?php
}
?>


$("#li_1").click(function (event) {
            $("#li_1").addClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").addClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");

           
});
$("#li_2").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").addClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").addClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");
           
});
$("#li_3").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").addClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").addClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");
           
});
$("#li_4").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").addClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").addClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");
           
});
$("#li_5").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").addClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").addClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");

           
});
$("#li_6").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").addClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").addClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");

           
});
$("#li_7").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").addClass("tab-current");
            $("#li_8").removeClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").addClass("content-current"); 
            $("#section-iconbox-8").removeClass("content-current");
           
});
$("#li_8").click(function (event) {
            $("#li_1").removeClass("tab-current");
            $("#li_2").removeClass("tab-current");
            $("#li_3").removeClass("tab-current");
            $("#li_4").removeClass("tab-current");
            $("#li_5").removeClass("tab-current");
            $("#li_6").removeClass("tab-current");
            $("#li_7").removeClass("tab-current");
            $("#li_8").addClass("tab-current");
            $("#section-iconbox-1").removeClass("content-current");
            $("#section-iconbox-2").removeClass("content-current");
            $("#section-iconbox-3").removeClass("content-current");
            $("#section-iconbox-4").removeClass("content-current"); 
            $("#section-iconbox-5").removeClass("content-current");
            $("#section-iconbox-6").removeClass("content-current");
            $("#section-iconbox-7").removeClass("content-current"); 



           
});

</script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

<script>

$('#listgestion').DataTable({
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
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink | print preview fullpage | forecolor backcolor ",
            setup: function (editor) {
                editor.on('change', function (e) {
                    editor.save();
                });
            }
        });

    function mostrar_modal(obj){

    var url= "{{ URL::to('postventa/gestion')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
;
            $('#modal-edit').modal('show');
            $('#e_id_gestion').val(response.id);
            $('#e_gestionador').val(response.id_gestionador);
            $('#e_tipo_contacto').val(response.tipo_contacto);
            $('#e_contacto_con').val(response.contacto_con);
            $('#e_fecha_gestion').val(response.fecha_gestion);
            $('#e_hora_gestion').val(response.hora_gestion);
            $('#e_detalle_contacto').val(response.detalle_contacto);
            $('#e_detalle_gestion').val(response.detalle_gestion);
            tinyMCE.activeEditor.setContent(response.detalle_gestion);
        }
});
}

$("#v_id_region").change(function (event) {
    $("#v_id_provincia").empty();
    $("#v_id_comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#v_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#v_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#v_id_provincia").change(function (event) {
    $("#v_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#v_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#v_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});


$("#p_id_region").change(function (event) {
    $("#p_id_provincia").empty();
    $("#p_id_comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#p_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#p_id_provincia").change(function (event) {
    $("#p_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#p_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#p_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});


$("#a_id_region").change(function (event) {
    $("#a_id_provincia").empty();
    $("#a_id_comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#a_id_provincia").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#a_id_provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#a_id_provincia").change(function (event) {
    $("#a_id_comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#a_id_comuna").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#a_id_comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});
</script>
@endsection