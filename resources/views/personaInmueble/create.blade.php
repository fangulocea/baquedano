@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nueva relación Persona/Inmueble</div>
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
                                        <select class="form-control" name="id_persona" required="required" >
                                            <option value="">Selecione Persona</option>
                                            @foreach($pers as $p)
                                                <option value="{{ $p->id }}">{{ $p->propietario }}</option>
                                            @endforeach   
                                        </select>
                                        </div>
                                </div>

                            </div>
                            
                            <div class="row">
                                <div class="col-md-5 ">
                                    <div class="form-group">
                                        <label class="control-label">Inmueble</label>
                                        <select class="form-control" name="id_inmueble" required="required" >
                                            <option value="">Selecione Inmueble</option>
                                            @foreach($inmu as $in)
                                                <option value="{{ $in->id }}">{{ $in->direccion }} {{ $in->numero }}, {{ $in->comuna_nombre }}</option>
                                            @endforeach   
                                        </select>
                                         
{{--                                         <label>Inmueble</label>
                                        {{ Form::select('id_inmueble',$inmu, null,array('class'=>'form-control','style'=>'','id'=>'direccion','placeholder'=>'Selecciona Cargo')) }}
 --}}                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('cargo.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection