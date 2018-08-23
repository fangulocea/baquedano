@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<div id="tabla" >
    <div class="white-box">
        <h3 class="box-title m-b-0">Gestión de Captaciones</h3>
        <p class="text-muted m-b-30">Administración de registros para el proceso de captación</p>
        <div class="table-responsive" style="padding-bottom: 50px;">
            <table id="listusers" class="display compact" cellspacing="0" width="200%">
      
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Propietario</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Fecha Publicación</th>
                        <th>Tipo Contacto</th>
                        <th>Creador Gestión</th>
                        <th>Estado</th>
                        <th>Postal</th>
                        <th>Creador</th>
                        <th>Fecha Creación</th>
                        <th>Acción</th>
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
<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<!-- end - This is for export functionality only -->
<script>
var SweetAlert = function () {};

//examples 
SweetAlert.prototype.init = function () {

       

    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);


var table = $('#listusers').DataTable({

    dom: 'Bfrtip',
    "ordering": false,
       "processing": true,
        "serverSide": true,
      "ajax": {
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"},
       "url": "{{ route('captacion.index_ajax') }}"

    },
            "columns": [
                {data: 'id_link', name: 'id_link'},
                {data: 'tipo', name: 'tipo'},
                {data: 'Direccion', name: 'Direccion'},
                {data: 'comuna_nombre', name: 'comuna_nombre'},
                {data: 'Propietario', name: 'Propietario'},
                {data: 'email', name: 'email'},
                {data: 'telefono', name: 'telefono'},
                {data: 'fecha_publicacion', name: 'fecha_publicacion'},
                {data: 'tipo_contacto', name: 'tipo_contacto'},
                {data: 'creador_gestion', name: 'creador_gestion'},
                {data: 'id_estado', name: 'id_estado'},
                {data: 'portal', name: 'portal'},
                {data: 'Creador', name: 'Creador'},
                {data: 'fecha_creacion', name: 'fecha_creacion'},
                {data: 'action', name: 'action'}
            ],
    buttons: [
          {
            text: 'Excel',
            action: function ( e, dt, node, config ) {
                 swal("Descargarán todas las captaciones, Un momento por favor");
                 window.location.href = '{{ route("captacion.excel") }}';
            }
        },  {
            text: 'Ingresar Captación',
            action: function ( e, dt, node, config ) {
                 window.location.href = '{{ route("captacion.create") }}';
            }
        }

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
        $(this).html( title+'<br/><input type="text" style="width:70px" placeholder="" />' );
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