@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Reportes de Captaciones</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
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
                                            <input type="date" name="fechainicio" id="fechainicio" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Fin</label>
                                            <input type="date" name="fechafin" id="fechafin" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Captador</label>
                                            <select name="captador" id="captador" class="form-control">
                                                <option value="todos">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="todos">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Agrupados Por</label>
                                            <select name="agrupado" id="agrupado" class="form-control">
                                                <option value="Direccion">Dirección</option>
                                                <option value="Propietario">Propietario</option>
                                                <option value="Captador">Captador</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Región</label>
                                            <select name="region" id="region" class="form-control">
                                                <option value="">Seleccione Región</option>
                                                <option value="todos">Todas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Provincia</label>
                                            <select name="provincia" id="provincia" class="form-control">
                                                <option value="">Seleccione Provincia</option>
                                                <option value="todos">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Comuna</label>
                                            <select name="comuna" id="comuna" class="form-control">
                                                <option value="">Seleccione Comuna</option>
                                                <option value="todos">Todos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ordenados Por</label>
                                            <select name="orden" id="orden" class="form-control">
                                                <option value="ID">ID</option>
                                                <option value="Captador">Captador</option>
                                                <option value="Direccion">Dirección</option>
                                                <option value="FechaCreacion">Fecha Creación</option>
                                                <option value="FechaPublicacion">Fecha Publicación</option>
                                                <option value="Propietario">Propietario</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Tipo de Orden</label>
                                            <select name="tipoorden" id="tipoorden" class="form-control">
                                                <option value="Ascendente">Ascendente</option>
                                                <option value="Descendentes">Descendentes</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Gestiones</label>
                                            <select name="gestiones" id="gestiones" class="form-control">
                                                <option value="todos">Todos</option>
                                                <option value="singestion">Sin Gestión</option>
                                                <option value="solocorreo">Solo Correo Inicial</option>
                                                <option value="Reinsistencia">Reinsistencia</option>
                                                <option value="varias">Varias Gestiones</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Texto Dirección</label>
                                            <input type="text" class="form-control" name="texto">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-block btn-primary btn-rounded">Exportar Reporte</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-block btn-success btn-rounded">Reporte Web</button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button class="btn btn-block btn-warning btn-rounded">Ver Gráficos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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


@endsection