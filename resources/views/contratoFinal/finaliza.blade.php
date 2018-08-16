@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Cierre Contrato Propietario</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('cargo.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-body">
                            <h3 class="box-title">Datos necesarios para el cierre de Contrato</h3>
                            <hr>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Propietario</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $propietario_propiedad->nombre }} {{ $propietario_propiedad->apellido_paterno }} {{ $propietario_propiedad->apellido_materno }}" >
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Propiedad</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $propietario_propiedad->direccion }} N° {{ $propietario_propiedad->numero }},  {{ $propietario_propiedad->comuna }}" >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Garantia a Devolver</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $garantia_p->valor or null }}" >
                                    </div>
                                </div>

                            </div>
                            @if($valida == 1)
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Arrendatario</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $arrendatario->nombre or null }} {{ $arrendatario->apellido_paterno or null }} {{ $arrendatario->apellido_materno or null }}" >
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Propiedad</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $propietario_propiedad->direccion or null }} N° {{ $propietario_propiedad->numero or null }},  {{ $propietario_propiedad->comuna or null }}" >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Garantia a Trasladar</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $garantia_a->valor or null }}" >
                                    </div>
                                </div>

                            </div>
                            @endif

                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContrato.finalizadoc', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-success" style="color:white"><i class="fa ti-save"></i>&nbsp;&nbsp;Ingresar Documentación Necesaria para el Cierre</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContrato.indexcuadratura', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-success" style="color:white"><i class="fa ti-save"></i>&nbsp;&nbsp;Ingresar Gastos Básicos, Comunes y Reparaciones</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>                            
                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContrato.generapago', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-warning" style="color:white"><i class="fa ti-money"></i>&nbsp;&nbsp;Generar Pagos</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>                            
                            <hr> 
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContrato.edit',[ $id_publicacion,0,0,1,"Contrato" ]) }}"> <button type="button" class="btn btn-primary btn-lg btn-block btn-info"> <i class="fa ti-control-backward"></i>&nbsp;&nbsp;Volver</button></a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>                              
                        </div>
                        
                            
                            
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection