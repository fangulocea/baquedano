
@extends('admin.arrendatario')


@section('contenido')


<div class="responsive">
<?php $ini=1; ?>
    <div class="row" style="padding-top: 50px">
        <div class="col-sm-12">
            <div class="white-box" >
@foreach($contratos as $c)
<hr>
                  <div class="alert alert-primary">
                            <label>Información Contrato Nro {{ $c->id_contrato }}</label>
                        </div>

<hr>
                <div class="form-body">
                                        <div class="row"> 

                                            <div class="col-md-9">
                                                <div class="form-group">

                                                    <label>Dirección</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->direccion or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                        <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Notaría</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->notaria or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 

            
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Estado del Contrato</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->estado or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Fecha Firma</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->fecha_firma or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Duración Contrato</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->meses_contrato or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Propuesta Comercial</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $c->propuesta or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                </div>
<?php $ini=$ini+1; ?>
@endforeach
                
                    <hr>
<div class="alert alert-primary">
                            <label>Documentos Digitalizados</label>
                        </div>
                        <hr>
        <div class="form-body">
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>ID Contrato</label>

                                                </div>
                                            </div>
                                        <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Dirección</label>

                                                </div>
                                            </div>
                                         <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Tipo de Documento</label>

                                                </div>
                                            </div>
                                         <div class="col-md-3">
                                                <div class="form-group">

                                                    <label>Bajar Archivo</label>


                                                </div>
                                            </div>
                                        </div>
                                 @foreach($docs as $d)
                                        @foreach($d as $pi)

                                        <div class="row">
                                       <div class="col-md-3">
                                                <div class="form-group">
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $pi->id_final or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $pi->direccion or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                         <div class="col-md-3">
                                                <div class="form-group">
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $pi->tipo or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>
                                         <div class="col-md-3">
                                                <div class="form-group">
                                                    <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">
                                                <button type="button" class="btn btn-info btn-circle btn-lg">
                                                    <i class="fa fa-cloud-download"></i> 
                                                </button>
                                            </a>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                     @endforeach
        </div>



                       
                        <div class="form-actions">
                                <center>
                                <a href="{{ route('home_arrendatario') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                </center>
                            </div>
                    </div>

        </div>
    </div>
</div>