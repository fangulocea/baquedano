@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nueva Forma de Pago</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('formasDePago.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Formas de Pago</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Forma de Pago</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" > <span class="help-block"> Identificación de la forma de pago </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input name='descripcion' required="required" type="text" class="form-control"> </div>
                                </div>
                            </div>

                            <div class="row"> 

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pie (%)</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">%</span>
                                            <input name='pie' type="number" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Cuotas</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">N°</span>
                                            <input name='cuotas' type="number" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="estado" required="required">
                                            <option value="">Seleccione Estado</option>
                                            <option value="1">Vigente</option>
                                            <option value="0">No Vigente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('formasDePago.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

@endsection