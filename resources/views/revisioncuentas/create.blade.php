@extends('admin.layout')
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading"> CREACIÓN DE SOLICITUD DE SERVICIO ARRENDATARIO</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">

         <center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna_nombre or null }}</h3></center>

                <center><h3 class="box-title m-b-0">{{ $persona->nombre or null }} {{ $persona->apellido_paterno or null }} {{ $persona->apellido_materno or null }}, {{ $persona->telefono or null }}, {{ $persona->email or null }}</h3></center>

                    <form action="{{ route('revisioncuentas.store') }}" method="post" enctype='multipart/form-data'>
                         {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-3">

                                <input type="hidden" name="id_contrato" id="id_contrato" value="{{ $idcontrato }}">
                                <input type="hidden" name="id_inmueble" id="id_inmueble" value="{{ $inmueble->id }}">
                                <input type="hidden" name="id_arrendatario" id="id_arrendatario" value="{{ $captacion->id_arrendatario }}">
                                <label>Empresas de Servicios</label>
                                <select name="servicio" id="servicio" class="form-control" required="required" >
                                    <option value="">Seleccione Empresa</option>
                                    @foreach($servicio as $s)
                                         <option value="{{ $s->id }}">{{ $s->nombre }} ({{ $s->descripcion }} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <label>ID CLIENTE</label>
                                <input name="idcliente" id="idcliente" type="text" class="form-control"  >
                            </div>
                            <div class="col-sm-2">
                                <label for="input-file-now-custom-1">Mes</label>
                                                        <select name="mes" class="form-control" required="required">
                                                            <option value="1">Enero</option>
                                                            <option value="2">Febrero</option>
                                                            <option value="3">Marzo</option>
                                                            <option value="4">Abril</option>
                                                            <option value="5">Mayo</option>
                                                            <option value="6">Junio</option>
                                                            <option value="7">Julio</option>
                                                            <option value="8">Agosto</option>
                                                            <option value="9">Septiembre</option>
                                                            <option value="10">Octubre</option>
                                                            <option value="11">Noviembre</option>
                                                            <option value="12">Diciembre</option>
                                                        </select>
                                
                            </div>
                            <div class="col-sm-2">
                                <label>Año</label>
                                <input name="anio" id="anio" type="number" class="form-control" required="required" value="<?=date("Y")?>" >
                            </div>
                             <div class="col-sm-2">
                                <label>Fecha Vencimiento</label>
                                <input name="fecha_vencimiento" id="fecha_vencimiento" type="date" class="form-control" required="required"  >
                            </div>
                         <div class="col-sm-2">
                                <label>Monto</label>
                                <input name="valor_en_moneda" id="valor_en_moneda" type="number" class="form-control" step="any" required="required" >
                            </div>
                        </div>
                        
                        <hr>
                        <div class="row">
                            <div class="col-sm-6">
                                    <div class="white-box"> 
                                        <h3 class="box-title">Subir Documento</h3>
                                        <label for="input-file-now-custom-1">Documentación de Respaldo</label>
                                        <input type="file" id="foto" name="foto"  class="dropify"  />  
                                    </div>
                                </div>
                            <div class="col-sm-6">
                                 <div class="white-box"> 
                                 <div class="form-actions">
                                       <center> <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Servicio</button>
                                       <a href="{{ route('revisioncuentas.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a></center>

                                </div>
                                
                            </div>
                            </div>
                        </div>
                    </form>
                        <hr>
                        <div id="tabla2" >
                            <div class="white-box">
                                
                                <div class="table-responsive" style="padding-bottom: 50px;">
                                    <table id="listventas" class="display compact" cellspacing="0" width="200%">
                              
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre de Empresa</th>
                                                <th>Detalle</th>
                                                <th>Mes</th>
                                                <th>Año</th>
                                                <th>Valor</th>
                                                <th>Fecha Vencimiento</th>
                                                 <th>Estado</th>
                                                  
                                                <th>Acción</th>
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
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

  <script type="text/javascript">

            $('.dropify').dropify();

    </script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>

<script>




var listventas = $('#listventas').DataTable({

    dom: 'Bfrtip',
        ordering: false,
        pageLength: 10,
        ServerSide: true,
        deferRender: true,
      "ajax": {
       "url": "/revisioncuentas/listadodetalle/{{  $idcontrato }}"
    },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nombreempresa', name: 'nombreempresa'},
                {data: 'detalle', name: 'detalle'},
                {data: 'mes', name: 'mes'},
                {data: 'anio', name: 'anio'},
                {data: 'valor_en_pesos', name: 'valor_en_pesos'},
                {data: 'fecha_vencimiento', name: 'fecha_vencimiento'},
                 {data: 'estado', name: 'estado'},
                {data: 'action', name: 'action'}
            ],
    buttons: [
        'excel'
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





$("#servicio").change(function (event) {
    $.get("/solservicio/" + event.target.value + "", function (response, state) {

        if(response.moneda=='UF'){
            $("#moneda").val('UF');
            $("#valor_moneda").val({{ $uf->valor or 0 }});
            
        }else{
            $("#moneda").val('CLP');
            $("#valor_moneda").val(1);
        }
        $("#valor_en_moneda").val(response.valor_en_moneda!=''?response.valor_en_moneda:0);

    });
});

$("#cantidad").keyup(function (event) {

        $("#subtotal").val($("#valor_en_moneda").val()*this.value);


});

</script>


@endsection