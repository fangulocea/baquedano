@extends('admin.layout')
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading"> CREACIÓN DE SOLICITUD DE SERVICIO ARRENDATARIO</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <h1><center>SOLICITUD # {{ $nuevo_servicio->id }}</center></h1>
                    <hr>
                    <form action="{{ route('arrsolservicio.store') }}" method="post" enctype='multipart/form-data'>
                         {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-5">
                                <input type="hidden" name="id_solicitud" id="id_solicitud" value="{{ $nuevo_servicio->id }}">
                                <input type="hidden" name="id_contrato" id="id_contrato" value="{{ $idcontrato }}">
                                <input type="hidden" name="id_inmueble" id="id_inmueble" value="{{ $nuevo_servicio->id_inmueble }}">
                                <input type="hidden" name="id_arrendatario" id="id_arrendatario" value="{{ $nuevo_servicio->id_arrendatario }}">
                                <label>Catálogo de Servicios</label>
                                <select name="servicio" id="servicio" class="form-control" required="required" >
                                    <option value="">Seleccione servicio</option>
                                    @foreach($servicio as $s)
                                         <option value="{{ $s->id }}">{{ $s->nombre_servicio }}({{ $s->detalle }} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Moneda</label>
                                <input name="moneda" id="moneda" type="text" class="form-control" readonly="readonly" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Valor Moneda</label>
                                <input name="valor_moneda" id="valor_moneda" type="text" class="form-control" readonly="readonly" required="required" >
                            </div>

                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-5">

                            </div>
                            <div class="col-sm-2">
                                <label>Valor</label>
                                <input name="valor_en_moneda" id="valor_en_moneda" type="number" class="form-control" step="any" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Cantidad</label>
                                <input name="cantidad" id="cantidad" type="number" class="form-control" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Sub Total </label>
                                <input name="subtotal" id="subtotal" type="number" class="form-control" step="any" readonly="readonly" required="required" >
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
                                <label>Motivos Generales</label>
                                <input name="motivos" id="motivos" type="text" class="form-control" required="required" >
                                <br/>
                                 <div class="form-actions">
                                       <center> <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Servicio</button>
                                       <a href="{{ route('arrsolservicio.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                       <a href="/arrsolservicio/{{ $nuevo_servicio->id }}/comprobante"><span class="btn btn-primary">Comprobante</span></a></center>

                                </div>
                                <div class="white-box"> 
                                <table border="1" width="100%">
                                    <tr>
                                        <td width="40%" >
                                         <h2><center>TOTAL UF</center></h2>
                                        </td>
                                        <td>
                                         <h2><center>{{ $totaluf or 0 }}</center></h2>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="40%">
                                            <h2><center>TOTAL $</center></h2>
                                        </td>
                                        <td>
                                            <h2><center>{{ $totalpesos or 0 }}</center></h2>
                                        </td>
                                    </tr>
                                </table>
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
                                                <th>Nombre de Servicio</th>
                                                <th>Detalle</th>
                                                <th>Valor UF</th>
                                                <th>Valor $</th>
                                                <th>Cantidad</th>
                                                <th>Sub Total UF</th>
                                                <th>Sub Total $</th>
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
       "processing": true,
        "serverSide": true,
      "ajax": {
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"},
       "url": "/arrsolservicio/listadodetalle/{{ $nuevo_servicio->id }}"
    },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nombre_servicio', name: 'nombre_servicio'},
                {data: 'detalle', name: 'detalle'},
                {data: 'valor_en_uf', name: 'valor_en_uf'},
                {data: 'valor_en_pesos', name: 'valor_en_pesos'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'subtotal_uf', name: 'subtotal_uf'},
                {data: 'subtotal_pesos', name: 'subtotal_pesos'},
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