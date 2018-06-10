@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Muestra relación Persona/Inmueble</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('personaInmueble.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de relación Persona/Inmueble</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="control-label">Persona</label>
                                        <select class="form-control" name="id_persona" required="required" disabled="disabled" >
                                            <option value="">{{ $ip->nombre }} {{ $ip->apellido_paterno }} {{ $ip->apellido_materno }}
                                            </option>
                                        </select>
                                        </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-md-5 ">
                                    <div class="form-group">
                                        <label class="control-label">Inmueble</label>
                                        <select class="form-control" name="id_inmueble" required="required" disabled="disabled" >
                                            <option value="">{{ $ip->direccion }} {{ $ip->numero }}, {{ $ip->comuna_nombre }}</option>
                                        </select>
                                         
{{--                                         <label>Inmueble</label>
                                        {{ Form::select('id_inmueble',$inmu, null,array('class'=>'form-control','style'=>'','id'=>'direccion','placeholder'=>'Selecciona Cargo')) }}
 --}}                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            
                            <a href="{{ route('personaInmueble.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection