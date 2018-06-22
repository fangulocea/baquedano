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
        @if(isset($borrador->direccion))
         <center><h3 class="box-title m-b-0">{{ $borrador->direccion or null }}</h3></center>
         @endif
          @if( isset($borrador->propietario) )
        <center><h3 class="box-title m-b-0">{{ $borrador->propietario or null }} </h3></center>
        <br><br>
        @endif
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión Contrato Borrador</span></a></li>
                    </ul>
                </nav>


            <form id="form1_a" action="{{ route('borradorContrato.crearBorrador') }}" method="post">                 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}"">
                <input type="hidden" name="id_publicacion" value="{{ $borrador->id_publicacion }}">
                             {!! csrf_field() !!}     
                   <div class="row">
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Comisiones</label>
                                        <select class="form-control" name="id_comisiones" required="required" >
                                            <option value="">Selecione comision</option>
                                            @foreach($comision as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select>
                                        {{-- <label class="control-label">Notaria</label>
                                        <select class="form-control" name="id_notaria" required="required" >
                                            <option value="">Selecione Notaria</option>
                                            @foreach($notaria as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Flexibilidad</label>
                                        <select class="form-control" name="id_flexibilidad" required="required" >
                                            <option value="">Selecione Flexibilidad</option>
                                            @foreach($flexibilidad as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select>
                                        {{-- <label class="control-label">Servicio</label>
                                        <select class="form-control" name="id_servicios" required="required" >
                                            <option value="">Selecione Servicio</option>
                                            @foreach($servicio as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select> --}}
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label">Contrato</label>
                                        <select class="form-control" name="id_contrato" required="required" >
                                            <option value="">Selecione Contrato</option>
                                            @foreach($contrato as $p)
                                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                            @endforeach   
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <div class="form-group">
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <label>Fecha</label>
                                    <div class="input-group">
                                        <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_c" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1_c" name="fecha_gestion" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                    </div>
                                </div>
                                <div class="col-lg-2 col-sm-3 col-xs-12">
                                    <label>Crar Borrador</label>
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                </div>
                    </div>
            </form>

                            <div class="content-wrap">
                    <section id="section-iconbox-5_c">
                              <div class="col-lg-4 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-info"  id='updatepersona'data-toggle="modal" onclick="mostrar_modalpersona({{ $borrador->id_propietario }})" >Actualizar Propietario</button>
                                </div>
                                <div class="col-lg-4 col-sm-3 col-xs-12">
                                    <button class="btn btn-block btn-success" id='updateinmueble' onclick="mostrar_modalinmueble({{ $borrador->id_inmueble }})" >Actualizar Inmueble</button>
                                </div>
                            <br/><br/>
                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Comisión</th>
                        <th>Flexibilidad</th>
                        <th>Estado</th>
                        <th>Editar</th>
                        <th>Correo</th>
                        <th>Ver Pdf</th>
                    </tr>
                </thead>
                <tbody>
                            @foreach($borradoresIndex as $p)
                                    <tr>
                                {{-- <td style="background: #ff7676; color:white">{{ $p->id_publicacion }}</td> --}}
                                <td>{{ $p->id }}</td>
                                <td >{{ $p->fecha }}</td>
                                <td>{{ $p->n_c }}</td>
                                <td>{{ $p->n_f }}</td>
                                <td>{{ trans_choice('mensajes.borrador', $p->id_estado) }}</td>
                                @can('revisioncomercial.edit')
                                    <td>
                                        <button class="btn btn-success btn-circle btn-lg" id='via_edit' onclick="mostrar_modal({{ $p->id }})" ><i class="fa fa-check"></i></span></button>
                                    </td>
                                @endcan
                                @can('borradorContrato.mail')
                                    <td>
                                        <a href="{{ route('borradorContrato.mail', $p->id) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti ti-email"></i></span></a>
                                    </td>
                                @endcan
                                   <td>
                                        <a href="{{asset('uploads/pdf/'.$p->nombre)}}" target="_blank"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                    </td>
                            </tr>
                            @endforeach

                            <!-- MODAL GESTION UPDATE -->
                                    <div id="modal-contacto_edit_c" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice sssu información de contacto</h4> </div>


                                                 <form id="form1_e" action="{{ route('borradorContrato.editarGestion') }}" method="post">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                {!! csrf_field() !!}
                                                    <input type="hidden" class="form-control" name="id_modificador" id="id_modificador_e" value="{{ Auth::user()->id }}">
                                                    <input type="hidden" class="form-control" name="id_borrador" id="id_borrador_e">
                                                    <input type="hidden" class="form-control" name="id_publicacion" id="id_publicacion_e">
                                                    <div class="modal-body">

                                        <div class="row">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label">Comision</label>
                                                    <select class="form-control" id="id_comision_e" name="id_comision_m" required="required" >
                                                        <option value="">Selecione Comision</option>
                                                        @foreach($comision as $p)
                                                             <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select>
                                                    {{-- <label class="control-label">Notaria</label>
                                                    <select class="form-control" id="id_notaria_e" name="id_notaria_m" required="required" >
                                                        <option value="">Selecione Servicio</option>
                                                        @foreach($notaria as $p)
                                                             <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label">Flexibilidad</label>
                                                    <select class="form-control" id="id_flexibilidad_e" name="id_flexibilidad_m" required="required" >
                                                        <option value="">Selecione Flexibilidad</option>
                                                        @foreach($flexibilidad as $p)
                                                            <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select>
                                                    {{-- <label class="control-label">Servicio</label>
                                                    <select class="form-control" id="id_servicio_e" name="id_servicios_m" required="required" >
                                                        <option value="">Selecione Servicio</option>
                                                        @foreach($servicio as $p)
                                                            <option value="{{ $p->id }}" >{{ $p->nombre }}</option>
                                                        @endforeach   
                                                    </select> --}}
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label">Contrato</label>
                                                    <select class="form-control" id="id_contrato_e" name="id_contrato_m" required="required" >
                                                        <option value="">Selecione Contrato</option>
                                                        @foreach($contrato as $p)
                                                            <option value="{{ $p->id }}">{{ $p->nombre }}</option>
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
                                                <label>Fecha</label>
                                                <div class="input-group">
                                                    <input type="text" autocomplete="off" class="form-control datepicker-fecha_contacto1_contrato" placeholder="dd/mm/yyyy" id="datepicker-fecha_contacto1" name="fecha_gestion_m" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> 
                                                </div>
                                            </div>

                                            <div class="col-sm-3">
                                                <label>Estado</label>
                                                <div class="input-group">
                                                    <select class="form-control" id="id_estado_e" name="id_estado_m" required="required" >
                                                        <option value="">Selecione Estado</option>    
                                                            <option value="0" >Rechazdo</option>
                                                            <option value="1" >Vigente</option>
                                                            <option value="2" >Correo Enviado</option>
                                                            <option value="3" >Reenvío Correo</option>
                                                    </select> 
                                                </div>
                                            </div>                                            
                                        </div>

                                        <div class="form-group">
                                            <label for="detalle_contacto" class="control-label">Detalle:</label>
                                                <textarea class="form-control" name="detalle_revision_m" id="detalle_revision_e" cols="25" rows="10" class="form-control" required="required"></textarea>
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

                                    <!-- MODAL ACTUALIZAR PERSONA -->
                                    <div id="modal-updatepersona" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice información del propietario</h4> </div>

                                                        <form action="{{ route('borradorContrato.updatepersona') }}" method="post" id="form_persona" >
                                                             {!! csrf_field() !!}
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="id_persona" id="id_persona" >
                                                            <input type="hidden" name="id_publicacion"  id="id_publicacion" value="{{ $borrador->id_publicacion}}">
                                                           <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="panel panel-info">
                                                                        <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                            <div class="panel-body">
                                                                                    <div class="form-body">
  
                                                                                        <div class="row">
                                                                                         <div class="col-md-2">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Rut</label>
                                                                                                    <input type="text" name="rut" class="form-control" id="pe_rut" > 
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label class="control-label">Nombre</label>
                                                                                                    <input type="text" name="nombre" class="form-control" placeholder="" required="required" id="pe_nombre"> 
                                                                                                 </div>
                                                                                            </div>
                                                                                            <!--/span-->
                                                                                            <div class="col-md-3">
                                                                                                <div class="form-group">
                                                                                                    <label>Apellido Paterno</label>
                                                                                                    <input type="text" name="apellido_paterno" id="pe_apellido_paterno" class="form-control" placeholder=""  > 
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--/span-->
                                                                                             <div class="col-md-3">
                                                                                                <div class="form-group">
                                                                                                    <label>Apellido Materno</label>
                                                                                                    <input type="text" name="apellido_materno" id="pe_apellido_materno" class="form-control" placeholder=""  >
                                                                                                    </div>
                                                                                            </div>
                                                                                        </div>
                                                                                         <div class="row">
                                                                                            <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Profesión / Ocupación</label>
                                                                                                    <div id="profesion">
                                                                                                                <input name='profesion' id='pe_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" > 
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>
                                                                                              <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Estado civíl</label>
                                                                                                       <select class="form-control" name="estado_civil" id="pe_estado_civil"  >
                                                                                                        <option value="">Selecione Estado Civil</option>
                                                                                                        <option value="Soltero/a">Soltero/a</option>
                                                                                                        <option value="Casado/a">Casado/a</option>
                                                                                                        <option value="Viudo/a">Viudo/a</option>
                                                                                                        <option value="Divorciado/a">Divorciado/a</option>
                                                                                                        <option value="Separado/a">Separado/a</option>
                                                                                                        <option value="Conviviente">Conviviente</option>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                              <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Teléfono</label>
                                                                                                        <input name='telefono' id='pe_telefono' class="form-control" type="text"  > 
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Email</label>
                                                                                                    <input name="email" id='pe_email'  type="text" class="form-control" > </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="row">
                                                                                            <div class="col-md-6 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Dirección</label>
                                                                                                    <div id="direcciones">
                                                                                                                <input name='direccion' id='pe_direccion' type="text" placeholder="Dirección" class="form-control"  > 
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>
                                                                                              <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Número</label>
                                                                                                        <input name='numero' id='pe_numero' class="form-control" type="text"  > 
                                                                                                </div>
                                                                                            </div>
                                                                                              <div class="col-md-3 ">
                                                                                                <div class="form-group">
                                                                                                    <label>Departamento</label>
                                                                                                        <input name='departamento' id='pe_departamento' class=" form-control" type="text"  > 
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row"> 
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Región</label>
                                                                                                    <select name="id_region" id="pe_region" class=" form-control" >
                                                                                                        
                                                                                                    </select>
                                                                                                 </div>
                                                                                            </div>

                                                                                            <!--/span-->
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Provincia</label>
                                                                                                     <select name="id_provincia" id="pe_provincia" class=" form-control"  >
                                                                                                        
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--/span-->
                                                                                             <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Comuna</label>
                                                                                                <select name="id_comuna" id="pe_comuna" class=" form-control"  >
                                                                                                        
                                                                                                    </select>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </div>
                                                             

                                                                                    </div>
                                                                                    <div class="form-actions">
                                                                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>

                                                                                    </div>
                                                                               
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                  </form>
                                                </div>
                                            </div>
                                    </div>
                                    <!-- FIN MODAL PERSONA -->
                                    <!-- MODAL ACTUALIZAR INMUEBLE -->
                                    <div id="modal-updateinmueble" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                        <h4 class="modal-title">Actualice información del inmueble</h4> </div>
                                                    <form action="{{ route('borradorContrato.updateinmueble') }}" method="post" id="form_inmueble" >
                                                             {!! csrf_field() !!}
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="id_inmueble" id="id_inmueble" >
                                                            <input type="hidden" name="id_publicacion"  id="id_publicacion" value="{{ $borrador->id_publicacion}}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                           <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="panel panel-info">
                                                                    <div class="panel-wrapper collapse in" aria-expanded="true">
                                                                        <div class="panel-body">
                                                                            <form action="{{ route('inmueble.store') }}" method="post">

                                                                                <div class="form-body">
                                                                                    <div class="row"> 
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                 
                                                                                                    <label>Dirección</label>
                                                                                                    <div id="direcciones">
                                                                                                            <input name='direccion' id='in_direccion' class="typeahead form-control" type="text" placeholder="Dirección" required="required"> 
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                               
                                                                                                <label>Nro.</label>
                                                                                                <input name='numero' id='in_numero' type="text" class="form-control" > </div>
                                                                                            
                                                                                        </div>
                                                                                         <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                               
                                                                                                <label>Departamento</label>
                                                                                                <input name='departamento' id='in_departamento' type="text" class="form-control" > </div>
                                                                                            
                                                                                        </div>
                                                                                         <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                               
                                                                                                <label>Rol</label>
                                                                                                <input name='rol'  id='in_rol'  type="text" class="form-control" > </div>
                                                                                            
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row"> 
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                 
                                                                                                    <label>Referencias de la dirección</label>
                                                                                                    <div id="referencia">
                                                                                                            <input name='referencia' id='in_referencia' class="form-control" type="text" placeholder="Referencia" > 
                                                                                                    </div>
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                        <div class="row"> 
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Región</label>
                                                                                                    <select name="id_region" id="in_region" class=" form-control" >
                                                                                                        
                                                                                                    </select>
                                                                                                 </div>
                                                                                            </div>

                                                                                            <!--/span-->
                                                                                            <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Provincia</label>
                                                                                                     <select name="id_provincia" id="in_provincia" class=" form-control"  >
                                                                                                        
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                            <!--/span-->
                                                                                             <div class="col-md-4">
                                                                                                <div class="form-group">
                                                                                                    <label>Comuna</label>
                                                                                                <select name="id_comuna" id="in_comuna" class=" form-control"  >
                                                                                                        
                                                                                                    </select>
                                                                                                    </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <div class="row"> 
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Dormitorio</label>
                                                                                                <input name='dormitorio' id='in_dormitorio' type="number" class="form-control" required="required"> </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Baños</label>
                                                                                                <input name='bano' id='in_bano' type="number" class="form-control" required="required"> 
                                                                                            </div>
                                                                                        </div>
                                                                                        <!--/span-->
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Estacionamiento</label>
                                                                                                <input name='estacionamiento' id='in_estacionamiento' type="number" class="form-control" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Bodega</label>
                                                                                                <select class="form-control" name="bodega" id="in_bodega"  >
                                                                                                    <option value="">Sel. Opción</option>
                                                                                                    <option value="1">SI</option>
                                                                                                    <option value="0">NO</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Nro.Bodega</label>
                                                                                                <input name='nro_bodega' id='in_nro_bodega' type="number" class="form-control" >
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-2">
                                                                                            <div class="form-group">
                                                                                                <label>Piscina</label>
                                                                                                <select class="form-control" name="piscina"  id="in_piscina" >
                                                                                                    <option value="">Sel. Opción</option>
                                                                                                    <option value="SI">SI</option>
                                                                                                    <option value="NO">NO</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row"> 
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label>Gasto Común</label>
                                                                                                <div class="input-group"> 
                                                                                                    <span class="input-group-addon">$</span>
                                                                                                    <input name='gastosComunes' id='in_gastosComunes' type="number" class="form-control" >
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label>Precio</label>
                                                                                                <div class="input-group"> 
                                                                                                    <span class="input-group-addon">$</span>
                                                                                                    <input name='precio' id='in_precio'  type="number" class="form-control" required="required">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                       <div class="col-md-4">
                                                                                            <div class="form-group">
                                                                                                <label>Condición</label>
                                                                                                <select class="form-control" name="condicion" id="in_condicion"  required="required">
                                                                                                    <option value="">Seleccione Condición</option>
                                                                                                    <option value="Nuevo">Nuevo</option>
                                                                                                    <option value="Usado">Usado</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-actions">
                                                                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>

                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                        
                                                    </form>

                                                 
                                                </div>
                                            </div>
                                    </div>
                                    <!-- FIN MODAL INMUEBLE -->


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
  <a href="{{ route('borradorContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
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

    
        $('#modal-contacto1_c').on('hidden.bs.modal', function () {
        $("#form1_c")[0].reset();
    });

        $('#modal-contacto1_c').on('shown.bs.modal', function () {
        $("#form1_c")[0].reset();
    });
    


        $('#modal-updatepersona').on('hidden.bs.modal', function () {
        $("#form_persona")[0].reset();
    });


    $('#modal-updateinmueble').on('hidden.bs.modal', function () {
        $("#form_inmueble")[0].reset();
    });


    //     $('#modal-contacto_edit_c').on('hidden.bs.modal', function () {
    //     $("#form1_e")[0].reset();
    // });

});

    lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true
    })



function mostrar_modal(obj){
    var url= "{{ URL::to('borradorContrato/borradorC')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-contacto_edit_c').modal('show');
            var d = response[0].fecha_gestion.split('-');
            $('#datepicker-fecha_contacto1').val(d[2] + '-' + d[1] + '-' + d[0]);
            $('#id_servicio_e').val(response[0].id_servicios);
            $('#id_notaria_e').val(response[0].id_notaria);
            $('#id_comision_e').val(response[0].id_comisiones);
            $('#id_flexibilidad_e').val(response[0].id_flexibilidad);
            $('#id_estado_e').val(response[0].id_estado);
            $('#id_borrador_e').val(response[0].id);
            $('#id_publicacion_e').val(response[0].id_publicacion);
            $('#id_contrato_e').val(response[0].id_contrato);
            $('#detalle_revision_e').val(response[0].detalle_revision);
            tinyMCE.activeEditor.setContent(response[0].detalle_revision);
        }
    });
}



function mostrar_modalpersona(obj){
    var url= "{{ URL::to('persona/contratoborrador')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-updatepersona').modal('show');
            $('#id_persona').val(response.id);
            $('#pe_rut').val(response.rut);
            $('#pe_nombre').val(response.nombre);
            $('#pe_apellido_paterno').val(response.apellido_paterno);
            $('#pe_apellido_materno').val(response.apellido_materno);
            $('#pe_direccion').val(response.direccion);
            $('#pe_numero').val(response.numero);
            $('#pe_profesion').val(response.profesion);
            $('#pe_estado_civil').val(response.estado_civil);
            $('#pe_departamento').val(response.departamento);
            $('#pe_telefono').val(response.telefono);
            $('#pe_email').val(response.email);
            $("#pe_provincia").empty();
            $("#pe_comuna").empty();
            $("#pe_region").empty();
            $.get("/regiones/todas",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].region_id==response.id_region){
                        sel=' selected="selected"';
                    }
                    $("#pe_region").append("<option value='"+response1[i].region_id+"' "+sel+">"+response1[i].region_nombre+"</option>");
                }
            });
            $.get("/provincias/"+response.id_region+"",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].provincia_id==response.id_provincia){
                        sel=' selected="selected"';
                    }
                    $("#pe_provincia").append("<option value='"+response1[i].provincia_id+"' "+sel+">"+response1[i].provincia_nombre+"</option>");
                }
            });
            $.get("/comunas/"+response.id_provincia +"",function(response2,state){
                for(i=0; i< response2.length;i++){
                    sel='';
                    if(response2[i].comuna_id==response.id_comuna){
                        sel=' selected="selected"';
                    }
                    $("#pe_comuna").append("<option value='"+response2[i].comuna_id+"' "+sel+">"+response2[i].comuna_nombre+"</option>");
                }
            });
        }
    });
}


function mostrar_modalinmueble(obj){
    var url= "{{ URL::to('inmueble/contratoborrador')}}"+"/"+obj;
    $.ajax({
        type:"get",
        url:url,
        data:"",
        success:function(response){
            $('#modal-updateinmueble').modal('show');
            $('#id_inmueble').val(response.id);
            $('#in_direccion').val(response.direccion);
            $('#in_condicion').val(response.condicion);
            $('#in_numero').val(response.numero);
            $('#in_departamento').val(response.departamento);
            $('#in_dormitorio').val(response.dormitorio);
            $('#in_rol').val(response.rol);
            $('#in_bano').val(response.bano);
            $('#in_estacionamiento').val(response.estacionamiento);
            $('#in_referencia').val(response.referencia);
            $('#in_bodega').val(response.bodega);
            $('#in_nro_bodega').val(response.nro_bodega);
            $('#in_piscina').val(response.piscina);
            $('#in_precio').val(response.precio);
            $('#in_gastosComunes').val(response.gastosComunes);
            $("#in_provincia").empty();
            $("#in_comuna").empty();
            $("#in_region").empty();
            $.get("/regiones/todas",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].region_id==response.id_region){
                        sel=' selected="selected"';
                    }
                    $("#in_region").append("<option value='"+response1[i].region_id+"' "+sel+">"+response1[i].region_nombre+"</option>");
                }
            });
            $.get("/provincias/"+response.id_region+"",function(response1,state){
                for(i=0; i< response1.length;i++){
                    sel='';
                    if(response1[i].provincia_id==response.id_provincia){
                        sel=' selected="selected"';
                    }
                    $("#in_provincia").append("<option value='"+response1[i].provincia_id+"' "+sel+">"+response1[i].provincia_nombre+"</option>");
                }
            });
            $.get("/comunas/"+response.id_provincia +"",function(response2,state){
                for(i=0; i< response2.length;i++){
                    sel='';
                    if(response2[i].comuna_id==response.id_comuna){
                        sel=' selected="selected"';
                    }
                    $("#in_comuna").append("<option value='"+response2[i].comuna_id+"' "+sel+">"+response2[i].comuna_nombre+"</option>");
                }
            });
        }
    });
}
$('#listusers1_c').DataTable({
    dom: 'Bfrtip',
    buttons: [ ],
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