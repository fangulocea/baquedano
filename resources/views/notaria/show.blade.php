@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Notaría</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="#" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Notaria</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Razón social</label>
                                        <input disabled="disabled" type="text" name="razonsocial" class="form-control" placeholder="" value="{{ $_notaria->razonsocial }}"> <span class="help-block"> Nombre de la notaría </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Calle / Avenida</label>
                                        <input disabled="disabled" name='direccion' type="text" class="form-control" value="{{ $_notaria->direccion }}"> </div>
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $_notaria->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona una región','required'=>'required','disabled'=>'disabled')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Selecciona una región'], null, array('class'=>'form-control','style'=>'','id'=>'provincias','required'=>'required','disabled'=>'disabled')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',['placeholder'=>'Selecciona una provincia'], null, array('class'=>'form-control','style'=>'','id'=>'comunas','required'=>'required','disabled'=>'disabled')) }}
                                        </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Notario</label>
                                        <input disabled="disabled" type="text" name='nombreNotario' class="form-control" required="required" value="{{ $_notaria->nombreNotario }}"> </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Teléfono</label>
                                        <input disabled="disabled" type="text" name="telefono" class="form-control" required="required" value="{{ $_notaria->telefono }}"> </div>
                                </div>                                                                       <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">EMail</label>
                                        <input disabled="disabled" type="email" name="email" class="form-control" required="required" value="{{ $_notaria->email }}"> </div>
                                </div>
                                <!--/span-->
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        {{ Form::select('estado',['0'=>'No Vigente','1'=>'Vigente'], $_notaria->estado ,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona estado','required'=>'required','disabled')) }}
                                    </div>
                                </div>
                            </div>

                        </div>
                         
                        <div class="form-actions">
                             <a href="{{ route('notarias.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
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
            $.get("/provincias/"+{{ $_notaria->id_region }}+"",function(response,state){
                for(i=0; i<response.length;i++){
                    $("#provincias").append("<option value='"+response[i].provincia_id+"'>"+response[i].provincia_nombre+"</option>");
                }
            });
            $.get("/comunas/"+{{ $_notaria->id_provincia }}+"",function(response,state){
                for(i=0; i<response.length;i++){
                    $("#comunas").append("<option value='"+response[i].comuna_id+"'>"+response[i].comuna_nombre+"</option>");
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
