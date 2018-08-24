@extends('admin.layout')

@section('contenido')

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Editar nueva Persona</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('persona.update',$_persona->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de Persona</h3>
                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Rut / Pasaporte</label>
                                        <input type="text" name="rut" class="form-control" placeholder=""  value="{{ $_persona->rut }}" > 
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
                                        <input type="text" name="apellido_paterno" class="form-control" placeholder=""  value="{{ $_persona->apellido_paterno }}"  > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" name="apellido_materno" class="form-control" placeholder="" value="{{ $_persona->apellido_materno }}"  >
                                        </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Profesión / Ocupación</label>
                                        <div id="profesion">
                                                    <input name='profesion' id='profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $_persona->profesion }}"> 
                                            </div>
                                    </div>
                                </div>
                                  <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Estado civil</label>
                                            {{ Form::select('estado_civil',['Soltero/a'=>'Soltero/a','Casado/a'=>'Casado/a','Viudo/a'=>'Viudo/a','Divorciado/a'=>'Divorciado/a','Separado/a'=>'Separado/a','Conviviente'=>'Conviviente'], $_persona->estado_civil ,array('class'=>'form-control','style'=>'','id'=>'estado_civil')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input name='direccion' type="text" class="form-control" value="{{ $_persona->direccion }}" > </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Número</label>
                                            <input name='numero' id='numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $_persona->numero }}" > 
                                    </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                            <input name='departamento' id='departamento' class="typeahead form-control" type="text" value="{{ $_persona->departamento }}" placeholder="Dirección" > 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input name='telefono' type="numero" class="form-control" value="{{ $_persona->telefono }}" > </div>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name='email' type="text" class="form-control"  value="{{ $_persona->email }}" > </div>
                                </div>

                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $_persona->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Seleccione región')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',[], null, array('class'=>'form-control','style'=>'','id'=>'provincias')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',[], null, array('class'=>'form-control','style'=>'','id'=>'comunas')) }}
                                        </div>
                                </div>
                            </div>
                            <!--/row-->


                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        {{ Form::select('banco',['Banco Bice'=>'Banco Bice','Banco BTG Pactual Chile'=>'Banco BTG Pactual Chile','Banco Consorcio'=>'Banco Consorcio','Banco de Chile, Edwards '=>'Banco de Chile, Edwards','Banco de Crédito e Inversiones'=>'Banco de Crédito e Inversiones','Banco de la Nacion Argentina'=>'Banco de la Nacion Argentina','Banco Falabella'=>'Banco Falabella','Banco Internacional'=>'Banco Internacional','Banco Itaú Chile'=>'Banco Itaú Chile','Banco Paris'=>'Banco Paris','Banco Penta'=>'Banco Penta','Banco RIpley'=>'Banco RIpley','Banco Santander'=>'Banco Santander','Banco Security'=>'Banco Security','BBVA'=>'BBVA','Deutsche Bank'=>'Deutsche Bank','HSBC Bank (Chile)'=>'HSBC Bank (Chile)','JP Morgan Chase Bank'=>'JP Morgan Chase Bank','Rabobank Chile'=>'Rabobank Chile','Scotiabank Chile'=>'Scotiabank Chile','The Bank of Tokyo'=>'The Bank of Tokyo'], $_persona->banco ,array('class'=>'form-control','style'=>'','id'=>'banco')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo de Cuenta</label>
                                        {{ Form::select('tipo_cuenta',['Ahorro'=>'Ahorro','Corriente'=>'Corriente','Rut'=>'Rut','Vista'=>'Vista'], $_persona->tipo_cuenta ,array('class'=>'form-control','style'=>'','id'=>'tipo_cuenta')) }}
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero de cuenta</label>
                                        <input name='cuenta' id='cuenta' value="{{ $_persona->cuenta }}" class="form-control" type="number" placeholder="Número de cuenta" >
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rut / Pasaporte Titular</label>
                                        <input type="text" name="rut_titular" value="{{ $_persona->rut_titular }}" class="form-control" placeholder="" >
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Titular</label>
                                        <input name='titular' id='titular' value="{{ $_persona->titular }}" class=" form-control" type="text" placeholder="Nombre Titular" > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    
                                </div>
                            </div>
                            <!--/row-->





                            <div class="row">
                                <!--/span-->
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo Persona</label>
                                       
                                         {{ Form::select('tipo_cargo',['Propietario'=>'Propietario','Arrendatario'=>'Arrendatario','Empleado'=>'Empleado','Corredor - Externo'=>'Corredor - Externo','Aval'=>'Aval'], $_persona->tipo_cargo ,array('class'=>'form-control','style'=>'','id'=>'tipo_cargo','required'=>'required','onChange'=>'mostrar(this.value)')) }}
                                    </div>
                                </div>                                                                       
                                <div class="col-md-3">
                                    <div id="SelectEmpleado"  >
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            {{ Form::select('cargo_id',$cargos, $_persona->cargo_id,array('class'=>'form-control','style'=>''
                                            ,'id'=>'cargo_id','placeholder'=>'Selecciona Cargo')) }}
                                        </div>
                                    </div>
                                </div> 

                                 <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            {{ Form::select('id_estado',['1'=>'Vigente','0'=>'No Vigente'], $_persona->id_estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','required'=>'required')) }}
                                        </div>
                                    </div>

                            </div>

                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('persona.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
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
                for(i=0; i<= response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $_persona->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#provincias").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $_persona->id_provincia }}+"",function(response,state){
                for(i=0; i<= response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $_persona->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#comunas").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });


           
            if(ocu.trim()=='Empleado')
                {  
                    $("#SelectEmpleado").show();
                    $('#cargo_id').attr('disabled', false);   
                    $('#cargo_id').attr('required', true);   
                }
            else
                { 
                    $('#cargo_id').attr('disabled', true);  
                    $("#SelectEmpleado").hide(); 
                    $('#cargo_id').attr('required', true);  
            }

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



function mostrar(id) {
    if (id == "Empleado") {
        $("#SelectEmpleado").show();
        $('#cargo_id').attr('disabled', false);  
    }
    else
    {
        $('#cargo_id').attr('disabled', true);  
        $("#SelectEmpleado").hide();
    }
}





</script>
@endsection