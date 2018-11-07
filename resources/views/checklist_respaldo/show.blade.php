@extends('admin.layout')
@section('contenido')

<div class="row">
	<div class="col-md-12">
		@if(isset($inmueble->direccion))
		<center><h3 class="box-title m-b-0">{{ $inmueble->direccion or null }} # {{ $inmueble->numero or null }} Dpto {{ $inmueble->departamento or null }}, {{ $inmueble->comuna or null }}</h3></center>
		@endif
		<br><br>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-info">
			<div class="panel-heading"> CheckList Propiedades</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-3">
		<div class="white-box">
			<h3 class="box-title">Detalle CheckList</h3>
			<!-- START carousel-->
			<div id="carousel-example-captions" data-ride="carousel" class="carousel slide">
				<ol class="carousel-indicators">
					@php 
					    $contador = 0;
					@endphp
					@foreach($foto as $f)
						@if($contador == 0)
							<li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
						@else
							<li data-target="#carousel-example-captions" data-slide-to="{{ $contador }}"></li>
						@endif

						@php 
					    $contador ++;
						@endphp
					@endforeach
				</ol>
				<div role="listbox" class="carousel-inner">
					@php 
					    $contador = 0;
					@endphp
					@foreach($foto as $f)
						@if($contador == 0)
							<div class="item active"> <img src="{{ URL::asset($f->ruta.'/'.$f->nombre) }}" data-toggle="modal" data-target="#responsive-modal{{ $contador }}" alt="First slide image"/>
								<div class="carousel-caption">
									<h3 class="text-white font-600"><strong>{{ $f->tipo }}, {{ $f->descripcion }}</strong></h3>
								</div>
							</div>
						@else
							<div class="item"> <img src="{{ URL::asset($f->ruta.'/'.$f->nombre) }}" data-toggle="modal" data-target="#responsive-modal{{ $contador }}" alt="First slide image"/>
								<div class="carousel-caption">
									<h3 class="text-white font-600"><strong>{{ $f->tipo }}, {{ $f->descripcion }}</strong></h3>
								</div>
							</div>
						@endif

						@php 
					    $contador ++;
						@endphp

					@endforeach

				</div>
				<a href="#carousel-example-captions" role="button" data-slide="prev" class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>
				<a href="#carousel-example-captions" role="button" data-slide="next" class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>
			</div>
			<!-- END carousel-->

			<!-- /.modal -->

			@php 
			    $contador = 0;
			@endphp
			@foreach($foto as $f)
				<div id="responsive-modal{{ $contador }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
								<h4 class="modal-title">{{ $f->tipo }}, {{ $f->descripcion }}</h4> 
							</div>
							<div class="modal-body">
								<img src="{{ URL::asset($f->ruta.'/'.$f->nombre) }}" width="570" />							
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>					
				@php 
				    $contador ++;
				@endphp
			@endforeach


		</div>
	</div>
</div>
<hr>
<div class="row">
	<div class="col-md-3">
	    <a href="{{ route('checklist.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
	</div>
</div>



@endsection