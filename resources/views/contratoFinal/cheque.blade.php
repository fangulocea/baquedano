@extends('admin.layout')
@section('contenido')
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Actualización Cheques para Contrato Final</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('finalContrato.act_cheque',$id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="idpdf" value="{{ $idpdf }}" class="form-control"  >
                        <div class="form-body">
                            <hr>
							<div class="row">
                                	<div class="col-md-1">
                                    	<label class="control-label">N°</label>
                                	</div>
                                	<div class="col-md-2">
                                    	<label class="control-label">Mes Arriendo</label>
                                	</div>
                                	<div class="col-md-2">
                                    	<label class="control-label">Banco</label>
                                	</div>
                                	<div class="col-md-2">
                                    	<label class="control-label">N° Cheque</label>
                                	</div>
                                	<div class="col-md-2">
                                    	<label class="control-label">Valor</label>
                                	</div>
                            </div>
							@foreach($chPropietario as $p)
								<div class="row">
                                	<div class="col-md-1">
                                    	<div class="form-group">    
                                    	     {{ $p->correlativo }}  
                                             <input type="hidden" name="correlativo[]" value="{{ $p->correlativo }}" class="form-control"  >     	
                                        </div>
                                	</div>
									<div class="col-md-2">
                                    	<div class="form-group">    
                                    	     {{ $p->mes_arriendo }}   	
                                        </div>
                                	</div>
									<div class="col-md-2">
                                    	<div class="form-group">
				                            <select class="form-control" name="banco[]" required="required">
				                                <option value="">Selecione Banco</option>
				                                <option value="Banco Bice">  Banco Bice  </option>
				                                <option value="Banco BTG Pactual Chile">Banco BTG Pactual Chile</option>
				                                <option value="Banco Consorcio">Banco Consorcio</option>
				                                <option value="Banco de Chile, Edwards">Banco de Chile, Edwards</option>
				                                <option value="Banco de Crédito e Inversiones">Banco de Crédito e Inversiones</option>
				                                <option value="Banco de la Nacion Argentina">Banco de la Nacion Argentina</option>
				                                <option value="Banco Falabella">Banco Falabella</option>
				                                <option value="Banco Internacional">Banco Internacional</option>
				                                <option value="Banco Itaú Chile">Banco Itaú Chile</option>
				                                <option value="Banco Paris">Banco Paris</option>
				                                <option value="Banco Penta">Banco Penta</option>
				                                <option value="Banco RIpley">Banco RIpley</option>
				                                <option value="Banco Santander">Banco Santander</option>
				                                <option value="Banco Security">Banco Security</option>
				                                <option value="BBVA">BBVA</option>
				                                <option value="Deutsche Bank">Deutsche Bank</option>
				                                <option value="HSBC Bank (Chile)">HSBC Bank (Chile)</option>
				                                <option value="JP Morgan Chase Bank">JP Morgan Chase Bank</option>
				                                <option value="Rabobank Chile">Rabobank Chile</option>
				                                <option value="Scotiabank Chile">Scotiabank Chile</option>
				                                <option value="The Bank of Tokyo">The Bank of Tokyo</option>
				                            </select>
			                        	</div>
                                	</div>
									<div class="col-md-2">
                                    	<div class="form-group">    
                                    	     <input type="text" name="numero[]" class="form-control" required="required" > 	
                                        </div>
                                	</div>
                                	<div class="col-md-2">
                                    	<div class="form-group">
                                    	     <input type="text" name="valor" value="${{ number_format($p->monto) }}" disabled="disabled" class="form-control"  > 	
                                        </div>
                                	</div>
									<div class="col-md-2">
                                    	<div class="form-group">
                                    	     <input type="text" name="valor" value="{{ $idpago }}/{{ $p->mes_arriendo }}" disabled="disabled" class="form-control"  ><input type="hidden" name="fecha_pago[]" value="{{ $idpago }}/{{ $p->mes_arriendo }}"  class="form-control"  >
                                        </div>
                                	</div>


		
                            	</div>



							@endforeach
                            
                            
          
                            
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('finalContrato.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/tinymce/tinymce.min.js') }}"></script>
<link href = "{{ URL::asset('plugins/bower_components/datatables/jquery.dataTables.min.css')   }}" rel="stylesheet" type="text/css"   />
<link href = "{{ URL::asset('plugins/DataTables/Buttons-1.5.1/css/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"   />
<script  src="{{ URL::asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/DataTables/DataTables-1.10.16/js/jquery.dataTables.min.js') }}"></script>

@endsection