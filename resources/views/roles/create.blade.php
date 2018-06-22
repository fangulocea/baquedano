@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear un nuevo Rol</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('roles.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información del Rol</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Rol</label>
                                        <input type="text" name="name" class="form-control" placeholder="" required="required" > <span class="help-block"> Nombre del Rol</span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Url Amigable</label>
                                        <input name='slug' type="text" class="form-control"> 
                                        <span class="help-block"> Ej. admin.funcion / admin.captador</span></div>
                                </div>
                            </div>

                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>
                                        <input type="text" name='description' class="form-control" required="required"> </div>
                                </div>
                            </div>
                             <div class="row">
                                    <h3>Permiso especial</h3>
                                    <div class="form-group">
                                        <label>{{ Form::radio('special', 'all-access') }} Acceso total</label>
                                        <label>{{ Form::radio('special', 'no-access') }} Ningún acceso</label>
                                    </div>
                                </div>
                            <hr>
                            <h3>Lista de permisos</h3>
                            <div class="table-responsive">
                                        <table id="listusers" class="display nowrap" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Check</th>
                                                    <th>Permiso</th>
                                                    <th>Descripción</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Check</th>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                @foreach($permissions as $permission)
                                                        <tr>
                                                            <td>{{ Form::checkbox('permissions[]', $permission->id, null) }}</td>
                                                            <td>{{ $permission->name }}</td>
                                                            <td>{{ $permission->description }}</td>
                                                            
                                                        </tr>
                                                        @endforeach

                                            </tbody>
                                        </table>
                                    </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('roles.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
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
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/JSZip-2.5.0/jszip.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.print.min.js') }}"></script>

<script>

$('#listusers').DataTable({
    language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "buttons": {
            "copy": 'Copiar',
            "csv": 'Exportar a CSV',
            "print": 'Imprimir'},
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
});

</script>
@endsection