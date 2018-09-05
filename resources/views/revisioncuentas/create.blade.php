@extends('admin.layout')
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-success">
            <div class="panel-heading">REVISIÓN DE CUENTAS INMUEBLE</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">

         <h3 class="box-title m-b-0">INMUEBLE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $comuna->comuna_nombre or null }}</h3>
         <h3 class="box-title m-b-0">PROPIETARIO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;{{ $propietario->nombre or null }} {{ $propietario->apellido_paterno or null }} </h3>
         <h3 class="box-title m-b-0">ARRENDATARIO&nbsp;&nbsp;:{{ $arrendatario->nombre or null }} {{ $arrendatario->apellido_paterno or null }} </h3>
                    <hr>
                    <form action="{{ route('revisioncuentas.store') }}" method="post" enctype='multipart/form-data'>
                         {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="hidden" name="id_contrato" id="id_contrato" value="{{ $idcontrato }}">
                                <input type="hidden" name="id_inmueble" id="id_inmueble" value="{{ $inmueble->id }}">
                                <input type="hidden" name="id_arrendatario" id="id_arrendatario" value="{{ $arrendatario->id or null}}">
                                <input type="hidden" name="id_propietario" id="id_propietario" value="{{ $propietario->id or null}}">
                                <label>Empresas de Servicios</label>
                                <select name="servicio" id="servicio" class="form-control" required="required" >
                                    <option value="">Seleccione Empresa</option>
                                    @foreach($servicio as $s)
                                         <option value="{{ $s->id }}">{{ $s->nombre }} ({{ $s->descripcion }} )</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
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
                             <div class="col-sm-3">
                                <label>Fecha Vencimiento</label>
                                <input name="fecha_vencimiento" id="fecha_vencimiento" type="date" class="form-control" required="required"  >
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                                <label>Fecha Contrato</label>
                                <input name="fecha_contrato" id="fecha_contrato" type="date" class="form-control" readonly="readonly" required="required" value="{{ $contratofinal->fecha_firma }}" >
                            </div>
                        <div class="col-sm-3">
                                <label>Inicio Lectura</label>
                                <input name="inicio_lectura" id="inicio_lectura" type="date" class="form-control"  >
                            </div>
                       <div class="col-sm-3">
                                <label>Fin Lectura</label>
                                <input name="fin_lectura" id="fin_lectura" type="date" class="form-control"   >
                            </div>
                         <div class="col-sm-2">
                                <label>Valor Medición</label>
                                <input name="valor_medicion" id="valor_medicion" type="number" class="form-control" step="any" >
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                         <div class="col-sm-2">
                                <label>Monto de Boleta</label>
                                <input name="monto_boleta" id="monto_boleta" type="number" class="form-control" step="any" required="required" >
                            </div>
                             <div class="col-sm-2">
                                <label style="color:red">Días Proporcionales</label>
                                <input name="dias_proporcionales" id="dias_proporcionales" type="number" class="form-control" step="any" readonly="readonly" >
                            </div>
                             <div class="col-sm-2">
                                <label style="color:red">$ Pagar Responsable</label>
                                <input name="monto_responsable" id="monto_responsable" type="number" class="form-control" step="any" readonly="readonly" >
                            </div>

                             <div class="col-sm-3">
                                <label style="color:red">Responsable</label>
                                <select name="responsable" id="responsable" class="form-control"  >
                                    <option value="Propietario">Propietario</option>
                                    <option value="Arrendatario">Arrendatario</option>
                                </select>
                                   
                            </div>
                             <div class="col-sm-2">
                                <label style="color:red"><strong>Solicitud de Pago</strong></label>
                                <select name="itempago" id="itempago" class="form-control"  >
                                    <option value="NO">NO</option>
                                    <option value="SI">SI</option>
                                </select>
                                   
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
                                <div class="row">
                                         <div class="white-box"> 
                                         <div class="form-actions">
                                               <center> <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                               <a href="{{ route('revisioncuentas.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                               <a  class="btn btn-warning" style="color:white" id="calcular">Calcular Proporcional</a></center>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group"> 
                                        <div class="col-sm-6">
                                            <center><h3 class="box-title" style="background-color: #F2F3F4">Monto a Propietario no Procesado</h3>
                                            <label for="input-file-now-custom-1"> $ {{ $proc_propietario }}</label></center>
                                        </div>
                                        <div class="col-sm-6">
                                            <center>
                                            <h3 class="box-title" style="background-color: #F2F3F4">Monto a Arrendatario no Procesado</h3>
                                            <label for="input-file-now-custom-1"> $ {{ $proc_arrendatario }}</label></center>
                                        </div>
                                    </div>
                                        <div class="form-group"> 
                                        <div class="col-sm-6">
                                            <a href="{{ route('revisioncuentas.generarsolp', $idcontrato) }}" class="btn btn-primary" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;Generar Solicitud Propietario</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="{{ route('revisioncuentas.generarsola', $idcontrato) }}" class="btn btn-primary" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;Generar Solicitud Arrendatario</a>
                                        </div>
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
                                                <th>Fecha Ven.</th>
                                                <th>Monto Boleta</th>
                                                <th>Responsable</th>
                                                <th>Monto Respon.</th>
                                                <th>Solicitud de pago</th>
                                                <th>Procesado</th>
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
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script>

var SweetAlert = function () {};

SweetAlert.prototype.init = function () {
    $("#calcular").click(function (event) {
        var fecha1 = $("#inicio_lectura").val();
        var fecha2 = $("#fecha_contrato").val();
        var monto = $("#monto_boleta").val();
        var valorlectura = $("#valor_medicion").val();
        if(fecha2=='' || monto=='' ||  valorlectura==''){
            swal("Debe completar los campos de lectura y montos");
            return false;
        }

        let fecha11 = new Date(fecha1);
        let fecha22 = new Date(fecha2);
        let resta = fecha22.getTime() - fecha11.getTime();
        dias_proporcionales=Math.round(resta/ (1000*60*60*24));
        dias_del_mes= new Date(fecha11.getFullYear(), fecha11.getMonth()+1, 0).getDate();
        valor_diario=Math.round(monto/dias_del_mes);
        valor_proporcional=valor_diario*dias_proporcionales;
        if(dias_del_mes==dias_proporcionales){
            valor_proporcional=monto;
        }
        if(valor_proporcional<1){
            valor_proporcional=0;
        }
        if(dias_proporcionales<1){
            dias_proporcionales=0;
        }   
        $("#monto_responsable").val(valor_proporcional);  
        $("#dias_proporcionales").val(dias_proporcionales);

    });

}(window.jQuery);


var listventas = $('#listventas').DataTable({

    dom: 'Bfrtip',
    "ordering": false,
       "processing": true,
        "serverSide": true,
      "ajax": {
        "dataType": "json",
        "type": "POST",
        "data":{ _token: "{{csrf_token()}}"},
       "url": "/revisioncuentas/listadodetalle/{{  $idcontrato }}"
    },
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'nombreempresa', name: 'nombreempresa'},
                {data: 'detalle', name: 'detalle'},
                {data: 'mes', name: 'mes'},
                {data: 'anio', name: 'anio'},
                {data: 'fecha_vencimiento', name: 'fecha_vencimiento'},
                {data: 'monto_boleta', name: 'monto_boleta'},
                {data: 'responsable', name: 'responsable'},
                {data: 'monto_responsable', name: 'monto_responsable'},
                 {data: 'solicitudpago', name: 'solicitudpago'},
                 {data: 'procesado', name: 'procesado'},
                 
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
    $.get("/idcliente/" + event.target.value + "/"+$("#id_inmueble").val(), function (response, state) {
console.log(response);
        if(response.idcliente!=null){
            $("#idcliente").val(response.idcliente);
        }

    });
});



</script>


@endsection