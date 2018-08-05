@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nuevo Servicio</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('catalogo.update', $servicio->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_modificador" value="{{ Auth::user()->id }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Servicios</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">SERVICIO</label>
                                        <input type="text" name="nombre_servicio" class="form-control" placeholder="" required="required" value="{{ $servicio->nombre_servicio }}" > <span class="help-block"> Identificación del Servicio </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle del Servicio</label>
                                        <input name='detalle' required="required" type="text" class="form-control" value="{{ $servicio->detalle }}"> </div>
                                </div>
                            </div>

                            <div class="row"> 

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo Moneda</label>
                                        <select class="form-control" name="moneda" id="moneda" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="CLP" @if($servicio->moneda=='CLP'){{ 'selected'}}@endif>CLP</option>
                                            <option value="UF" @if($servicio->moneda=='UF'){{ 'selected'}}@endif>UF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Valor Moneda</label>
                                        <div class="input-group"> 
                                            <input name='valor_moneda' id='valor_moneda' type="number" class="form-control" required="required" readonly="readonly" value="{{ $servicio->valor_moneda }}">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Valor</label>
                                        <div class="input-group"> 
                                            <input name='valor_en_moneda' id='valor_en_moneda'  step="any" type="number" value="{{ $servicio->valor_en_moneda }}" class="form-control" required="required">
                                        </div>
                                    </div>
                                    
                                </div>
                              <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Unidad de Medida</label>
                                        <select class="form-control" name="unidad_medida" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="C/U"  @if($servicio->unidad_medida=='C/U'){{ 'selected'}}@endif>C/U</option>
                                            <option value="Por Habitación"  @if($servicio->unidad_medida=='Por Habitación'){{ 'selected'}}@endif>Por Habitación</option>
                                             <option value="Por Placa"  @if($servicio->unidad_medida=='Por Placa'){{ 'selected'}}@endif>Por Placa</option>
                                              <option value="Por MT2"  @if($servicio->unidad_medida=='Por MT2'){{ 'selected'}}@endif>Por MT2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                         <select class="form-control" name="id_estado" id="id_estado" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="1" @if($servicio->id_estado=='1'){{ 'selected'}}@endif>Vigente</option>
                                            <option value="0" @if($servicio->id_estado=='0'){{ 'selected'}}@endif>No Vigente</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('catalogo.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" >
    
$("#moneda").change(function (event) {
    if(this.value=="UF"){
        $("#valormoneda").val({{ $uf->valor or 0}});
    }else{
        $("#valormoneda").val(1);
    }
    
});

</script>
@endsection