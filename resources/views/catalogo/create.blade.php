@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nuevo servicio</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('catalogo.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="id_modificador" value="{{ Auth::user()->id }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Catalogo de Servicios</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">SERVICIO</label>
                                        <input type="text" name="nombre_servicio" class="form-control" placeholder="" required="required" > <span class="help-block"> Identificación del Servicio </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Detalle del Servicio</label>
                                        <input name='detalle' type="text" required="required" class="form-control"> </div>
                                </div>
                            </div>

                            <div class="row"> 

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Tipo Moneda</label>
                                        <select class="form-control" name="moneda"  id="moneda" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="CLP">CLP</option>
                                            <option value="UF">UF</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Valor Moneda</label>
                                        <div class="input-group"> 
                                            <input name='valor_moneda' id='valor_moneda' type="number" class="form-control" readonly="readonly" required="required">
                                        </div>
                                    </div>
                                    
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Valor</label>
                                        <div class="input-group"> 
                                            <input name='valor_en_moneda' type="number" class="form-control" step="any" required="required">
                                        </div>
                                    </div>
                                    
                                </div>
              
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Unidad de Medida</label>
                                        <select class="form-control" name="unidad_medida" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="C/U">C/U</option>
                                            <option value="Por Habitación">Por Habitación</option>
                                             <option value="Por Placa">Por Placa</option>
                                              <option value="Por MT2">Por MT2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="id_estado" required="required">
                                            <option value="">Seleccione</option>
                                            <option value="1">Vigente</option>
                                            <option value="0">No Vigente</option>
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
        $("#valor_moneda").val({{ $uf->valor or 0}});
    }else{
        $("#valor_moneda").val(1);
    }
    
});

</script>
@endsection