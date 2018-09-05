@extends('admin.layout')

@section('contenido')

<div class="col-sm-12">
    <div class="white-box">
        <h3 class="box-title m-b-0">Administración de Personas</h3>
        <p class="text-muted m-b-30">Gestionar Personas del sistema</p>
        <div class="table-responsive">
            <table id="listusers" class="display compact" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th># Rev</th>
                         <th># Doc</th>
                        <th></th>
                    </tr>
                </thead>
               
            </table>
        </div>
    </div>
</div>



<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />


<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>

<!-- end - This is for export functionality only -->
<script>

var table =$('#listusers').DataTable({

    dom: 'Bfrtip',
    "ordering": false,
       "processing": true,
        "serverSide": true,
      "ajax": {
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"},
       "url": "{{ route('revisionpersona.index_ajax') }}"
    },
            "columns": [
                {data: 'id_link', name: 'id_link'},
                {data: 'telefono', name: 'telefono'},
                {data: 'email', name: 'email'},
                {data: 'Persona', name: 'Persona'},
                {data: 'tipo_cargo', name: 'tipo_cargo'},
                {data: 'cant_revisiones', name: 'cant_revisiones'},
                {data: 'cant_fotos', name: 'cant_fotos'},
                {data: 'action', name: 'action'}
            ],
    buttons: [
        'excel'

    ],

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
 $('#listusers thead th').each( function () {
        var title = $(this).text();
        if(title!='ID' && title!= "" && title!= "# Rev"&& title!= "# Doc" )
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