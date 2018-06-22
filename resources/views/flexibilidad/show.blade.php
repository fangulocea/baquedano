@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Flexibilidad</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="#" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Flexibilidad</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Flexibilidad</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $flex->nombre }}" disabled="disabled"> <span class="help-block"> Identificación de Flexibilidad </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle de Flexibilidad</label>
                                        <input name='descripcion' value="{{ $flex->descripcion }}" type="text" class="form-control" disabled="disabled"> </div>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $flex->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <a href="{{ route('flexibilidad.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
