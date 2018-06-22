@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Cargo</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="#" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Cargos</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Cargo</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $cargo->nombre }}" disabled="disabled"> <span class="help-block"> Identificación del Cargo </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle del cargo</label>
                                        <input name='descripcion' value="{{ $cargo->descripcion }}" type="text" class="form-control" disabled="disabled"> </div>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $cargo->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <a href="{{ route('cargo.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
