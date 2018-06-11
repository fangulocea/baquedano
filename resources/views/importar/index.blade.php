@extends('admin.layout')

@section('contenido')

<link href="{{ URL::asset('plugins/bower_components/jquery-wizard-master/css/wizard.css') }}" rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">

<div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                                   
                            <h3 class="box-title m-b-0">Proceso de Captación</h3>
                            <p class="text-muted m-b-30 font-13">Paso a paso Captacio</p>
                            <div id="masivo" class="wizard">
                                <ul class="wizard-steps" role="tablist">
                                    <li class="active" role="tab">
                                        <h4><span>1</span>Subida de Archivo</h4> </li>
                                    <li role="tab">
                                        <h4><span>2</span>Envío de Correos</h4> </li>
                                    <li role="tab">
                                        <h4><span>3</span>Gestión de Captaciones</h4> </li>
                                </ul>
                                <div class="wizard-content">
                                    <div class="wizard-pane active" role="tabpanel"><div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">1.- Debe verificar el formato del archivo de subida</h3>
                            <h3 class="box-title m-b-0">2.- Subir archivo (Se recomienda cada 10 registros)</h3>
                            <h3 class="box-title m-b-0">3.- Verificar contenido subido o Limpiar Memoria</h3>
                            <h3 class="box-title m-b-0">4.- Procesar los registros</h3>
                            <h3 class="box-title m-b-0">5.- Pasar al siguiente Paso</h3>
                            <br/>
                            <form  class="form-horizontal" action="{{ route('captacion.importExcel') }}"  method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                         <input type="hidden" name="idusuario" value="{{ Auth::user()->id }}">
                                <div class="form-group">
                                    <label class="col-md-12"> <span class="help"></span></label>
                                    <div class="col-md-3">
                                        <a class="btn btn-primary" href="{{ URL::asset('uploads/formato.xlsx') }}">Formato de subida</a> </div>
                                    <div class="col-md-3">
                                        <a class="btn btn-warning" href="{{ URL::to('downloadExcel/xls') }}">Comprobación y Estados</a> </div>
                                     <div class="col-md-3">
                                        <a class="btn btn-success" href="{{ route('captacion.limpiarxls',Auth::user()->id) }}">Limpiar Memoria</a> </div>
                                        <a class="btn btn-danger" href="{{ route('captacion.procesarxls',Auth::user()->id) }}">Procesar registros</a> </div>
                                         <div class="col-md-3">
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-sm-12">Subir archivo de captaciones con el formato indicado</label>
                                    <div class="col-sm-12">
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div> <span class="input-group-addon btn btn-default btn-file"> <span class="fileinput-new">Seleccionar archivo</span> <span class="fileinput-exists">Cambiar</span>
                                            <input type="file" name="import_file"> </span> <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a> </div>
                                    </div>
                                </div>
                                    <button type="submit" class="btn btn-info waves-effect waves-light m-t-10">Subir archivo</button>
                            </form>
                        </div>
                    </div>
                </div>.</div>
                                    <div class="wizard-pane" role="tabpanel">
        <form action="{{ route('primeraGestion.storeCaptacion') }}" method="post">
            {!! csrf_field() !!}
<div class="table-responsive" style="padding-bottom: 50px;">
                <table id="listusers" class="display compact" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                            <th>ID</th>
                            <th>Dirección</th>
                            <th>Comuna</th>
                            <th>Propietario</th>
                            <th>Fecha</th>
                            <th>Creador</th>
                            <th>Portal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Dirección</th>
                            <th>Comuna</th>
                            <th>Propietario</th>
                            <th>Fecha</th>
                            <th>Creador</th>
                            <th>Portal</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>

            </div>
            <div class="row"> 
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control" name="correo" required="required">
                            <option value="">Selecione Correo Tipo</option>
                            @foreach($correo as $corr)
                            <option value="{{ $corr->id }}">{{ $corr->nombre }}</option>
                            @endforeach  
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Enviar correos</button>
                    </div>
                </div>                                        
            </div>
        </form>
                                    </div>
                                    <div class="wizard-pane" role="tabpanel">
                                        <div class="table-responsive" style="padding-bottom: 50px;">
                <table id="listusers2" class="display compact" cellspacing="0" width="100%">
                     <thead>
                        <tr>
                            <th>ID</th>
                            <th>Dirección</th>
                            <th>Comuna</th>
                            <th>Propietario</th>
                            <th>Fecha</th>
                            <th>Creador</th>
                            <th>Portal</th>
                            <th>Gestionar</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Dirección</th>
                            <th>Comuna</th>
                            <th>Propietario</th>
                            <th>Fecha</th>
                            <th>Creador</th>
                            <th>Portal</th>
                            <th>Gestionar</th>
                        </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>

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
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.flash.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/JSZip-2.5.0/jszip.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/pdfmake-0.1.32/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/Buttons-1.5.1/js/buttons.print.min.js') }}"></script>
<script>
$('.sorting_desc').hide();

var table = $('#listusers').DataTable({

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

var table2 = $('#listusers2').DataTable({

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

</script>

 <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js') }}"></script>
    <script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('js/jasny-bootstrap.js') }}"></script>



   

  <script type="text/javascript">   



        $('#masivo').wizard({
        
        buttonLabels: {
            next: 'Siguiente',
            back: 'Volver',
            finish: 'Final'
        },


         onNext: function() {

                    $.get("/captaciones/correo/" + {{ Auth::user()->id }} + "", function (response, state) {
                        table.clear().draw();
                       for (i = 0; i < response.length; i++) {
                        var num=response[i].numero==null?'':response[i].numero;
                        var dpto=response[i].departamento==null?'':response[i].departamento;
                        var apepc=response[i].apep_c==null?'':response[i].apep_c;
                        var apemc=response[i].apem_c==null?'':response[i].apem_c;
                        var apepp=response[i].apep_p==null?'':response[i].apep_p;
                        var apemp=response[i].apem_p==null?'':response[i].apem_p;
                        table.rows.add([ 
                            {
                                0 : response[i].id_publicacion,
                                1 : response[i].direccion+", "+ num+", Dtpo: "+dpto,
                                2 : response[i].comuna_nombre,
                                3 : response[i].nom_p+" "+apepp +" "+apemp,
                                4 : response[i].fecha_creacion,
                                5 : response[i].nom_c+" "+apepc +" "+apemc,
                                6 : response[i].portal,
                                7 : "<input value='"+response[i].id_publicacion+"' name='check[]'' type='checkbox'  >"
                            }]).draw();;
                        } 
                      
                    });
                          $.get("/captaciones/gestion/" + {{ Auth::user()->id }} + "", function (response, state) {
                            table2.clear().draw();
                       for (i = 0; i < response.length; i++) {
                        var num=response[i].numero==null?'':response[i].numero;
                        var dpto=response[i].departamento==null?'':response[i].departamento;
                        var apepc=response[i].apep_c==null?'':response[i].apep_c;
                        var apemc=response[i].apem_c==null?'':response[i].apem_c;
                        var apepp=response[i].apep_p==null?'':response[i].apep_p;
                        var apemp=response[i].apem_p==null?'':response[i].apem_p;
                        table2.rows.add([ 
                            {
                                0 : response[i].id_publicacion,
                                1 : response[i].direccion+", "+ num+", Dtpo: "+dpto,
                                2 : response[i].comuna_nombre,
                                3 : response[i].nom_p+" "+apepp +" "+apemp,
                                4 : response[i].fecha_creacion,
                                5 : response[i].nom_c+" "+apepc +" "+apemc,
                                6 : response[i].portal,
                                7 : "<a href='/importar/gestion/"+response[i].id_publicacion+"'><span class='btn btn-warning btn-circle btn-lg'><i class='ti-pencil-alt'></i></span></a> "
                            }]).draw();;
                        } 
                      
                    });
            },

            onFinish: function() {
                swal("Para gestiones individuales y generales, ir al menu Captación principal");
            }
        });

var ok='{{ isset($est)?$est:'' }}';
if(ok=='1' || ok=='2'){
    if(ok=='1') $('#masivo').wizard('goTo', 1);
    if(ok=='2'){

       $('#masivo').wizard('goTo', 2);


    } 
                    
                    $.get("/captaciones/correo/" + {{ Auth::user()->id }} + "", function (response, state) {
                       for (i = 0; i < response.length; i++) {
                        var num=response[i].numero==null?'':response[i].numero;
                        var dpto=response[i].departamento==null?'':response[i].departamento;
                        table.rows.add([ 
                            {
                                0 : response[i].id_publicacion,
                                1 : response[i].direccion+", "+ num+", Dtpo: "+dpto,
                                2 : response[i].comuna_nombre,
                                3 : response[i].nom_p+" "+response[i].apep_p +" "+response[i].apem_p,
                                4 : response[i].fecha_creacion,
                                5 : response[i].nom_c+" "+response[i].apep_c +" "+response[i].apem_c,
                                6 : response[i].portal,
                                7 : "<input value='"+response[i].id_publicacion+"' name='check[]'' type='checkbox'  >"
                            }]).draw();;
                        } 
                      
                    });

                    $.get("/captaciones/gestion/" + {{ Auth::user()->id }} + "", function (response, state) {
                            table2.clear().draw();
                       for (i = 0; i < response.length; i++) {
                        var num=response[i].numero==null?'':response[i].numero;
                        var dpto=response[i].departamento==null?'':response[i].departamento;

                        table2.rows.add([ 
                            {
                                0 : response[i].id_publicacion,
                                1 : response[i].direccion+", "+ num+", Dtpo: "+dpto,
                                2 : response[i].comuna_nombre,
                                3 : response[i].nom_p+" "+response[i].apep_p +" "+response[i].apem_p,
                                4 : response[i].fecha_creacion,
                                5 : response[i].nom_c+" "+response[i].apep_c +" "+response[i].apem_c,
                                6 : response[i].portal,
                                7 : "<a href='/importar/gestion/"+response[i].id_publicacion+"'><span class='btn btn-warning btn-circle btn-lg'><i class='ti-pencil-alt'></i></span></a> "
                            }]).draw();;
                        } 
                      
                    });
 }
</script>
@endsection