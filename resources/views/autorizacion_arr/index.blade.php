@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading"> CREACIÓN DE SOLICITUD DE SERVICIO ARRENDATARIO</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                        <div id="tabla" >
                            <div class="white-box">
                                <div class="table-responsive" style="padding-bottom: 50px;">
                                    <table id="listusers" class="display compact" cellspacing="0" width="200%">
                              
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Estado</th>
                                                <th>Dirección</th>
                                                <th>Comuna</th>
                                                <th>Arrendatario</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Creador</th>
                                                <th>Fecha Creación</th>
                                                <th>Autorizador</th>
                                                <th>Fecha Autorización</th>
                                                <th>Fecha UF</th>
                                                <th>Valor UF</th>
                                                <th>Precio UF</th>
                                                <th>Precio Pesos</th>
                                                <th>Acción_Realizar</th>
                                            </tr>
                                        </thead>
                                        
                                    </table>
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
<!-- end - This is for export functionality only -->
<script>
$('.sorting_desc').hide();

var table = $('#listusers').DataTable({

    dom: 'Bfrtip',
    buttons: [
        'excel'
        
    ],
    ordering: false,
    pageLength: 10,
       "processing": true,
        "serverSide": true,
      "ajax": {
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"},
       "url": "{{ route('arrsolservicio.autoriza_index_ajax_arr') }}"
    },
            "columns": [
                {data: 'id_link', name: 'id_link'},
                {data: 'Estado', name: 'Estado'},
                {data: 'Direccion', name: 'Direccion'},
                {data: 'Comuna', name: 'Comuna'},
                {data: 'Arrendatario', name: 'Arrendatario'},
                {data: 'email', name: 'email'},
                {data: 'telefono', name: 'telefono'},
                {data: 'Creador', name: 'Creador'},
                {data: 'FechaCreacion', name: 'FechaCreacion'},
                {data: 'Autorizador', name: 'Autorizador'},
                {data: 'fecha_autorizacion', name: 'fecha_autorizacion'},
                {data: 'fecha_uf', name: 'fecha_uf'},
                {data: 'valor_uf', name: 'valor_uf'},
                {data: 'valor_en_uf', name: 'valor_en_uf'},
                {data: 'valor_en_pesos', name: 'valor_en_pesos'},
                {data: 'action', name: 'action'}
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
        $(this).html( title+'<br><input type="text" style="width:100px"  />' );
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