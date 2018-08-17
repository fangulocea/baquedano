@extends('admin.layout')

@section('contenido')
@php 
    use App\Http\Controllers\ChecklistController;
@endphp
<div id="tabla" >
    <div class="white-box">
        <h3 class="box-title m-b-0">Gestión de CheckList {{ $tipoACrear }}</h3>
        <p class="text-muted m-b-30">Administración de registros para el proceso de CheckList</p>
        <div class="table-responsive" style="padding-bottom: 50px;">
            <table id="listusers" class="display compact" cellspacing="0" width="200%">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Id Contrato</th>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Id Contrato</th>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                         @php 
                            $valida = 0;                    
                        @endphp
                    @foreach($publica as $p)
                        @php 
                            if($valida != $p->id_contrato){                    
                        @endphp
                            <tr>
                                <td>{{ $p->id }}</td>
                                <td>{{ $p->id_contrato }} </td>
                                <td>{{ $p->tipo }} </td>
                                <td>{{ $p->direccion }}, N°{{ $p->numero }}, {{ $p->comuna }}</td>
                                <td width="10px">
                                    <a href="{{ route('checklist.create', [$p->id_contrato, 0, $tipoACrear,"Entrega","menu"]) }}" class="btn btn-info" style="color:white"><i class="ti-pencil-alt"></i>&nbsp;&nbsp;Entrega</a>
                                </td>
                                <td width="10px">
                                    <a href="{{ route('checklist.create', [$p->id_contrato, 0, $tipoACrear,"Devolución","menu"]) }}" class="btn btn-info" style="color:white"><i class="ti-pencil-alt"></i>&nbsp;&nbsp;Devolución</a>
                                </td>
                                <td width="10px">
                                    <a href="{{ route('checklist.create', [$p->id_contrato, 0, $tipoACrear,"Revisión","menu"]) }}" class="btn btn-info" style="color:white"><i class="ti-pencil-alt"></i>&nbsp;&nbsp;Revisión</a>
                                </td>
                            </tr>
                        @php
                            $valida = $p->id_contrato; 
                        }
                            $valida = $p->id_contrato;
                        @endphp


                    @endforeach

                </tbody>
            </table>
            <a href="{{ route('checklist.index',"menu" ) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
        </div>
    </div>
</div>


<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css" />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
<script src= "{{ URL::asset('plugins/DataTables/datatables.min.js') }}"> </script>
<script src= "{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"> </script>
<script src= "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"> </script>
<script src= "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"> </script>
<!-- end - This is for export functionality only -->
<script>
    var table = $('#listusers').DataTable({
        dom: 'Bfrtip',
        ordering: false,
        pageLength: 20,
        ServerSide: true,
        deferRender: true,
        buttons: [  ],
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
    if(title!='ID' && title!= "") {
       $(this).html( title+'<br/><input type="text" style="width:70px" placeholder="" />' );
   }
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