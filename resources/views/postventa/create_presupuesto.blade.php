@extends('admin.layout')
@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> <h1><center>PRESUPUESTO # {{ $presupuesto->id }}</center></h1></div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('presupuesto.agregar') }}" method="post" enctype='multipart/form-data'>
                         {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                          <div class="col-sm-3">
                                <input type="hidden" name="id_presupuesto" id="id_presupuesto" value="{{ $presupuesto->id }}">
                                <label>Proveedor</label>
                                <select name="proveedor" id="proveedor" class="form-control" required="required" >
                                    <option value="">Seleccione Proveedor</option>
                                    @foreach($proveedores as $s)
                                         <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Familia</label>
                                <select name="familia" id="familia" class="form-control" required="required" >
                                    <option value="">Seleccione Familia</option>
                                    @foreach($familia as $s)
                                         <option value="{{ $s->id }}">{{ $s->familia }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <label>Item</label>
                                <select name="item" id="item" class="form-control" required="required" >
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>C/U $ Proveedor</label>
                                <input name="valorproveedor" id="valorproveedor" type="text" class="form-control"  required="required" value="0">
                            </div>
                        </div>
                        <br>
                        <div class="row">

                            <div class="col-sm-2">
                                <label>Cantidad</label>
                                <input value="0" name="cantidad" id="cantidad" type="number" class="form-control" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>% Recargo</label>
                                <input name="por_recargo" id="por_recargo" type="number" class="form-control" step="any" required="required" value="30">
                            </div>
                           <div class="col-sm-2">
                                <label>C/U $ Baquedano</label>
                                <input name="valorbaquedano" id="valorbaquedano" type="text" class="form-control" readonly="readonly"  required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Pago a Baquedano</label>
                                <input name="monto_baquedano" id="monto_baquedano" type="number" class="form-control" readonly="readonly" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Pago a Proveedor</label>
                                <input name="monto_proveedor" id="monto_proveedor" type="number" class="form-control" readonly="readonly" required="required" >
                            </div>
                            <div class="col-sm-2">
                                <label>Sub Total </label>
                                <input name="subtotal" id="subtotal" type="number" class="form-control" step="any" readonly="readonly" required="required" >
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                              <div class="col-sm-6">
                                <table border="1" width="100%">
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
                         <hr>
                         <div class="row">
                                 <div class="form-actions">
                                       <center> <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Item</button>
                                       <a href="{{ route('postventa.edit',[$presupuesto->id_postventa,8]) }}" class="btn btn-warning" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                       <a href="{{ route('presupuesto.exportarexcel',[$presupuesto->id]) }}" class="btn btn-primary" style="color:white">Exportar Presupuesto</a></center>

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
                                                <th>Familia</th>
                                                <th>Item</th>
                                                <th>Proveedor</th>
                                                <th>C/U $ Proveedor</th>
                                                <th>C/U $ Baquedano</th>
                                                <th>Cantidad</th>
                                                <th>$ Proveedor</th>
                                                <th>$ Baquedano</th>
                                                <th>$ Subtotal</th>
                                                <th>Fecha Creación</th>
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
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

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
       "url": "/presupuesto/listadodetalle/{{ $presupuesto->id }}"
    },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'familia', name: 'familia'},
                {data: 'item', name: 'item'},
                {data: 'proveedor', name: 'proveedor'},
                {data: 'valor_unitario_proveedor', name: 'valor_unitario_proveedor'},
                {data: 'valor_unitario_baquedano', name: 'valor_unitario_baquedano'},
                {data: 'cantidad', name: 'cantidad'},
                {data: 'monto_proveedor', name: 'monto_proveedor'},
                {data: 'monto_baquedano', name: 'monto_baquedano'},
                {data: 'subtotal', name: 'subtotal'},
                {data: 'created_at', name: 'created_at'},
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


$("#cantidad").keyup(function (event) {

    if($("#familia").val()=='' || $("#item").val()=='' || $("#valorproveedor").val()=='' ){
        alert("Debe seleccionar e ingresar valor de Item");
        return false;
    }
        $("#valorbaquedano").val(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        console.log(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        $("#monto_baquedano").val($("#valorbaquedano").val()*this.value);
        $("#monto_proveedor").val($("#valorproveedor").val()*this.value);
        $("#subtotal").val(parseInt($("#monto_baquedano").val())+parseInt($("#monto_proveedor").val()));
});

$("#valorproveedor").keyup(function (event) {

    if($("#familia").val()=='' || $("#item").val()=='' || $("#valorproveedor").val()=='' ){
        alert("Debe seleccionar e ingresar valor de Item");
        return false;
    }
        $("#valorbaquedano").val(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        console.log(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        $("#monto_baquedano").val($("#valorbaquedano").val()*this.value);
        $("#monto_proveedor").val($("#valorproveedor").val()*this.value);
        $("#subtotal").val(parseInt($("#monto_baquedano").val())+parseInt($("#monto_proveedor").val()));
});

$("#por_recargo").keyup(function (event) {

    if($("#familia").val()=='' || $("#item").val()=='' || $("#valorproveedor").val()=='' ){
        alert("Debe seleccionar e ingresar valor de Item");
        return false;
    }
        $("#valorbaquedano").val(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        console.log(Math.round($("#valorproveedor").val()*($("#por_recargo").val()/100)));
        $("#monto_baquedano").val($("#valorbaquedano").val()*this.value);
        $("#monto_proveedor").val($("#valorproveedor").val()*this.value);
        $("#subtotal").val(parseInt($("#monto_baquedano").val())+parseInt($("#monto_proveedor").val()));
});

$("#familia").change(function (event) {
    $("#item").empty();
    $.get("/presupuesto/getitems/" + event.target.value + "", function (response, state) {
        $("#item").append("<option value=''>Seleccione Item</option>");
        for (i = 0; i < response.length; i++) {
            $("#item").append("<option value='" + response[i].id + "'>" + response[i].item + "</option>");
        }
    });
});

</script>




@endsection