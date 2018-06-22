@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nueva Comisión</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('comision.update', $comision->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Comisiones</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de la Comisión</label>
                                        <input type="text" name="nombre" value="{{ $comision->nombre }}" class="form-control" placeholder="" required="required" disabled="disabled" > <span class="help-block"> Identificación de la Comisión </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-10 ">
                                    <div class="form-group">
                                        <label>Detalle, se traspasara a Contrato</label>
                                        <textarea name="descripcion" disabled="disabled" cols="50" rows="10" class="form-control" required="required">{{ $comision->descripcion }}</textarea>
                                </div>
                            </div>

                            <div class="row"> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comisión (%)</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">%</span>
                                            <input name='comision' disabled="disabled" value="{{ $comision->comision }}" type="number" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $comision->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            
                            <a href="{{ route('comision.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection