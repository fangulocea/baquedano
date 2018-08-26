@extends('admin.layout')

@section('contenido')
@php 
    use App\Http\Controllers\ChecklistController;
@endphp
<div id="tabla" >
    <div class="white-box">
        <h3 class="box-title m-b-0">Reporte de Inmuebles</h3>
        <p class="text-muted m-b-30">Reporte de propiedades Vigentes Disponibles.</p>
        <div class="table-responsive" style="padding-bottom: 50px;">

<form action="{{ route('reportes.inmuebles') }}" method="post">
    {!! csrf_field() !!}
    
    <div class="row">
        
        <div class="col-sm-2">
            <label>Estados ({{ $estado or null }})</label>
            <select name="estado" id=dir class='form-control' required="required">
                <option value="Todos">Todos</option>
                <option value="Vigentes">Vigentes</option>
                <option value="No Vigentes">No Vigentes</option>
            </select>
        </div>

        <div class="col-sm-2">
            <label>Estados ()</label>
            <select name="dir" id=dir class='form-control' required="required">
                <option value="Todos">Todos</option>
                <option value="Vigentes">Vigentes</option>
                <option value="No Vigentes">No Vigentes</option>
            </select>
        </div>

        <div class="col-sm-1">
            <label>Acción</label>
            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Generar</button>
        </div>
    </div>
</form>


<hr>
            <table id="listusers" class="display compact" cellspacing="0" width="200%">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dirección</th>
                        <th>Dormitorios</th>
                        <th>Baño</th>
                        <th>Bodega</th>
                        <th>Piscina</th>

                    </tr>
                </thead>
                <tbody>
                    @if (!(empty($Inmuebles)))
                        @foreach($Inmuebles as $a)
                            <tr>
                                <td>{{ $a->id }}</td>
                                <td>{{ $a->direccion }}, N°{{ $a->numero }}, {{ $a->comuna }}</td>
                                <td>{{ $a->dormitorio }}</td>
                                <td>{{ $a->bano }}</td>
                                <td>{{ trans_choice('mensajes.sino', $a->bodega ) }}</td>
                                <td>{{ trans_choice('mensajes.sino', $a->piscina ) }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
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
<!-- end - This is for export functionality only -->
<script>



$('#listusers').DataTable({
    dom: 'Bfrtip',
    "searching": false,
    buttons: [
        'copy', 'excel', 'pdf',

    ],

    columnDefs: [{
            "targets": [3, 4, 5],
            "orderable": false
        }],

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