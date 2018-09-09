@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> REPORTE CONTRATOS ARRENDATARIOS</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                  <form action="{{ route('repfinal.genera_contrato_arr') }}" method="post" enctype='multipart/form-data'>
                    {!! csrf_field() !!}
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div id="tabla" >
                            <div class="white-box">
                            <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <center><h2>FILTROS DE BUSQUEDA</h2></center>
                                            <hr>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Inicio</label>
                                            <input type="date" name="fechainicio" id="fechainicio" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Fin</label>
                                            <input type="date" name="fechafin" id="fechafin" class="form-control" required="required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="estado[]" id="estado" class="form-control" required="required" multiple>
                                                <option value="todos">Todos</option>
                                                @foreach($estados as $e)
                                                    <option value="{{ $e->id }}">{{ $e->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ordenados Por</label>
                                            <select name="orden" id="orden" class="form-control" required="required">
                                                <option value="c.id">ID</option>
                                                <option value="i.direccion">Dirección</option>
                                                <option value="c.created_at">Fecha Creación</option>
                                                <option value="p1.nombre">Arrendatario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo de Orden</label>
                                            <select name="tipoorden" id="tipoorden" class="form-control" required="required">
                                                <option value="Asc">Ascendente</option>
                                                <option value="Desc">Descendentes</option>
                                            </select>
                                        </div>
                                    </div>
                                            
                                </div>
                                <div class="row">
                                  <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Región</label>
                                            <select name="region" id="region" class="form-control" required="required">
                                                <option value="todos">Todas</option>
                                                @foreach($regiones as $r)
                                                    <option value="{{ $r->region_id }}">{{ $r->region_nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Provincia</label>
                                            <select name="provincia" id="provincia" class="form-control" required="required">
                                                <option value="todos">Todas</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Comuna</label>
                                            <select name="comuna" id="comuna" class="form-control" required="required">
                                                <option value="todos">Todas</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" class="form-control" name="direccion">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Numero</label>
                                            <input type="text" class="form-control" name="numero">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Departamento</label>
                                            <input type="text" class="form-control" name="departamento">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                     <div class="col-md-4">
                                     </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button type="submit"  class="btn btn-block btn-primary btn-rounded">Exportar Reporte</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                     </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript">

$("#region").change(function (event) {
    $("#provincia").empty();
    $("#comuna").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#provincia").append("<option value=''>Seleccione provincia</option>");
        $("#provincia").append("<option value='todos'>Todas</option>");
        for (i = 0; i < response.length; i++) {
            $("#provincia").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#provincia").change(function (event) {
    $("#comuna").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#comuna").append("<option value=''>Seleccione comuna</option>");
        $("#comuna").append("<option value='todos'>Todas</option>");
        for (i = 0; i < response.length; i++) {
            $("#comuna").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});
</script>

@endsection