@extends('admin.layout')

@section('contenido')

<div id="tabla" class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title m-b-0">Reporte Seguimiento de Captaciones</h3>
        <p class="text-muted m-b-30"></p>
        <hr>

            <div class="table-responsive" style="padding-bottom: 50px;">
                <table id="listusers" class="display compact" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Portal</th>
                            <th>Dirección</th>
                            <th>Propietario</th>
                            <th>Fecha Creación</th>
                            <th>Creador</th>
                            <th>Estado</th>
                            <th>Cant Correos</th>
                            <th>Cant Gest.</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Portal</th>
                            <th>Dirección</th>
                            <th>Propietario</th>
                            <th>Fecha Creación</th>
                            <th>Creador</th>
                            <th>Estado</th>
                            <th>Cant Correos</th>
                            <th>Cant Gest.</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @foreach($publica as $p)
                        <tr>
                            <td>{{ $p->id_publicacion }}</td>
                            <td>{{ substr(substr($p->portal, 4),0,10) }}</td>
                            <td>{{ $p->direccion }} #{{ $p->numero }} , Dpto {{ $p->departamento }}, {{ $p->comuna_nombre }}</td>
                            <td>{{ $p->nom_p }} {{ $p->apep_p }} {{ $p->apem_p }}</td>
                            <td>{{ $p->fecha_creacion }}</td>
                            <td>{{ $p->nom_c }} {{ $p->apep_c }} {{ $p->apem_c }}</td>
                            <td>{{ trans_choice('mensajes.captacion', $p->id_estado) }}</td>
                            <td>{{ $p->cantCorreos }}</td>
                            <td>{{ $p->cantGes }}</td>
                            <td width="10px">  </td>
                            <td width="10px" style="text-align: center;">
                                
        
                                
                            </td>
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


      var table = $('#listusers').DataTable({
        dom: 'Bfrtip',
    // buttons: [
    //     'copy', 'csv', 'excel', 'pdf', 'print',{
    //         text: 'Ingresar Captación',
    //         action: function ( e, dt, node, config ) {
    //              window.location.href = '{{ route("captacion.create") }}';
    //         }
    //     }

    // ],
     columnDefs: [{
             "targets": [8, 9],
             "orderable": false
         }],
         "ordering": false,
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
        if(title!='ID' && title!= "" )
       $(this).html( title+'<br/><input type="text" style="width:100px" placeholder="Buscar" />' );
    } );
 

 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );

</script>


@endsection