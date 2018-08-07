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
                                        <input type="text" class="form-control" disabled="disabled" value="{{ $garantia_p->valor }}" >
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

                            <a href="{{ route('finalContrato.finalizadoc', [ $id_contrato, $id_publicacion ] ) }}" class="btn btn-info" style="color:white"><i class="fa ti-save"></i>&nbsp;&nbsp;Ingresar Documentación Necesaria para el Cierre</a>

                            <hr>






{{--                             <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle del cargo</label>
                                        <input name='descripcion' type="text" class="form-control"> </div>
                                </div>
                            </div>
 --}}

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('finalContrato.edit',[$id_publicacion,0,0,1]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection