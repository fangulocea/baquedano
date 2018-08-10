@extends('admin.layout')
@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('plugins/bower_components/lightbox/css/lightbox.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
<link href="{{ URL::asset('plugins/bower_components/timepicker/bootstrap-timepicker.min.css')}} rel="stylesheet">
<link href="{{ URL::asset('plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css')}}" rel="stylesheet">


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Registro de Pago por término de contrato</div>
        </div>
    </div>
</div>  

<div class="row">
    
    <div class="col-md-12">
        <table style="border-collapse:collapse;border-spacing:0" width="100%">
            <tr>
                <th style="font-family:Arial, sans-serif;font-size:15px;font-weight:normal;padding:15px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:inherit;background-color:#67fd9a;vertical-align:top"><strong>INMUEBLE :  {{ $propietario_propiedad->direccion or null }} N°{{ $propietario_propiedad->numero or null }}, {{ $propietario_propiedad->comuna or null }}</strong> 
                </th>
            </tr>
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:15px;padding:15px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:inherit;background-color:#96fffb;vertical-align:top"><strong>PROPIETARIO :  {{ $propietario_propiedad->nombre or null }} {{ $propietario_propiedad->apellido_paterno or null }} {{ $propietario_propiedad->apellido_materno  or null }}</strong>
                    
                </td>
            </tr>
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:15px;padding:15px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;background-color:#fffc9e;vertical-align:top"><strong>ESTADO : </strong>                    
                </td>
            </tr>
            <tr>
                <td style="font-family:Arial, sans-serif;font-size:15px;padding:15px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-color:black;background-color:#ffccc9;vertical-align:top"><strong>TOTAL : $ {{ $totalFinal or null }}</strong>
                    
                </td>
            </tr>
        </table>        
    </div>

</div>  
<hr>

{{ $id_contrato }}, {{ $id_publicacion }}

<form action="{{ route('finalContrato.savepagofin', [ $id_contrato, $id_publicacion ] ) }}" method="post" enctype='multipart/form-data'>
{!! csrf_field() !!}
<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="row"> 
    <div class="col-md-3">
        <div class="form-group">
            <label>Monto a Pagar</label>
            <div class="input-group"> 
                <span class="input-group-addon">$</span>
                <input name='valor' type="number" value="{{ $saldo }}" class="form-control" required="required">
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Fecha de Pago</label>
            <div class="input-group"> 
                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ $pagotc or null }}" required="required">
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
    <div class="col-md-2">
        <div class="form-group">
            <label></label>
            <div class="input-group"> 
                <a href="{{ route('finalContrato.comprobantefin',[ $id_contrato,$id_publicacion ]) }}"> <button type="button" class="btn btn-primary btn-lg btn-block btn-info">Generar Liquidación de Pago</button></a>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>
 <div class="row">
    <div class="col-md-6"> 
        <div class="form-group">
            <label for="input-file-now-custom-1">Comprobante de Pago</label>
            <input type="file" id="foto" name="foto"  class="dropify" required="required" />      
        </div>
    </div>
    <div class="col-md-6"> 
        <table border="1" width="100%">
          <tr>
            <th width="170px" style="text-align: center;">Fecha Pago</th>
            <th width="170px" style="text-align: center;">Valor Pagado</th>
            <th width="170px" style="text-align: center;">Saldo</th>
            <th width="170px" style="text-align: center;">Comprobante</th>
          </tr>
        @php
            $contador = 1;
        @endphp          
          @foreach($pagos as $p)
              <tr>
                <td style="text-align: center;">{{ $p->fecha }}</td>
                <td style="text-align: center;">{{ $p->monto }}</td>
                <td style="text-align: center;">
                    @php
                        if($contador == 1)
                        {
                            $anterior = $totalFinal - $p->monto;
                            echo $anterior;
                            $contador = 2;
                        }
                        elseif($contador == 2)
                        {
                            $anterior = $anterior - $p->monto;
                            echo $anterior;
                            $contador = 3;   
                        }
                        else
                        {
                            $anterior = $anterior - $p->monto;
                            echo $anterior;
                            $contador = 2;      
                        }
                    @endphp
                </td>
                <td style="text-align: center;"><a href="{{ URL::asset($p->ruta.'/'.$p->nombre) }}" target="_blank">BAJAR ARCHIVO</a></td> 
              </tr>
          @endforeach
        </table>
    </div>
</div>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-2"> 
        <div class="form-actions">
            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Pago</button>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<a href="{{ route('finalContrato.finaliza',[ $id_contrato, $id_publicacion ]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a> 
</form>





<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('js/custom.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/lightbox/js/lightbox.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
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


@endsection

