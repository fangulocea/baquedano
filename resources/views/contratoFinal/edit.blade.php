@extends('admin.layout')

@section('contenido')

<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

@php 
use App\Http\Controllers\ContratoFinalController;
@endphp

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
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión</span></a></li>
                        <li id="li_4_c"><a id="4" href="#section-iconbox-4_c" class="sticon ti-home"><span>Inmuebles</span></a></li>
                        <li id="li_6_c"><a id="6" href="#section-iconbox-6_c" class="sticon ti-agenda"><span>Documentos</span></a></li>
                        <li id="li_7_c"><a id="7" href="#section-iconbox-7_c" class="sticon ti-agenda"><span>Generación de Pagos</span></a></li>
                        <li id="li_8_c"><a id="8" href="#section-iconbox-8_c" class="sticon ti-money"><span>Items de Pagos Mensuales</span></a></li>
                        <li id="li_9_c"><a id="8" href="#section-iconbox-9_c" class="sticon ti-money"><span>Gestionar Pago Mensual</span></a></li>

                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-5_c">

                        <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Estado</th>
                                    <th>Ver Pdf</th>
                                    <th>Alias</th>
                                    <th>Notaria</th>
                                    <th>Fecha Firma</th>
                                    <th>Guardar</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($finalIndex as $p)
                                <tr>
                            <form id="form1_a" action="{{ route('finalContrato.asignarNotaria',$p->id) }}" method="post">                 
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id_modificador" value="{{ Auth::user()->id }}"">
                                <input type="hidden" name="id_publicacion" value="{{ $p->id_publicacion }}"">
                                <input type="hidden" name="id_borrador" value="{{ $p->id_borrador }}"">
                                <input type="hidden" name="id_pdf" value="{{ $p->id_pdf }}">
                                @if($p->id_estado>1)
                                <?php $flag = 1; ?>
                                @endif


                                <td>{{ $p->id }}</td>
                                <td>{{ trans_choice('mensajes.contratofinal', $p->id_estado) }}</td>
                                <td>
                                    <a href="{{asset('uploads/pdf_final/'.$p->nombre)}}" target="_blank"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                </td>  
                                <td>
                                    <input type="text" name="alias" id="alias" value='{{ $p->alias }}' class="form-control" required="required">
                                </td>
                                <td>
                                    <select class="form-control" name="id_notaria" required="required" >
                                        <option value="">Selecione Notaria</option>
                                        @foreach($notaria as $n)
                                        @if($n->id==$p->id_notaria)
                                        <option value="{{ $n->id }}" selected>{{ $n->nombre }} </option>
                                        @else
                                        <option value="{{ $n->id }}">{{ $n->nombre }} </option>
                                        @endif
                                        @endforeach   
                                    </select> 
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="fecha_firma" id="fecha_firma" value='{{ $p->fecha }}' required="required">
                                </td>
                                <td>
                                    @if(ContratoFinalController::ValidaCh($p->id) == 0)
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    @else
                                        <a href="{{ route('finalContrato.muestra_cheque',[$p->id,$p->id_pdf,$p->dia_pago]) }}"> <button type="button" class="btn btn-danger"> <i class="fa fa-check"></i> N° Cheques</button></a>
                                    @endif
                                    
                                </td>
                                <td>
                                    <a href="{{ route('finalContrato.destroy',[$p->id,$p->id_pdf]) }}"> <button type="button" class="btn btn-danger"> <i class="fa fa-check"></i> Eliminar</button></a>
                                </td>
                            </form>
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                        <input type="hidden" name="verifica_estado" id="verifica_estado" value="{{ $flag }}">
                    </section>

                    <section id="section-iconbox-4_c">
                        <div class="form-body">
                            <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="input-file-now-custom-1">Contrato</label>
                                        <input type="hidden" name="tab" value="3">
                                        <select class="form-control" name="id_final_inmueble" id="id_final_inmueble"  required="required" >
                                            <option value="">Selecione Contrato</option>
                                            @foreach($finalIndex as $n)
                                            @if($n->id_estado>1)
                                            <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                            @endif
                                            @endforeach  
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <div id="direcciones">
                                            <input name='i_direccion' id='i_direccion' class="typeahead form-control" type="text" placeholder="Dirección" required="required" > 
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <table id="listusers2" class="display nowrap" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Contrato</th>
                                                <th>Dirección/ #Nro</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php ($f = 0)
                                            @foreach($direcciones as $d)

                                            <tr>
                                                <td>{{ $d->id }}</td>
                                                <td>{{ $d->alias }}</td>
                                                <td>{{ $d->direccion }}</td>
                                                @if($f>0)
                                                <td>boton</td>
                                                @else
                                                <td></td>
                                                @endif
                                            </tr>
                                            {{ $f++ }}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </section>
                    <section id="section-iconbox-6_c">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="white-box"> 
                                    <form action="{{ route('finalContrato.savedocs',$borrador->id_publicacion) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="tab" value="2">
                                        <h3 class="box-title">Subir Archivo</h3>
                                        <label for="input-file-now-custom-1">Contratos</label>
                                        <select class="form-control" name="id_final" id="id_final" required="required" >
                                            <option value="">Selecione Contrato</option>
                                            @foreach($finalIndex as $n)
                                            @if($n->id_estado>1)
                                            <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                            @endif
                                            @endforeach  
                                        </select>

                                        <div class="form-group">
                                            <label>Dirección</label>
                                            {{ Form::select('id_inmueble_pdf',[''=>'Seleccione dirección'], null, array('class'=>'form-control','style'=>'','id'=>'id_inmueble_pdf','required'=>'required')) }} 
                                        </div>
                                        <label for="input-file-now-custom-1">Tipo Documento</label>
                                        <select class="form-control" name="tipo" required="required" >
                                            <option value="">Selecione Tipo de Documento</option>
                                            <option value="Contrato Digitalizado">Contrato Digitalizado </option>
                                            <option value="Gastos Notario">Gastos Notario </option>
                                            <option value="Documentos Garantías">Documentos Garantías </option>
                                            <option value="Comprobantes de Pagos">Comprobantes de Pagos </option>
                                            <option value="Otros Documentos">Otros Documentos </option>
                                        </select>
                                        <label for="input-file-now-custom-1">Archivo del contrato</label>
                                        <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                        <input type="hidden" id="id_publicacion" name="id_publicacion" value="{{ $borrador->id_publicacion }}"  /> 
                                        <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Archivo</button>

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
                                            @foreach($documentos as $pi)
                                            <tr>
                                                <td  width="10px" height="10px" style="border: 1px solid black;" >
                                        <center>{{ $pi->direccion }}
                                            <br/>
                                            <b>{{ $pi->tipo }}</b>
                                            <br/>
                                            <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO {{ $pi->nombre }} </a></center>


                                        @can('finalContrato.edit')
                                        <td width="10px" style="border: 1px solid black;" >
                                        <center>
                                            <a href="{{ route('finalContrato.eliminarfoto', $pi->id) }}" 
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

                    <section id="section-iconbox-7_c">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Gestión de pagos del Contrato</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('finalContrato.generarpagos',[$borrador->id_publicacion]) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h3 class="box-title m-b-0">Complete Campos generales para generar pago</h3><br/>
                                                    <div class="row">
                                                        <input type="hidden" name="tipopropuesta" id="tipopropuesta">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="control-label">
                                                                    Propuesta
                                                                </label>
                                                                <select class="form-control" name="id_propuesta" id="id_propuesta"required="required">
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

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Contrato</label>
                                                                <input type="hidden" name="tab" value="3">
                                                                <select class="form-control" name="id_final_pagos" id="id_final_pagos"  required="required" >
                                                                    <option value="">Selecione Contrato</option>
                                                                    @foreach($finalIndex as $n)
                                                                    @if($n->id_estado>1)
                                                                    <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                                                    @endif
                                                                    @endforeach  
                                                                </select>
                                                            </div>


                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Meses</label>
                                                                <input type="number" name="cant_meses" id="cant_meses" value="12" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Dirección</label>
                                                                {{ Form::select('id_inmueble_pago',[''=>'Seleccione dirección'], null, array('class'=>'form-control','style'=>'','id'=>'id_inmueble_pago','required'=>'required')) }} 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                       
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Proporcional</label>
                                                                <select name="proporcional" class="form-control">
                                                                    <option value="NO">NO</option>
                                                                    <option value="SI">SI</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-6">
                                                            <label for="input-file-now-custom-1">Nro. Cuotas</label> 
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">#</span>
                                                                <input name='cuotas' id='cuotas' type="number" class="form-control" >
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label for="input-file-now-custom-1">IVA</label>
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">%</span>
                                                                <input name='iva' id='iva' type="number" step="any" class="form-control"   value=''>
                                                            </div>
                                                        </div>

                                                    </div><br>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Fecha Inicio Contrato</label>
                                                                <input type="date" name="fecha_firmapago" id="fecha_firmapago" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Moneda</label>
                                                                <select class="form-control" name="moneda" id="moneda" required="required" >
                                                                    <option value="CLP">CLP</option>
                                                                    <option value="UF">UF</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="input-file-now-custom-1">Valor Moneda</label>
                                                                <input name='valormoneda' id='valormoneda' type="number" class="form-control" required="required" value='1' step="any">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table id="listusers1_c" class="display compact" cellspacing="0" width="100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Propuesta</th>
                                                                        <th>Inicio</th>
                                                                        <th>% Desc</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($propuestas as $p)
                                                                    <tr>
                                                                        <td>{{ $p->tipopropuesta }}</td>
                                                                        <td>{{ $p->fecha_iniciocontrato }}</td>
                                                                        <td>{{ $p->descuento }}</td>
                                                                        <td><a href="{{ route('borradorContrato.excelsimulacion',$p->id) }}"><span class="ti-export"></span></span></a></td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>     
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h3 class="box-title m-b-0">Generar pagos por Item</h3><br/>
                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">% Descuento</label> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">%</span>
                                                                <input name='descuento' id='descuento' type="number" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">Canon de Arriendo</label> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">$</span>
                                                                <input name='precio' id='precio' step="any" type="number" class="form-control" value="0" required="required">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="ca_radio" id="ca_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="ca_radio" id="ca_radio" value="s" checked="">
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">Gasto Común</label> </div>
                                                        <div class="col-md-5">

                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">$</span>
                                                                <input name='gastocomun' id='gastocomun' type="number" class="form-control"   step="any" value="0" required="required">
                                                            </div>

                                                        </div>

                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="gc_radio" id="gc_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="gc_radio" id="gc_radio" value="s" checked="">
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">Gastos Notariales</label> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">$</span>
                                                                <input name='pagonotaria' id='pagonotaria' type="number" class="form-control" value="0" required="required" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="no_radio" id="no_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="no_radio" id="no_radio" value="s" >
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">Pie Comisión</label> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">%</span>
                                                                <input name='pie' id='pie' type="number" step="any" class="form-control" value="0" required="required"  >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="pie_radio" id="pie_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="pie_radio" id="pie_radio" value="s" >
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3"><label for="input-file-now-custom-1">Cobro Mensual</label> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">%</span>
                                                                <input name='cobromensual' step="any" id='cobromensual' type="number" class="form-control" value="0" required="required" >
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="pj_radio" id="pj_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="pj_radio" id="pj_radio" value="s" >
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="row">
                                                        <div class="col-md-3"><input name='nombre_otropago1' id='nombre_otropago1' type="text" class="form-control"   placeholder="Otro Pago"> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">$</span>
                                                                <input name='pagootro1' step="any" id='pagootro1' type="number" class="form-control"   >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="o1_radio" id="o1_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="o1_radio" id="o1_radio" value="s" checked="">
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3"><input name='nombre_otropago2' id='nombre_otropago2' type="text" class="form-control" placeholder="Otro Pago"> </div>
                                                        <div class="col-md-5">
                                                            <div class="input-group"> 
                                                                <span class="input-group-addon">$</span>
                                                                <input name='pagootro2' step="any" id='pagootro2' type="number" class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-success">
                                                                <input type="radio" name="o2_radio" id="o2_radio" value="e" checked="">
                                                                <label for="radio14"> E </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <div class="radio radio-danger">
                                                                <input type="radio" name="o2_radio" id="o2_radio" value="s" checked="">
                                                                <label for="radio14"> S </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <br>
                                                        <div class="col-md-12">
                                                            <button type="submit" class="btn btn-success waves-effect waves-light">Generar Pagos</button>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </section>
                    <section id="section-iconbox-8_c">

                        <div id="tabla" >
                            <div class="white-box">
                                <div class="form-body">
                                    <div class="row">
                                        <form action="{{ route('finalContrato.eliminartipopago') }}" method="post">
                                            {!! csrf_field() !!}
                                            <div class="col-md-4">
                                                <label for="input-file-now-custom-1">Contrato</label>
                                                <input type="hidden" name="tab" value="3">
                                                <select class="form-control" name="id_final_detalle" id="id_final_detalle"  required="required" >
                                                    <option value="0">Selecione Contrato</option>
                                                    @foreach($finalIndex as $n)
                                                    @if($n->id_estado>1)
                                                    <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                                    @endif
                                                    @endforeach  
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Dirección</label>
                                                {{ Form::select('id_inmueble_mensual',[''=>'Seleccione dirección'], null, array('class'=>'form-control','style'=>'','id'=>'id_inmueble_mensual','required'=>'required')) }} 
                                            </div>
                                            <div class="col-md-4">
                                                <label></label>
                                                <input type="hidden" name="id_pub_borrar" value="{{ $borrador->id_publicacion }}">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Eliminar Pagos Generados</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-responsive" id="tablearea">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="section-iconbox-9_c">
                        <div id="tabla" >
                            <div class="white-box">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="input-file-now-custom-1">Contrato</label>
                                            <input type="hidden" name="tab" value="3">
                                            <select class="form-control" name="id_final_pagar" id="id_final_pagar"  required="required" >
                                                <option value="0">Selecione Contrato</option>
                                                @foreach($finalIndex as $n)
                                                @if($n->id_estado>1)
                                                <option value="{{ $n->id }}">{{ $n->alias }} </option>
                                                @endif
                                                @endforeach  
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>Dirección</label>
                                            {{ Form::select('id_inmueble_pagar',[''=>'Seleccione dirección'], null, array('class'=>'form-control','style'=>'','id'=>'id_inmueble_pagar','required'=>'required')) }} 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="pagoarea">


                                            </div>
                                        </div>

                                    </div>


                                </div>
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
<a href="{{ route('finalContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>


<div id="modal-contacto1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('finalContrato.updatepago') }}" method="post">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label id="nom_pago"></label>
                                                <input type="text" name="pago_update" id="pago_update"class="form-control" placeholder="" required="required" > 
                                                <input type="hidden" name="id_pago_update" id="id_pago_update"  class="form-control" placeholder="" required="required" >
                                                <input type="hidden" name="id_publicacion_update" id="id_publicacion_update"  class="form-control" placeholder="" required="required" >
                                                <input type="hidden" name="id_contrato_update" id="id_contrato_update"  class="form-control" placeholder="" required="required" >
                                                <input type="hidden" name="id_inmueble_update" id="id_inmueble_update"  class="form-control" placeholder="" required="required" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> 
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
        url: "/inmuebles/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' #' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
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
            source: direcciones,

                templates: {
                header: '<h4 class="dropdown">Direcciones</h4>'
            }
        });

jQuery('#i_direccion').on('typeahead:selected', function (e, datum) {
 if($("#id_final_inmueble").val()!=""){
        swal({   
            title: "Esta seguro que desea utilizar la siguiente dirección?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = '/finalContrato/asignarinmueble/'+$("#id_final_inmueble").val()+'/'+datum.option+'/'+{{ $borrador->id_publicacion }}; 
        });
}else{
    swal({   
            title: "Debe seleccionar contrato",   
            type: "error"

        });
}
   
});

</script>

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



<script>

var table2 =$('#listusers2').DataTable({
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



var table1 =$('#listusers1_c').DataTable({
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



 $("#id_final_pagos").change(function (event) {
document.getElementById("tablearea").innerHTML="";
        $.get("/contratofinal/consulta/"+this.value+"",function(response,state){
                    //$("#porcentaje").val(response.comision);
                    $("#fecha_firmapago").val(response.fecha_firma);
                
            });
            if(event.target.value!=""){
                $("#id_inmueble_pago").empty();
                $.get("/pagospropietario/mostrardirecciones/" + event.target.value + "", function (response, state) {
                    $("#id_inmueble_pago").append("<option value=''>Seleccione dirección</option>");
                    for (i = 0; i < response.length; i++) {
                        $("#id_inmueble_pago").append("<option value='" + response[i].id_inmueble + "'>" + response[i].direccion + "</option>");
                    }
                });
            }else{
                $("#id_inmueble_pago").empty();
            }

    });

 $("#id_final_detalle").change(function (event) {

document.getElementById("tablearea").innerHTML="";
    if(event.target.value!=""){
        $("#id_inmueble_mensual").empty();
            $.get("/pagospropietario/mostrardirecciones/" + event.target.value + "", function (response, state) {
                $("#id_inmueble_mensual").append("<option value=''>Seleccione dirección</option>");
                for (i = 0; i < response.length; i++) {
                    $("#id_inmueble_mensual").append("<option value='" + response[i].id_inmueble + "'>" + response[i].direccion + "</option>");
                }
            });
        }else{
            $("#id_inmueble_mensual").empty();
        }
});


  $("#id_inmueble_mensual").change(function (event) {
document.getElementById("tablearea").innerHTML="";
        if($("#id_final_detalle").val()==''){

            return false;

        }

        $.get("/contratofinal/consultapagos/"+$("#id_final_detalle").val()+"/"+ event.target.value +"",function(response,state){
                        var meses = ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

                        document.getElementById("tablearea").innerHTML="";
                        if(response.length>0){
                            var tablearea = document.getElementById('tablearea'),
                                tbl = document.createElement('table');

                            tbl.className='table';
                            tbl.style.border="1px solid black";
                            tbl.style.padding="10px";
                            tbl.style.marginTop="50px";

                            var header = tbl.createTHead();
           

                            var rowheader = header.insertRow(0);
                            var fecha_iniciocontrato=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                            var meses_contrato=response[0].meses_contrato;
                           
                                    //HEAD
                                    var head_fecha=fecha_iniciocontrato;
                                  
                                        head_fecha.setDate(1);
                                        var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Tipo de Pago';
                                        rowheader.appendChild(cell);

                                     for (var r = 0; r < meses_contrato+1; r++) {
                                        var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";

                                         cell.innerHTML = '<b>'+meses[head_fecha.getMonth()]+"/"+head_fecha.getFullYear()+'</b>';

                                        head_fecha.setMonth(head_fecha.getMonth()+1);
                                        rowheader.appendChild(cell);

                                     }
                                     tbl.appendChild(rowheader);

                                    // LINEAS
                                    for (var r = 0; r < 50; r++) {
                                        var row = document.createElement("tr");
                                        var newArray = response.filter(function (el) {
                                              return el.idtipopago==r;
                                            });

                                     // CONTENIDO
                                         if(newArray.length>0)
                                         {
                                               var cell = document.createElement("td");
                                                    var cellText = document.createTextNode(newArray[0].tipopago);
                                                    cell.appendChild(cellText);
                                                    cell.style.border="1px solid black";
                                                    cell.style.padding="8px"
                                                    row.appendChild(cell);
                                                 if(newArray[0].idtipopago==6){
                                                            var cell = document.createElement("td");
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
                                                 }
                                                $subtotal=0;
                                                 for (var c = 0; c < meses_contrato+1; c++) {
                                                    if (!$.isEmptyObject(newArray[c])) {
                                                            var idtp=newArray[c].idtipopago;
                                                            $subtotal+=newArray[c].precio_en_pesos;
                                                            var a = document.createElement("button");
                                                            var linkText = document.createTextNode(newArray[c].precio_en_pesos);
                                                            a.appendChild(linkText);
                                                            if(newArray[c].E_S=='e'){
                                                                a.className="btn btn-block btn-outline btn-success";
                                                            }else{
                                                                if(newArray[c].idtipopago==11){
                                                                    a.className="btn btn-block btn-outline btn-info";
                                                                }else{
                                                                   a.className="btn btn-block btn-outline btn-danger"; 
                                                                }
                                                                
                                                            }
                                                            if(newArray[c].idtipopago==20 || newArray[c].idtipopago==21 || newArray[c].idtipopago==34 || newArray[c].idtipopago==35 )
                                                                a.className="btn btn-block btn-outline btn-default";
                                                            var id=newArray[c].id;
                                                            a.id=id;
                                                            if(newArray[c].idtipopago!=20 && newArray[c].idtipopago!=21  && newArray[c].idtipopago!=34 && newArray[c].idtipopago!=35 && newArray[c].idtipopago!=11)
                                                            a.addEventListener('click', function(){
                                                                    mostrar_modal(this);
                                                                });
                                                            var cell = document.createElement("td");
                                                            //var cellText = document.createTextNode();
                                                            //cell.appendChild(cellText);
                                                            cell.appendChild(a);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
                                                            
                                                    }
                                              
                                                }           
                                                           
                                                tbl.appendChild(row); // AGREGA EL PAGO
                                        }
                                    }
                                
                                 tablearea.appendChild(tbl);
                        }
                
            });


    });

 
var SweetAlert = function () {};

//examples 
SweetAlert.prototype.init = function () {

    //Basic
    $("#6").click(function (event) {
        if($("#verifica_estado").val()=="0"){
            swal("El contrato aún se encuentra en proceso de firma");
            return false;
        }

    });

    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);
 
<?php
if($tab==2){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").addClass("content-current");
           }); 
<?php
}
?>


<?php
if($tab==3){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_7_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-7_c").addClass("content-current");
           }); 
<?php
}
?>

<?php
if($tab==4){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_8_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-8_c").addClass("content-current");
           }); 
<?php
}
?>
<?php
if($tab==5){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_9_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-9_c").addClass("content-current");
           }); 
<?php
}
?>

<?php
if($tab==6){
    ?>
    $(function() {

            $("#li_5_c").removeClass("tab-current");
            $("#li_4_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-4_c").addClass("content-current");
           }); 
<?php
}
?>
$("#li_5_c").click(function (event) {
             $("#li_5_c").addClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
            $("#li_8_c").removeClass("tab-current");
            $("#li_9_c").removeClass("tab-current");
            $("#li_4_c").removeClass("tab-current");
            $("#section-iconbox-5_c").addClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-7_c").removeClass("content-current");
            $("#section-iconbox-8_c").removeClass("content-current"); 
            $("#section-iconbox-9_c").removeClass("content-current");
             $("#section-iconbox-4_c").removeClass("content-current");
            
});
$("#li_6_c").click(function (event) {
            $("#li_6_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
             $("#li_8_c").removeClass("tab-current");
             $("#li_9_c").removeClass("tab-current");
             $("#li_4_c").removeClass("tab-current");
             $("#section-iconbox-6_c").addClass("content-current");
            $("#section-iconbox-5_c").removeClass("content-current");    
            $("#section-iconbox-7_c").removeClass("content-current"); 
            $("#section-iconbox-8_c").removeClass("content-current");  
            $("#section-iconbox-9_c").removeClass("content-current"); 
             $("#section-iconbox-4_c").removeClass("content-current");        
});
$("#li_7_c").click(function (event) {
            $("#li_6_c").removeClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_8_c").removeClass("tab-current");
            $("#li_9_c").removeClass("tab-current");
            $("#li_4_c").removeClass("tab-current");
            $("#li_7_c").addClass("tab-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-8_c").removeClass("content-current");
            $("#section-iconbox-9_c").removeClass("content-current");
             $("#section-iconbox-4_c").removeClass("content-current");
            $("#section-iconbox-7_c").addClass("content-current");       
            
});
$("#li_8_c").click(function (event) {
             $("#li_8_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
            $("#li_9_c").removeClass("tab-current");
            $("#li_4_c").removeClass("tab-current");
            $("#section-iconbox-8_c").addClass("content-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-7_c").removeClass("content-current");
            $("#section-iconbox-9_c").removeClass("content-current");
             $("#section-iconbox-4_c").removeClass("content-current");
            
});
$("#li_9_c").click(function (event) {
             $("#li_9_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
            $("#li_8_c").removeClass("tab-current");
            $("#li_4_c").removeClass("tab-current");
            $("#section-iconbox-9_c").addClass("content-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-7_c").removeClass("content-current");
            $("#section-iconbox-8_c").removeClass("content-current");
            $("#section-iconbox-4_c").removeClass("content-current");
            
});


$("#li_4_c").click(function (event) {
             $("#li_4_c").addClass("tab-current");
            $("#li_5_c").removeClass("tab-current");
            $("#li_6_c").removeClass("tab-current");
            $("#li_7_c").removeClass("tab-current");
            $("#li_8_c").removeClass("tab-current");
            $("#li_9_c").removeClass("tab-current");
            $("#section-iconbox-4_c").addClass("content-current");
            $("#section-iconbox-5_c").removeClass("content-current");
            $("#section-iconbox-6_c").removeClass("content-current");
            $("#section-iconbox-7_c").removeClass("content-current");
            $("#section-iconbox-8_c").removeClass("content-current");
            $("#section-iconbox-9_c").removeClass("content-current");
            
});


function mostrar_modal(obj){
     $.get("/pagospropietario/mostrarpago/"+obj.id+"",function(response,state){
         document.getElementById('nom_pago').innerHTML = response.tipopago;
                    $("#pago_update").val(response.precio_en_pesos);
                    $("#id_pago_update").val(response.id);
                    $("#id_inmueble_update").val(response.id_inmueble);
                    $("#id_contrato_update").val(response.id_contratofinal);
                    
                
            });
    // $('#modal-contacto1').modal('show');
}

function eliminar_pago(obj){
    window.location.href = '/pagospropietario/eliminar/'+obj.name+'/'+obj.id;
}

$("#id_final").change(function (event) {
    if(event.target.value!=""){
    $("#id_inmueble_pdf").empty();
    $.get("/pagospropietario/mostrardirecciones/" + event.target.value + "", function (response, state) {
        $("#id_inmueble_pdf").append("<option value=''>Seleccione dirección</option>");
        for (i = 0; i < response.length; i++) {
            $("#id_inmueble_pdf").append("<option value='" + response[i].id_inmueble + "'>" + response[i].direccion + "</option>");
        }
    });
}else{
    $("#id_inmueble_pdf").empty();
}
});


$("#id_propuesta").change(function (event) {
    $.get("/pagospropietario/mostrarsimulacion/" + event.target.value + "", function (response, state) {
        $("#precio").val(response.canondearriendo!=''?response.canondearriendo:0);
        $("#gastocomun").val(response.gastocomun!=null?response.gastocomun:0);
        $("#pagonotaria").val(response.notaria!=null?response.notaria:0);
        $("#cuotas").val(response.nrocuotas!=null?response.nrocuotas:0);
        $("#cobromensual").val(response.cobromensual!=null?response.cobromensual:0);
        $("#pie").val(response.pie!=null?response.pie:0);
        $("#descuento").val(response.descuento!=null?response.descuento:0);
        $("#iva").val(response.iva!=null?response.iva:0);
        $("#tipopropuesta").val(response.tipopropuesta!=null?response.tipopropuesta:0);
        $("#fecha_firmapago").val(response.fecha_iniciocontrato!=null?response.fecha_iniciocontrato:'');
        $("#cant_meses").val(response.meses_contrato!=null?response.meses_contrato:0);
         $("#nombre_otropago1").val(response.nomotro1!=null?response.nomotro1:'');
          $("#nombre_otropago2").val(response.nomotro2!=null?response.nomotro2:'');
           $("#pagootro1").val(response.otro1!=null?response.otro1:0);
           $("#pagootro2").val(response.otro2!=null?response.otro2:0);
           $("#moneda").val(response.moneda!=null?response.moneda:0);
           $("#valormoneda").val(response.valormoneda!=null?response.valormoneda:0);

    });

});

 $("#id_final_pagar").change(function (event) {
document.getElementById("pagoarea").innerHTML="";
    if(event.target.value!=""){
        $("#id_inmueble_pagar").empty();
            $.get("/pagospropietario/mostrardirecciones/" + event.target.value + "", function (response, state) {
                $("#id_inmueble_pagar").append("<option value=''>Seleccione dirección</option>");
                for (i = 0; i < response.length; i++) {
                    $("#id_inmueble_pagar").append("<option value='" + response[i].id_inmueble + "'>" + response[i].direccion + "</option>");
                }
            });
        }else{
            $("#id_inmueble_pagar").empty();
        }
});

  $("#id_inmueble_pagar").change(function (event) {
document.getElementById("pagoarea").innerHTML="";
        if($("#id_final_pagar").val()=='' || $(this).val()==''){
            return false;
        }

                $.get("/contratofinal/consultapagosmensuales/"+$("#id_final_pagar").val()+"/" + event.target.value + "",function(response,state){
                        var meses = ["", "Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"];

                        document.getElementById("pagoarea").innerHTML="";
                        if(response.length>0){
                            var tablearea = document.getElementById('pagoarea'),
                                tbl = document.createElement('table');

                            tbl.className='table';
                            tbl.style.border="1px solid black";
                            tbl.style.padding="10px";
                            tbl.style.marginTop="50px";

                            var header = tbl.createTHead();
                            var rowheader = header.insertRow(0);
                            var fecha_iniciocontrato=new Date(response[0].fecha_iniciocontrato+'T00:00:00');
                            var meses_contrato=response[0].meses_contrato;
                            var mes_inicio=response[0].mes;

                                    //HEAD
                                    var head_fecha=fecha_iniciocontrato;
                                        head_fecha.setDate(1);
                                    
                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Mes/Año';
                                        rowheader.appendChild(cell);

                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Total Salida';
                                        rowheader.appendChild(cell);

                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Pagar a Propietario';
                                        rowheader.appendChild(cell);


                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Estado';
                                        rowheader.appendChild(cell);

                                    var cell = document.createElement("th");
                                        cell.style.border="1px solid black";
                                        cell.style.padding="8px";
                                        cell.innerHTML = 'Pagar';
                                        rowheader.appendChild(cell);

                                     tbl.appendChild(rowheader);

                                    // LINEAS

                                    for (var r = 0; r < response.length; r++) {
                                        var row = document.createElement("tr");
                                     // CONTENIDO

                                         if(response.length>0)
                                         {
                                                                              
                                                    if (!$.isEmptyObject(response[r])) {
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode(meses[response[r].mes]+'/'+response[r].anio);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
   
           
                                                            var a = document.createElement("button");
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode("$ "+response[r].subtotal_salida);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);

               
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode("$ "+response[r].pago_propietario);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);

                                                            var estado="";
                                                            if(response[r].id_estado==1){
                                                                estado='No Pagado';
                                                            }
                                                            if(response[r].id_estado==2){
                                                                estado='Pago Parcial';
                                                            }
                                                            if(response[r].id_estado==3){
                                                                estado='Pagado';
                                                            }                    
                                                            if(response[r].id_estado==4){
                                                                estado='Vencido';
                                                            } 
                                                            var cell = document.createElement("td");
                                                            var cellText = document.createTextNode(estado);
                                                            cell.appendChild(cellText);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);

                                                            var a = document.createElement("button");
                                                            var linkText1 = document.createTextNode("$");
                                                            a.className="btn btn-success btn-circle btn-lg";
                                                            a.id=response[r].id;
                                                            a.addEventListener('click', function(){
                                                                    ir_pago(this);
                                                                });
                                                            a.appendChild(linkText1);
                                                            a.style="font-size:small"
                                                            var cell = document.createElement("td");
                                                            cell.appendChild(a);
                                                            cell.style.border="1px solid black";
                                                            cell.style.padding="8px"
                                                            cell.style.textAlign="center"
                                                            row.appendChild(cell);
                                                    }
                                                 
                                                tbl.appendChild(row); // AGREGA EL PAGO
                                        }
                                    }
                                
                                 tablearea.appendChild(tbl);
                        }
                
            });

});

function ir_pago(obj){
    window.location.href = '/finalContrato/ir_al_pago/'+obj.id;
}

$("#moneda").change(function (event) {
    if(this.value=="UF"){
        $("#valormoneda").val({{ $uf->valor }});
    }else{
        $("#valormoneda").val(1);
    }
    
});

</script>
@endsection