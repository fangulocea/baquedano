@extends('admin.layout')

@section('contenido')

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
                        <th>Corredor</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Propietario</th>
                        <th>Mail</th>
                        <th>Teléfono</th>
                        <th>Fecha/P</th>
                        <th>Gestión/ Ultima</th>
                        <th>Gestión/ Creador</th>
                        <th>Estado</th>
                        <th>Portal</th>
                        <th>Creador</th>
                        <th>Fecha/C</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Corredor</th>
                        <th>Dirección</th>
                        <th>Comuna</th>
                        <th>Propietario</th>
                        <th>Mail</th>
                        <th>Teléfono</th>
                        <th>Fecha/P</th>
                        <th>Gestión/ Ultima</th>
                        <th>Gestión/ Creador</th>
                        <th>Estado</th>
                        <th>Portal</th>
                        <th>Creador</th>
                        <th>Fecha/C</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($publica as $p)
                            <tr>


                                <td style="font-size: x-small;"><a href="{{ route('captacion.edit', [$p->id_publicacion,2]) }}"> {{ $p->id_publicacion }}</a></td>
                                <td style="font-size: x-small;"><a href="{{ route('captacion.edit', [$p->id_publicacion,2]) }}"> {{ $p->tipo }}</a></td>
                                <td style="font-size: x-small;"> {{ $p->Externo }}</td>
                                
                                <td style="font-size: small;"><a href="{{ route('captacion.edit', [$p->id_publicacion,2]) }}">{{ $p->direccion }} #{{ $p->numero }} , Dpto {{ $p->departamento }}</a></td>
                                <td style="font-size: small;"> {{ $p->comuna_nombre }}</td>
                                
                                <td style="font-size: small;">{{ $p->nom_p }} {{ $p->apep_p }} {{ $p->apem_p }}</td>
                                <td style="font-size: x-small;">{{ $p->email }}</td>
                                <td>{{ $p->telefono }}</td>
                                <td style="font-size: small;">{{ $p->fecha_publicacion }}</td>
                                <td style="font-size: small;">{{ $p->tipo_contacto }}</td>
                                <td style="font-size: small;">{{ $p->creador_gestion }}</td>
                                
                              <!--   <td style="font-size: small;">{{ $p->fecha_modificacion }}</td>
                                <td>{{ $p->nom_m }}</td>-->
                                 <td>{{ trans_choice('mensajes.captacion', $p->id_estado) }}</td>
                                 <td style="font-size: small;">{{ substr(substr($p->portal, 4),0,10) }}</td>
                                 <td style="font-size: small;">{{ $p->Creador }} </td>
                                  <td style="font-size: small;">{{ $p->fecha_creacion }} </td>

                                @can('captacion.edit')
                                <td width="10px">
                                    <a href="{{ route('captacion.edit', [$p->id_publicacion,2]) }}"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>
                                </td>
                                @endcan
                                @can('captacion.destroy')
                                <td width="10px">

                                    {!! Form::open(['route' => ['captacion.destroy', $p->id_publicacion], 
                                    'method' => 'DELETE']) !!}
                                        <button class="btn btn-danger btn-circle btn-sm"><i class="ti-trash"></i>
                                        </button>
                                    {!! Form::close() !!}
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
    "ordering": false,
    pageLength: 20,
    buttons: [
         'excel', 'pdf', 'print',{
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