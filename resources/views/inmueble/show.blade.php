@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Información del Inmueble</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('inmueble.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información del inmueble</h3>
                            <hr>
                            <div class="row"> 
                                <div class="col-md-8">
                                    <div class="form-group">
                                   <label>Calle / Avenida</label>
                                        <input disabled="disabled" name='direccion' type="text" class="form-control"
                                        value='{{ $inmueble->direccion }}'> </div>
                                     </div>
                                <!--/span-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                  <label>Nro.</label>
                                        <input disabled="disabled" name='numero' value='{{ $inmueble->numero }}' type="text" class="form-control"> </div>
                                     </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                  <label>Departamento</label>
                                        <input disabled="disabled" name='departamento' value='{{ $inmueble->departamento }}' type="text" class="form-control"> </div>
                                     </div>
                                </div>
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $inmueble->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona una región','required'=>'required', 'disabled'=>'disabled')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Selecciona una región'], null, array('class'=>'form-control','style'=>'','id'=>'provincias','required'=>'required', 'disabled'=>'disabled')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',['placeholder'=>'Selecciona una provincia'], null, array('class'=>'form-control','style'=>'','id'=>'comunas','required'=>'required', 'disabled'=>'disabled' )) }}
                                        </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                   <label>Dormitorio</label>
                                        <input disabled="disabled" name='dormitorio' type="text" class="form-control" value='{{ $inmueble->dormitorio }}'> </div>
                                     </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                  <label>Baños</label>
                                        <input disabled="disabled" name='bano' type="text" class="form-control" value='{{ $inmueble->bano }}'> </div>
                                     </div>
                                <!--/span-->
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Estacionamiento</label>
                                        <input disabled="disabled" name='estacionamiento' type="number" class="form-control" value='{{ $inmueble->estacionamiento }}' required="required">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Bodega</label>
                                        <input disabled="disabled" name='bodega' type="number" class="form-control" value='{{ $inmueble->bodega }}' required="required">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                    <label>Piscina</label>
                                        {{ Form::select('piscina',['SI'=>'SI','NO'=>'NO'], $inmueble->piscina ,array('class'=>'form-control','style'=>'','id'=>'piscina','placeholder'=>'Seleccione piscina','required'=>'required','disabled'=>'disabled')) }}
                                        </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Gasto Común</label>
                                    <div class="input-group"> 
                                            <span class="input-group-addon">$</span>
                                        <input disabled="disabled" name='gastosComunes' type="text" class="form-control" value='{{ $inmueble->gastosComunes }}'>
                                     </div>
                                 </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-gro
                                    <div class="input-group"> 
                                            <span class="input-group-addon">$</span>
                                        <input disabled="disabled" name='precio' type="text" class="form-control"
                                        value='{{ $inmueble->precio }}'>
                                    </div>
                                     </div>
                                </div>
                                                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['1'=>'Vigente','0'=>'No Vigente','2'=>'Reservado'], $inmueble->estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','required'=>'required','disabled'=>'disabled')) }}
                                     </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-actions">

                            <a href="{{ route('inmueble.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

<script>
    $(function() {

            $("#provincias").empty();
            $("#comunas").empty();
            $.get("/provincias/"+{{ $inmueble->id_region}}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $inmueble->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#provincias").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $inmueble->id_provincia }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $inmueble->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#comunas").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });
    });


$("#regiones").change(function(event){
    $("#provincias").empty();
    $("#comunas").empty();
    $.get("/provincias/"+event.target.value+"",function(response,state){
        for(i=0; i<response.length;i++){
            $("#provincias").append("<option value='"+response[i].provincia_id+"'>"+response[i].provincia_nombre+"</option>");
        }
    });
})

$("#provincias").change(function(event){
    $("#comunas").empty();
    $.get("/comunas/"+event.target.value+"",function(response,state){
        for(i=0; i<response.length;i++){
            $("#comunas").append("<option value='"+response[i].comuna_id+"'>"+response[i].comuna_nombre+"</option>");
        }
    });
})
</script>
@endsection