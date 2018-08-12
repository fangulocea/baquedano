@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Cierre Contrato Arrendatario</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('cargo.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-body">
                            <h3 class="box-title">Datos necesarios para el cierre de Contrato por parte de Baquedano</h3>
                            <hr>


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
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $arrendatario->direccion or null }} N° {{ $arrendatario->numero or null }},  {{ $arrendatario->comuna or null }}" >
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Garantia a Trasladar</label>
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $garantia_a->valor or null }}" >
                                    </div>
                                </div>

                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContratoArr.finalizadoc', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-success" style="color:white"><i class="fa ti-save"></i>&nbsp;&nbsp;Ingresar Documentación Necesaria para el Cierre</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContratoArr.indexcuadratura', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-success" style="color:white"><i class="fa ti-save"></i>&nbsp;&nbsp;Ingresar Gastos Básicos, Comunes y Reparaciones</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>                            
                            <hr>
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContratoArr.generapago', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-primary btn-lg btn-block btn-warning" style="color:white"><i class="fa ti-money"></i>&nbsp;&nbsp;Generar Pagos</a>
                                </div>
                                <div class="col-md-3"> </div>
                            </div>                            
                            <hr> 
                            <div class="row">
                                <div class="col-md-3"> </div>
                                <div class="col-md-6">
                                    <a href="{{ route('finalContratoArr.edit',[ $id_publicacion,0,0,1 ]) }}"> <button type="button" class="btn btn-primary btn-lg btn-block btn-info"> <i class="fa ti-control-backward"></i>&nbsp;&nbsp;Volver</button></a>
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