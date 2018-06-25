@extends('admin.layout')

@section('contenido')

<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">

<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<div class="row">
    <div class="col-md-12"> 
        @if(isset($borrador->direccion))
         <center><h3 class="box-title m-b-0">{{ $borrador->direccion or null }}</h3></center>
         @endif
          @if( isset($borrador->propietario) )
        <center><h3 class="box-title m-b-0">{{ $borrador->propietario or null }} </h3></center>
        <br><br>
        @endif
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_5_c"><a id="5" href="#section-iconbox-5_c" class="sticon ti-agenda"><span>Gestión Contrato Final</span></a></li>
                        <li id="li_6_c"><a id="6" href="#section-iconbox-6_c" class="sticon ti-agenda"><span>Documentos de Respaldos</span></a></li>
                    </ul>
                </nav>
                 <div class="content-wrap">
                    <section id="section-iconbox-5_c">

			                <table id="listusers1_c" class="display nowrap" cellspacing="0" width="100%">
			                <thead>
			                    <tr>
			                        <th>ID</th>
			                        <th>Estado</th>
			                        <th>Ver Pdf</th>
                                    <th>Notaria</th>
                                    <th>Fecha Firma</th>
                                    <th>Guardar</th>
                                    <th>Eliminar</th>
			                    </tr>
			                </thead>
			                <tbody>
                            @foreach($finalIndex as $p)
                                    <tr>
                        <form id="form1_a" action="{{ route('finalContrato.asignarNotaria',$p->id) }}" method="post">                 
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id_modificador" value="{{ Auth::user()->id }}"">
                            <input type="hidden" name="id_publicacion" value="{{ $p->id_publicacion }}"">
                            <input type="hidden" name="id_borrador" value="{{ $p->id_borrador }}"">
                            <input type="hidden" name="id_pdf" value="{{ $p->id_pdf }}"">
                                <td>{{ $p->id }}</td>
                                <td>{{ trans_choice('mensajes.contratofinal', $p->id_estado) }}</td>
                                   <td>
                                        <a href="{{asset('uploads/pdf_final/'.$p->nombre)}}" target="_blank"><span class="btn btn-success btn-circle btn-lg"><i class="ti ti-file"></i></span></a>
                                    </td>  
                                <td>
                                        <select class="form-control" name="id_notaria" required="required" >
                                            <option value="">Selecione Notaria</option>
                                            @foreach($notaria as $n)
                                                @if($n->id==$p->id_notaria)
                                                    <option value="{{ $n->id }}" selected>{{ $n->nombre }} </option>
                                                @else
                                                    <option value="{{ $n->id }}">{{ $n->nombre }} </option>
                                                @endif
                                            @endforeach   
                                        </select> 
                                </td>
                                <td>
                                    <input type="date" name="fecha_firma" id="fecha_firma" value='{{ $p->fecha }}' required="required">
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                </td>
                                <td>
                                    <a href="{{ route('finalContrato.destroy',[$p->id,$p->id_pdf]) }}"> <button type="button" class="btn btn-danger"> <i class="fa fa-check"></i> Eliminar</button></a>
                                </td>
                            </form>
                            </tr>
                            @endforeach
                </tbody>
            </table>
                    </section>
<section id="section-iconbox-6_c">
     <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box"> 
                           <form action="{{ route('finalContrato.savedocs',$borrador->id_publicacion) }}" method="post" enctype='multipart/form-data'>
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <h3 class="box-title">Subir Archivo</h3>
                                <label for="input-file-now-custom-1">ID Contrato</label>
                                        <select class="form-control" name="id_final" required="required" >
                                            <option value="">Selecione ID Contrato</option>
                                            @foreach($finalIndex as $n)
                                                    <option value="{{ $n->id }}">{{ $n->id }} </option>
                                            @endforeach  
                                        </select>
                                <label for="input-file-now-custom-1">Tipo Documento</label>
                                        <select class="form-control" name="tipo" required="required" >
                                                    <option value="">Selecione Tipo de Documento</option>
                                                    <option value="Contrato Digitalizado">Contrato Digitalizado </option>
                                                    <option value="Gastos Notario">Gastos Notario </option>
                                                    <option value="Documentos Garantías">Documentos Garantías </option>
                                                    <option value="Comprobantes de Pagos">Comprobantes de Pagos </option>
                                                    <option value="Otros Documentos">Otros Documentos </option>
                                        </select>
                                <label for="input-file-now-custom-1">Archivo del contrato</label>
                                <input type="file" id="foto" name="foto"  class="dropify"  /> 
                                <input type="hidden" id="id_publicacion" name="id_publicacion" value="{{ $borrador->id_publicacion }}"  /> 
                                <input type="hidden" id="id_creador" name="id_creador" value="{{ Auth::user()->id_persona }}"  /> 
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Subir Archivo</button>

                            </form>
                        </div>
                    </div>
                     <div class="col-sm-6">
                        <div class="white-box"> 
                             <table id="ssss"  cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                         
                                                            <th><center>Click Ver Documento</center></th>
                                                            <th>Borrar</th>
                                                        </tr>
                                                    </thead>
                                                   
                                                    <tbody>
                                                        @foreach($documentos as $pi)
                                                        <tr>
                                                            <td  width="10px" height="10px">
                                                               
                                                            <center><a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO<br> {{ $pi->nombre }} </a></center>

                                                           
                                                            @can('revisioncomercial.edit')
                                                            <td width="10px">

                                                                <a href="{{ route('finalContrato.eliminarfoto', $pi->id) }}" 
                                                                   class="btn btn-danger btn-circle btn-lg">
                                                                    <i class="fa fa-check"></i>
                                                                </a>
                                                            </td>
                                                            @endcan
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                        </div>
                    </div>

                </div>
</section>
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>
  <a href="{{ route('borradorContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script>
    
            // Basic
        $('.dropify').dropify();
        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });
        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Esta seguro de eliminar  \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('Archivo Borrado');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
</script>


<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>

<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />


<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>



<script>



$('#listusers1_c').DataTable({
    dom: 'Bfrtip',
    buttons: [ ],
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
@endsection