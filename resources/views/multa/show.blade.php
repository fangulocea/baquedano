@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear una nueva Multa</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('multa.store') }}" method="post">
                     {!! csrf_field() !!}
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <div class="form-body">
                        <h3 class="box-title">Información de Multas</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Servicio</label>
                                    <input type="text" name="nombre" class="form-control" placeholder="" required="required" disabled="disabled" value="{{ $multa->nombre }}" > <span class="help-block"> Identificación del Servicio </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle del Servicio</label>
                                        <input name='descripcion' type="text" class="form-control" disabled="disabled" value="{{ $multa->descripcion }}" > </div>
                                    </div>
                                </div>

                                <div class="row"> 

                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label>Tipo Multa</label>
                                        <select class="form-control" name="tipo_multa" required="required" disabled="disabled">
                                            <option value="{{ $multa->tipo_multa }}">{{ $multa->tipo_multa }}</option>
                                            <option value="%">$</option>
                                            <option value="$">%</option>
                                        </select>
                                    </div>
                                </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="input-group"> 
                                                <input name='valor' type="number" class="form-control" required="required" disabled="disabled" value="{{ $multa->valor }}" >
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $multa->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="form-actions">
                                <a href="{{ route('multa.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

    @endsection