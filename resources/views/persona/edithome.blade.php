@extends('admin.layout')

@section('contenido')

<div  class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> {{ $_persona->nombre }} {{ $_persona->apellido_paterno }}</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('persona.updatehome',$_persona->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Rut</label>
                                        <input type="text" name="rut" class="form-control" placeholder="" required="required" disabled='disabled' value="{{ $_persona->rut }}" > 
                                    </div>
                                </div>
                                
                                <div class="col-md-10">
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $_persona->nombre }}" > 
                                     </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" name="apellido_paterno" class="form-control" placeholder="" required="required" value="{{ $_persona->apellido_paterno }}"  > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" name="apellido_materno" class="form-control" placeholder="" required="required" value="{{ $_persona->apellido_materno }}"  >
                                        </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input name='direccion' type="text" class="form-control" required="required" value="{{ $_persona->direccion }}" > </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input name='telefono' type="numero" class="form-control" required="required" value="{{ $_persona->telefono }}" > </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name='email' type="text" class="form-control" required="required" value="{{ $_persona->email }}" > </div>
                                </div>

                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $_persona->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Seleccione región','required'=>'required')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Seleccione provincia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias','required'=>'required')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',['placeholder'=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas','required'=>'required')) }}
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
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

            var ocu="{{ $_persona->tipo_cargo }} ";

            $("#provincias").empty();
            $("#comunas").empty();
            $.get("/provincias/"+{{ $_persona->id_region }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $_persona->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#provincias").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $_persona->id_provincia }}+"",function(response,state){
                for(i=0; i< response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $_persona->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#comunas").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });


    });

$("#regiones").change(function (event) {
    $("#provincias").empty();
    $("#comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#provincias").append("<option value=''>Seleccione provincia</option>");
        for (i=0; i<= response.length; i++) {
            $("#provincias").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
})

$("#provincias").change(function (event) {
    $("#comunas").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#comunas").append("<option value=''>Seleccione comuna</option>");
        for (i=0; i<= response.length; i++) {
            $("#comunas").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
})


</script>
@endsection