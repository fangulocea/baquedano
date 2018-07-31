@extends('admin.layout')
@section('contenido')

<div class="row">
	<div class="col-md-3">
		<div class="white-box">
			<h3 class="box-title">Dirección Inmueble</h3>
			<!-- START carousel-->
			<div id="carousel-example-captions" data-ride="carousel" class="carousel slide">
				<ol class="carousel-indicators">
					<li data-target="#carousel-example-captions" data-slide-to="0" class="active"></li>
					<li data-target="#carousel-example-captions" data-slide-to="1"></li>
					<li data-target="#carousel-example-captions" data-slide-to="2"></li>
					<li data-target="#carousel-example-captions" data-slide-to="3"></li>
					<li data-target="#carousel-example-captions" data-slide-to="4"></li>
					<li data-target="#carousel-example-captions" data-slide-to="5"></li>
				</ol>
				<div role="listbox" class="carousel-inner">
					<div class="item active"> <img src="{{ URL::asset('uploads/checklist/img1.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="First slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Model Showing off</strong></h3>
						</div>
					</div>
					<div class="item"> <img src="{{ URL::asset('uploads/checklist/img2.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="Second slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Mountaing Climbing</strong></h3>
						</div>
					</div>
					<div class="item"> <img src="{{ URL::asset('uploads/checklist/img3.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="Second slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Fire camp on hill</strong></h3>
						</div>
					</div>
					<div class="item"> <img src="{{ URL::asset('uploads/checklist/img4.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="Second slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Fire camp on hill</strong></h3>
						</div>
					</div>
					<div class="item"> <img src="{{ URL::asset('uploads/checklist/img5.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="Second slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Fire camp on hill</strong></h3>
						</div>
					</div>
					<div class="item"> <img src="{{ URL::asset('uploads/checklist/img6.jpg') }}" data-toggle="modal" data-target="#responsive-modal" alt="Second slide image"/>
						<div class="carousel-caption">
							<h3 class="text-white font-600"><strong>Fire camp on hill</strong></h3>
						</div>
					</div>
				</div>
				<a href="#carousel-example-captions" role="button" data-slide="prev" class="left carousel-control"> <span aria-hidden="true" class="fa fa-angle-left"></span> <span class="sr-only">Previous</span> </a>
				<a href="#carousel-example-captions" role="button" data-slide="next" class="right carousel-control"> <span aria-hidden="true" class="fa fa-angle-right"></span> <span class="sr-only">Next</span> </a>
			</div>
			<!-- END carousel-->

			<!-- /.modal -->
			<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Modal Content is Responsive</h4> 
						</div>
						<div class="modal-body">
							<img src="{{ URL::asset('uploads/checklist/img6.jpg') }}" width="570" />							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
</div>
@endsection