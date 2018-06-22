@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Ver Contrato</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('contrato.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información del Contrato</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Contrato</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" disabled="disabled" value="{{ $contrato->nombre }}" > <span class="help-block"> Identificación del Contrato </span> </div>
                                    </div>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label>Detalle del Contrato</label>
                                            <textarea disabled="disabled" name="descripcion" cols="25" rows="10" class="form-control" required="required">{{ $contrato->descripcion }}</textarea>
                                        </div>
                                    </div>

                                    <div class="row"> 

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $contrato->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                <div class="form-actions">
                                    <a href="{{ route('contrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

        @endsection