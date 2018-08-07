@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('plugins/bower_components/lightbox/css/lightbox.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
<link href="{{ URL::asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')}} rel="stylesheet">
      <link href="{{ URL::asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">

                        <div class="panel panel-info">
                            <div class="panel-heading"> Ingreso de Gastos Básicos, Comunes y Reparaciones</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('finalContrato.savecuadratura',[ $id_contrato, $id_publicacion ]) }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="id_creador" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="id_contrato" value="{{ $id_contrato }}">
                                        <input type="hidden" name="id_publicacion" value="{{ $id_publicacion }}">
                                        <input type="hidden" name="id_estado" value="1">

                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Descripción</label>
                                                        <input name='descripcion' type="text" class="form-control" required="required">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="input-file-now-custom-1">Valor</label>
                                                        <input name='valor' type="number" class="form-control" required="required">
                                                    </div>
                                                </div>
                                   
                                                <div class="col-md-3">
                                                    <label>&nbsp;</label>
                                                    <div class="input-group">
                                                        <button type="submit" class="btn btn-success waves-effect waves-light">Ingresar Gastos</button>
                                                    </div>
                                                </div>
                    
                                        </div> 
                                </div>
                                </form>

                                <hr>

                                <div class="row">
                                <div class="col-md-7">

                                <table id="listusers1_c" class="display compact" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Descripción</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cuadraturas as $p)
                                        <tr>
                                            <td>{{ $p->id }}</td>
                                            <td>{{ $p->descripcion }}</td>
                                            <td>$ {{ $p->valor }}</td>
                                            <td>{{ $p->id_estado }}</td>
                                            <td><a href="{{ route('finalContrato.eliminarCuadratura',[$p->id, $id_contrato, $id_publicacion]) }}"><span class="ti-trash"></span></span></a></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                                                </div>
                            <hr>

<a href="{{ route('finalContrato.finaliza',[ $id_contrato, $id_publicacion ]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
<hr>
                            </div>
                        </div>      



<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    jQuery('#datepicker-fecha_contacto1_c').datepicker({
    format: 'dd-mm-yyyy',
    todayHighlight: true,
    autoclose: true, 
    language: "es",
    locale: "es",
});

</script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>



@endsection                        