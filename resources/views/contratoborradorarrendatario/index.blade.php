@extends('admin.layout')

@section('contenido')

<div id="tabla" >
    <div class="white-box">
        <h3 class="box-title m-b-0">Gestión de Contratos Borrador Arrendatario</h3>
        <p class="text-muted m-b-30">Administración de registros para la generación de contratos borrador</p>
        <div class="table-responsive" style="padding-bottom: 50px;">
            <table id="listusers" class="display compact" cellspacing="0" width="200%">
      
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Arrendatario</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Arrendatario</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Estado</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($publica as $p)
                            <tr>
                                <td>{{ $p->id_cap_arr }}</td>
                                <td>{{ $p->arrendatario }}</td>
                                <td>{{ $p->direccion }} #{{ $p->numero }}</td>
                                <td>{{ $p->comuna }}</td>
                                <td>{{ trans_choice('mensajes.arrendatario', $p->id_estado) }}</td>
                                @can('cbararrendatario.edit')
                                <td width="10px">
                                    <a href="{{ route('cbararrendatario.edit', [$p->id_cap_arr,1]) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti-pencil-alt"></i></span></a>
                                </td>
                                @endcan
                                @can('cbararrendatario.destroy')
                                <td width="10px">
                                </td>
                                @endcan
                            </tr>
                            @endforeach

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
$('.sorting_desc').hide();

var table = $('#listusers').DataTable({

    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print',
    ],
    columnDefs: [
        {
            "targets": [8, 9],
            "orderable": false,
        },
        ],
   
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



    // Setup - add a text input to each footer cell
    $('#listusers thead th').each( function () {
        var title = $(this).text();
        if(title!='ID' && title!= "")
        $(this).html( '<input type="text" style="width:100px" placeholder="'+title+'" />' );
    } );
 

 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

</script>


@endsection