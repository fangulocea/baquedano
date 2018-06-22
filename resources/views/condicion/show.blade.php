@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Condición</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="#" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Condiciones de servicios para contratos</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Condición</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $cond->nombre }}" disabled="disabled"> <span class="help-block"> Identificación de la Condición </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle de la condición</label>
                                        <input name='descripcion' value="{{ $cond->descripcion }}" type="text" class="form-control" disabled="disabled"> </div>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $cond->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <a href="{{ route('condicion.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
