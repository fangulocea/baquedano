@extends('admin.layout')

@section('contenido')

<div id="tabla" >
    <div class="white-box">
        <h3 class="box-title m-b-0">Gestión de Contratos Finales</h3>
        <p class="text-muted m-b-30">Administración de registros para la generación de contratos finales</p>
        <div class="table-responsive" style="padding-bottom: 50px;">
            <table id="listusers" class="display compact" cellspacing="0" width="200%">
      
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Propietario</th>
                        <th>Día Pago</th>
                        <th>Estado</th>
                        <th>{{ $meses->mesanterior6 }}</th>
                        <th>{{ $meses->mesanterior5 }}</th>
                        <th>{{ $meses->mesanterior4 }}</th>
                        <th>{{ $meses->mesanterior3 }}</th>
                        <th>{{ $meses->mesanterior2 }}</th>
                        <th>{{ $meses->mesanterior1 }}</th>
                        <th style="color:red">{{ $meses->mesactual }}</th>
                        <th>{{ $meses->messiguiente1 }}</th>
                        <th>{{ $meses->messiguiente2 }}</th>
                        <th>{{ $meses->messiguiente3 }}</th>
                        <th>{{ $meses->messiguiente4 }}</th>
                        <th>{{ $meses->messiguiente5 }}</th>
                        <th>{{ $meses->messiguiente6 }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Propietario</th>
                        <th>Día Pago</th>
                        <th>Estado</th>
                        <th>{{ $meses->mesanterior6 }}</th>
                        <th>{{ $meses->mesanterior5 }}</th>
                        <th>{{ $meses->mesanterior4 }}</th>
                        <th>{{ $meses->mesanterior3 }}</th>
                        <th>{{ $meses->mesanterior2 }}</th>
                        <th>{{ $meses->mesanterior1 }}</th>
                        <th style="color:red">{{ $meses->mesactual }}</th>
                        <th>{{ $meses->messiguiente1 }}</th>
                        <th>{{ $meses->messiguiente2 }}</th>
                        <th>{{ $meses->messiguiente3 }}</th>
                        <th>{{ $meses->messiguiente4 }}</th>
                        <th>{{ $meses->messiguiente5 }}</th>
                        <th>{{ $meses->messiguiente6 }}</th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($publica as $p)
                            <tr>
                                <td>{{ $p->id_publicacion }}</td>
                                <td >{{ $p->direccion }} #{{ $p->numero }} , Dpto {{ $p->departamento }}</td>
                                <td>{{ $p->comuna_nombre }}</td>
                                <td>{{ $p->nom_p }} {{ $p->apep_p }} {{ $p->apem_p }}</td>
                                <td>{{ $p->dia_pago }}</td>
                                <td>{{ trans_choice('mensajes.captacion', $p->id_estado) }}</td>
                                <td> {{ $p->valoranterior6 - $p->valorpagadoanterior6 }} </td>
                                <td> {{ $p->valoranterior5 - $p->valorpagadoanterior5 }} </td>
                                <td> {{ $p->valoranterior4 - $p->valorpagadoanterior4 }} </td>
                                <td> {{ $p->valoranterior3 - $p->valorpagadoanterior3 }} </td>
                                <td> {{ $p->valoranterior2 - $p->valorpagadoanterior2 }} </td>
                                <td> {{ $p->valoranterior1 - $p->valorpagadoanterior1 }} </td>
                                <td> {{ $p->valoractual - $p->valorpagadoactual }} </td>
                                <td> {{ $p->valorsiguiente1 - $p->valorpagadosiguiente1 }} </td>
                                <td> {{ $p->valorsiguiente2 - $p->valorpagadosiguiente2 }} </td>
                                <td> {{ $p->valorsiguiente3 - $p->valorpagadosiguiente3 }} </td>
                                <td> {{ $p->valorsiguiente4 - $p->valorpagadosiguiente4 }} </td>
                                <td> {{ $p->valorsiguiente5 - $p->valorpagadosiguiente5 }} </td>
                                <td> {{ $p->valorsiguiente6 - $p->valorpagadosiguiente6 }} </td>

                                 
                                @can('finalContrato.edit')
                                <td width="10px">
                                    <a href="{{ route('finalContrato.edit', [$p->id_publicacion,0,0,1]) }}"><span class="btn btn-warning btn-circle btn-lg"><i class="ti-pencil-alt"></i></span></a>
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
        'excel', 'pdf'
    ],
    columnDefs: [
        {
            "targets": 8,
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
        $(this).html( title+'<br/><input type="text" style="width:100px" placeholder="Buscar" />' );
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