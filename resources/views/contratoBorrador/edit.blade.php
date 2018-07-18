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
                        <li id="li_1_c"><a id="6" href="#section-iconbox-1_c" class="sticon ti-money"><span>Registro de Garantía</span></a></li>
                        <li id="li_6_c"><a id="6" href="#section-iconbox-6_c" class="sticon ti-money"><span>Simulación de Pago</span></a></li>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión Contrato Borrador</span></a></li>
                    </ul>
                </nav>
        
            <div class="content-wrap">

{{-- INICIO GARANTIA --}}
<section id="section-iconbox-1_c">
<div class="panel panel-info">
    <div class="panel-heading"> Registro de Garantía</div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
    <div class="panel-body">
        <form action="{{ route('borradorContrato.garantia',$borrador->id_publicacion) }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input-file-now-custom-1">Mes</label>
                            <select name="mes" class="form-control">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input-file-now-custom-1">Año</label>
                            <input name='ano' type="number" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="col-md-">
                        <div class="form-group">
                            <label>Banco</label>
                            <select class="form-control" name="banco" id="banco" >
                                <option value="">Selecione Banco</option>
                                <option value="Banco Bice">  Banco Bice  </option>
                                <option value="Banco BTG Pactual Chile">Banco BTG Pactual Chile</option>
                                <option value="Banco Consorcio">Banco Consorcio</option>
                                <option value="Banco de Chile, Edwards">Banco de Chile, Edwards</option>
                                <option value="Banco de Crédito e Inversiones">Banco de Crédito e Inversiones</option>
                                <option value="Banco de la Nacion Argentina">Banco de la Nacion Argentina</option>
                                <option value="Banco Falabella">Banco Falabella</option>
                                <option value="Banco Internacional">Banco Internacional</option>
                                <option value="Banco Itaú Chile">Banco Itaú Chile</option>
                                <option value="Banco Paris">Banco Paris</option>
                                <option value="Banco Penta">Banco Penta</option>
                                <option value="Banco RIpley">Banco RIpley</option>
                                <option value="Banco Santander">Banco Santander</option>
                                <option value="Banco Security">Banco Security</option>
                                <option value="BBVA">BBVA</option>
                                <option value="Deutsche Bank">Deutsche Bank</option>
                                <option value="HSBC Bank (Chile)">HSBC Bank (Chile)</option>
                                <option value="JP Morgan Chase Bank">JP Morgan Chase Bank</option>
                                <option value="Rabobank Chile">Rabobank Chile</option>
                                <option value="Scotiabank Chile">Scotiabank Chile</option>
                                <option value="The Bank of Tokyo">The Bank of Tokyo</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input-file-now-custom-1">N° Cheque/Deposito</label>
                            <input name='numero' type="number" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="input-file-now-custom-1">Valor</label>
                            <input name='valor' type="number" class="form-control" required="required">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group">
                            <label>Fecha de Cobro</label>
                            <input autocomplete="off" class="form-control datepicker-fecha_contacto1_c" id="datepicker-fecha_contacto1_c" name="fecha_cobro" placeholder="dd/mm/yyyy" required="required" type="text"><span class="input-group-addon"><i class="icon-calender"></i></span></input>
                        </div>
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Ingresar Garantía</button>
                    </div>
                </div>
            </div>
        </form>

        <table id="listusers1_c" class="display compact" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>Banco</th>
                    <th>N° Cheque/Deposito</th>
                    <th>Monto</th>
                    <th>Fecha Cobro</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($garantias as $p)
                    <tr>
                        <td>{{ $p->mes }}</td>
                        <td>{{ $p->ano }}</td>
                        <td>{{ $p->banco }}</td>
                        <td>{{ $p->numero }}</td>
                        <td>$ {{ $p->valor }}</td>
                        <td>{{ $p->fecha_cobro }}</td>
                        <td><a href="{{ route('borradorContrato.eliminarGarantia',[$p->id, $borrador->id_publicacion]) }}"><span class="ti-trash"></span></span></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>             
</div>
                        
</section>
{{-- FIN INICIO GARANTIA --}}



<section id="section-iconbox-6_c">
                    <div class="panel panel-info">
                            <div class="panel-heading"> Simulación de Pagos</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('borradorContrato.generarpagos',[$borrador->id_publicacion]) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}">
                                        <div class="form-body">
                                            <div class="row">
                                                
                                                    <h3 class="box-title m-b-0">Complete Campos generales para generar simulación de pagos</h3><br/>
                                                    <div class="row">
                                            
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Meses</label>
                                                        <input type="number" name="cant_meses" id="cant_meses" value="12" class="form-control" required="required">
                                                    </div>
                                                </div>
                                                 <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Proporcional</label>
                                                        <select name="proporcional" class="form-control">
                                                            <option value="NO">NO</option>
                                                            <option value="SI">SI</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                 <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Tipo Propuesta</label>
                                                        <select name="propuesta"  id="propuesta" class="form-control" required="required">
                                                            <option value="">Seleccione Propuesta</option>
                                                            <option value="1">1 Cuota</option>
                                                            <option value="2">Pie + Cuotas</option>
                                                            <option value="3">Renovación</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Fecha Inicio Contrato</label>
                                                        <input type="date" name="fecha_firmapago" id="fecha_firmapago" class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                        <div class="form-group">
                                                        <label for="input-file-now-custom-1">Moneda</label>
                                                       <select class="form-control" name="moneda" required="required" >
                                                            <option value="CLP">CLP</option>
                                                            <option value="UF">UF</option>
                                                       </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                        <div class="form-group">
                                                        <label for="input-file-now-custom-1">Valor</label>
                                                       <input name='valormoneda' id='valormoneda' type="number" class="form-control" required="required" value='1'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                                <h3 class="box-title m-b-0">INFORMACIÓN PARA GENERAR PROPUESTA 1 CUOTA Y PIE + 11 CUOTAS</h3>
                                                <hr>
                                                 <div class="col-md-2">
                                                         <label >Canon de Arriendo</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='arriendo_sim' id='arriendo_sim' step="any" type="number" class="form-control" required="required" value="{{ $borrador->precio }}" >
                                                        </div>
                                                    </div>
                                                 <div class="col-md-2"> 
                                                    <label >Gasto común</label>
                                                  <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='gastocomun_sim' id='gastocomun_sim' type="number" class="form-control" required="required"  step="any" value="{{ $borrador->gastosComunes }}">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label >Gastos notariales</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='pagonotaria' id='pagonotaria' type="number" class="form-control"  placeholder="$" required="required" value="0">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                     <label>% de Descuento</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">%</span>
                                                            <input name='descuento' id='descuento' type="number" class="form-control"   step="any" required="required" value="0">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                     <label>Nro. Cuotas</label>
                                                        <div class="input-group"> 
                                                            <input name='cuotas' id='cuotas' type="number" class="form-control"   step="any" required="required">
                                                        </div>
                                                </div>
                                            </div>
                                                <hr>
                                            <div class="row">

                                                <div class="col-md-2">
                                                     <label>% IVA</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">%</span>
                                                            <input name='iva' id='iva' type="number" class="form-control"   step="any" required="required" value="0">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                     <label>% de Pie</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">%</span>
                                                            <input name='pie' id='pie' type="number" class="form-control"   step="any" value="0"  required="required">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                     <label>% Cobro Mensual</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">%</span>
                                                            <input name='cobromensual' id='cobromensual' type="number" class="form-control"   step="any" value="0" required="required">
                                                        </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <input name='nombre_otropago1' id='nombre_otropago1' type="text" class="form-control"   placeholder="Otro Pago 1"> </div>
                                                <div class="col-md-2">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='pagootro1' step="any" id='pagootro1' type="number" class="form-control"   placeholder="$">
                                                        </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <input name='nombre_otropago2' id='nombre_otropago2' type="text" class="form-control"   placeholder="Otro Pago 1"> </div>
                                                <div class="col-md-2">
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input name='pagootro2' step="any" id='pagootro2' type="number" class="form-control"   placeholder="$">
                                                        </div>
                                                </div>
                                                 <div class="col-md-2">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Generar Simulación</button>
                                                </div>
           
                                            </div>
                                            <hr>

                                        </div>
                                    </form>

<table id="listusers1_c" class="display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Propuesta</th>
                        <th>Fecha Inicio</th>
                        <th>Meses</th>
                        <th>Proporcional</th>
                        <th>$ Arriendo</th>
                        <th>% Descuento</th>
                        <th># Cuotas</th>
                        <th>% Iva</th>
                        <th>% Pie</th>
                        <th>% Mensual</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                            @foreach($propuestas as $p)
                                    <tr>
                                        <td>{{ $p->id }}</td>
                                <td>{{ $p->tipopropuesta }}</td>
                                <td>{{ $p->fecha_iniciocontrato }}</td>
                                <td>{{ $p->meses_contrato }}</td>
                                <td>{{ $p->proporcional }}</td>
                                <td>{{ $p->canondearriendo }}</td>
                                <td>{{ $p->descuento }}</td>
                               <td>{{ $p->nrocuotas }}</td>
                                <td>{{ $p->iva }}</td>
                                <td>{{ $p->pie }}</td>
                                <td>{{ $p->cobromensual }}</td>
                                <td><a href="{{ route('borradorContrato.excelsimulacion',$p->id) }}"><span class="ti-export"></span></span></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>

                                </div>
                                            <hr>
                                </div>
                           
                            </div>
                        
</section>
<section id="section-iconbox-5_c">
        <div class="panel panel-info">
            <div class="panel-heading"> Gestión Contrato Borrador</div>
        </div>

                        <form id="form1_a" action="{{ route('borradorContrato.crearBorrador') }}" method="post">                 
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}"">
                <input type="hidden" name="id_publicacion" value="{{ $borrador->id_publicacion }}">
                {!! csrf_field() !!}     

                <div class="row">
                    
                    <div class="col-lg-2 col-sm-3 col-xs-12">
                        <label>
                            Fecha Contrato
                        </label>
                        <div class="input-group">
                            <input autocomplete="off" class="form-control datepicker-fecha_contacto1_c" id="datepicker-fecha_contacto1_c" name="fecha_gestion" placeholder="dd/mm/yyyy" required="required" type="text">
                                <span class="input-group-addon">
                                    <i class="icon-calender">
                                    </i>
                                </span>
                            </input>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-12">
                        <label>
                            Valor Arriendo
                        </label>
                        <input class="form-control" name="valorarriendo" required="required" type="number">
                        </input>
                    </div>

                    <div class="col-lg-3 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">
                                Contrato
                            </label>
                            <select class="form-control" name="id_contrato" required="required">
                                <option value="">
                                    Selecione Contrato
                                </option>
                                @foreach($contrato as $p)
                                <option value="{{ $p->id }}">
                                    {{ $p->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-12">
                        <div class="form-group">
                            <label class="control-label">
                                Día de Pago
                            </label>
                            <select class="form-control" name="dia_pago" required="required">
                                <option value="">
                                    Selecione Día
                                </option>
                                <option value="1">
                                    1
                                </option>
                                <option value="2">
                                    2
                                </option>
                                <option value="3">
                                    3
                                </option>
                                <option value="4">
                                    4
                                </option>
                                <option value="5">
                                    5
                                </option>
                                <option value="6">
                                    6
                                </option>
                                <option value="7">
                                    7
                                </option>
                                <option value="8">
                                    8
                                </option>
                                <option value="9">
                                    9
                                </option>
                                <option value="10">
                                    10
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-3 col-xs-12">
                        <label>
                            &nbsp;
                        </label>
                        <button class="btn btn-success" type="submit">
                            <i class="fa fa-check">
                            </i>
                            Crear Borrador Arrendatario
                        </button>
                    </div>

                </div>

            </form>
            <hr>
            <div class="row">
                              <div class="col-md-3">
                                    <button class="btn btn-block btn-info"  id='updatepersona'data-toggle="modal" onclick="mostrar_modalpersona({{ $borrador->id_propietario }})" >Actualizar Propietario</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-block btn-success" id='updateinmueble' onclick="mostrar_modalinmueble({{ $borrador->id_inmueble }})" >Actualizar Inmueble</button>
                                </div>
                </div>
                            <hr>
                            <div class="row">
                                <form  action="{{ route('finalContrato.crearContrato') }}" method="post"> 
                                    {!! csrf_field() !!}  
                                <input type="hidden" name="id_creadorfinal" value="{{ Auth::user()->id }}">  
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label class="control-label">
                                                Propuesta
                                            </label>
                                            <select class="form-control" name="id_propuesta" required="required">
                                                <option value="">
                                                    Selecione Propuesta
                                                </option>
                                                @foreach($propuestas as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->id }} - {{ $p->tipopropuesta }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label class="control-label">
                                                Contrato Borrador
                                            </label>
                                            <select class="form-control" name="id_borradorfinal" required="required">
                                                <option value="">
                                                    Selecione Borrador
                                                </option>
                                                @foreach($borradoresIndex as $p)
                                                <option value="{{ $p->id }}">
                                                    {{ $p->id }}-{{ $p->fecha }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>
                                 <div class="col-md-4">
                                    <label class="control-label">
                                             
                                            </label>
                                    <div class="form-group">
                                              <button class="btn btn-success" type="submit">
                                            <i class="fa fa-check">
                                            </i>
                                            Pasar a Contrato Final
                                        </button>
                                        </div>
                                </div>
                            </form>
                         </div>
                        <hr>
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
                                @can('borradorContrato.edit')
                                    <td>
                                        <a href="{{ route('borradorContrato.mostrarGestion', $p->id) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="fa fa-check"></i></span></a>
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
                                                                                                                {{-- <input name='profesion' id='pe_profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" >  --}}
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
                                                             
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        <select class="form-control" name="banco" id="pe_banco" >
                                            <option value="">Selecione Banco</option>
                                            <option value=" Banco Bice  ">  Banco Bice  </option>
                                            <option value="Banco BTG Pactual Chile">Banco BTG Pactual Chile</option>
                                            <option value="Banco Consorcio">Banco Consorcio</option>
                                            <option value="Banco de Chile, Edwards">Banco de Chile, Edwards</option>
                                            <option value="Banco de Crédito e Inversiones">Banco de Crédito e Inversiones</option>
                                            <option value="Banco de la Nacion Argentina">Banco de la Nacion Argentina</option>
                                            <option value="Banco Falabella">Banco Falabella</option>
                                            <option value="Banco Internacional">Banco Internacional</option>
                                            <option value="Banco Itaú Chile">Banco Itaú Chile</option>
                                            <option value="Banco Paris">Banco Paris</option>
                                            <option value="Banco Penta">Banco Penta</option>
                                            <option value="Banco RIpley">Banco RIpley</option>
                                            <option value="Banco Santander">Banco Santander</option>
                                            <option value="Banco Security">Banco Security</option>
                                            <option value="BBVA">BBVA</option>
                                            <option value="Deutsche Bank">Deutsche Bank</option>
                                            <option value="HSBC Bank (Chile)">HSBC Bank (Chile)</option>
                                            <option value="JP Morgan Chase Bank">JP Morgan Chase Bank</option>
                                            <option value="Rabobank Chile">Rabobank Chile</option>
                                            <option value="Scotiabank Chile">Scotiabank Chile</option>
                                            <option value="The Bank of Tokyo">The Bank of Tokyo</option>
                                        </select>
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo de Cuenta</label>
                                        <select class="form-control" name="tipo_cuenta" id="pe_tipo_cuenta"  >
                                            <option value="">Selecione Tipo de Cuenta</option>
                                            <option value="Ahorro">Ahorro</option>
                                            <option value="Corriente">Corriente</option>
                                            <option value="Rut">Rut</option>
                                            <option value="Vista">Vista</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero de cuenta</label>
                                        <input name='cuenta' id='pe_cuenta' class="form-control" type="number" placeholder="Número de cuenta" >
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rut Titular</label>
                                        <input type="text" name="rut_titular" id="pe_rut_titular" class="form-control" placeholder="" oninput='checkRut(this)' >
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Titular</label>
                                        <input name='titular' id='pe_titular' class=" form-control" type="text" placeholder="Nombre Titular" > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    
                                </div>
                            </div>
                            <!--/row-->


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
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    jQuery('#datepicker-fecha_contacto1_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});
</script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

<script>

$(function(){

$("#propuesta").change(function (event) {
    if(this.value==1){
        $("#cuotas").val("");
        $("#iva").val("");
        $("#pie").val(0);
        $("#cobromensual").val(0);
    }
    if(this.value==2){
        $("#cuotas").val("");
        $("#iva").val(0);
        $("#pie").val("");
        $("#cobromensual").val("");
    }
});

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

});


// function mostrar_modal(obj){
//     var url= "{{ URL::to('borradorContrato/borradorC')}}"+"/"+obj;
//     $.ajax({
//         type:"get",
//         url:url,
//         data:"",
//         success:function(response){
//             $('#modal-contacto_edit_c').modal('show');
//             var d = response[0].fecha_gestion.split('-');
//             $('#datepicker-fecha_contacto1').val(d[2] + '-' + d[1] + '-' + d[0]);
//             $('#id_servicio_e').val(response[0].id_servicios);
//             $('#id_notaria_e').val(response[0].id_notaria);
//             $('#id_comision_e').val(response[0].id_comisiones);
//             $('#id_flexibilidad_e').val(response[0].id_flexibilidad);
//             $('#id_estado_e').val(response[0].id_estado);
//             $('#id_borrador_e').val(response[0].id);
//             $('#id_publicacion_e').val(response[0].id_publicacion);
//             $('#id_contrato_e').val(response[0].id_contrato);
//             $('#detalle_revision_e').val(response[0].detalle_revision);
//             tinyMCE.activeEditor.setContent(response[0].detalle_revision);
//         }
//     });
// }

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

            $('#pe_banco').val(response.banco);
            $('#pe_tipo_cuenta').val(response.tipo_cuenta);
            $('#pe_cuenta').val(response.cuenta);
            $('#pe_rut_titular').val(response.rut_titular);
            $('#pe_titular').val(response.titular);
            
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