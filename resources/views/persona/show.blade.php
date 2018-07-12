@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Muestra Persona</div>
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
                                        <label class="control-label">Rut</label>
                                        <input disabled="disabled" type="text" name="rut" class="form-control" placeholder="" required="required" value="{{ $_persona->rut }}" > 
                                    </div>
                                </div>
                                
                                <div class="col-md-10">
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input disabled="disabled" type="text" name="nombre" class="form-control" placeholder="" required="required" value="{{ $_persona->nombre }}" > 
                                     </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input disabled="disabled" type="text" name="apellido_paterno" class="form-control" placeholder="" required="required" value="{{ $_persona->apellido_paterno }}"  > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input disabled="disabled" type="text" name="apellido_materno" class="form-control" placeholder="" required="required" value="{{ $_persona->apellido_materno }}"  >
                                        </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input disabled="disabled" name='direccion' type="text" class="form-control" required="required" value="{{ $_persona->direccion }}" > </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input disabled="disabled" name='telefono' type="numero" class="form-control" required="required" value="{{ $_persona->telefono }}" > </div>
                                </div>
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input disabled="disabled" name='email' type="text" class="form-control" required="required" value="{{ $_persona->email }}" > </div>
                                </div>

                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $_persona->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Seleccione región','required'=>'required','disabled'=>'disabled')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Seleccione provincia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias','required'=>'required','disabled'=>'disabled')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',['placeholder'=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas','required'=>'required','disabled'=>'disabled')) }}
                                        </div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        {{ Form::select('banco',['Banco Bice'=>'Banco Bice','Banco BTG Pactual Chile'=>'Banco BTG Pactual Chile','Banco Consorcio'=>'Banco Consorcio','Banco de Chile, Edwards '=>'Banco de Chile, Edwards','Banco de Crédito e Inversiones'=>'Banco de Crédito e Inversiones','Banco de la Nacion Argentina'=>'Banco de la Nacion Argentina','Banco Falabella'=>'Banco Falabella','Banco Internacional'=>'Banco Internacional','Banco Itaú Chile'=>'Banco Itaú Chile','Banco Paris'=>'Banco Paris','Banco Penta'=>'Banco Penta','Banco RIpley'=>'Banco RIpley','Banco Santander'=>'Banco Santander','Banco Security'=>'Banco Security','BBVA'=>'BBVA','Deutsche Bank'=>'Deutsche Bank','HSBC Bank (Chile)'=>'HSBC Bank (Chile)','JP Morgan Chase Bank'=>'JP Morgan Chase Bank','Rabobank Chile'=>'Rabobank Chile','Scotiabank Chile'=>'Scotiabank Chile','The Bank of Tokyo'=>'The Bank of Tokyo'], $_persona->banco ,array('class'=>'form-control','style'=>'','id'=>'banco','disabled'=>'disabled')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo de Cuenta</label>
                                        {{ Form::select('tipo_cuenta',['Ahorro'=>'Ahorro','Corriente'=>'Corriente','Rut'=>'Rut','Vista'=>'Vista'], $_persona->tipo_cuenta ,array('class'=>'form-control','style'=>'','id'=>'tipo_cuenta','disabled'=>'disabled' )) }}
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero de cuenta</label>
                                        <input name='cuenta' disabled="disabled" id='cuenta' value="{{ $_persona->cuenta }}" class="form-control" type="number" placeholder="Número de cuenta" >
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rut Titular</label>
                                        <input type="text" disabled="disabled" name="rut_titular" value="{{ $_persona->rut_titular }}" class="form-control" placeholder="" oninput='checkRut(this)' >
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Titular</label>
                                        <input name='titular' disabled="disabled" id='titular' value="{{ $_persona->titular }}" class=" form-control" type="text" placeholder="Nombre Titular" > 
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
                                        <select disabled="disabled" class="form-control" name="tipo_cargo" required="required" onChange="mostrar(this.value);" >
                                            <option value="{{ $_persona->tipo_cargo }}">{{ $_persona->tipo_cargo }}</option>
                                            <option value="Arrendador">Arrendador</option>
                                            <option value="Arrendatario">Arrendatario</option>
                                            <option value="Empleado">Empleado</option>
                                        </select>
                                    </div>
                                </div>                                                                       


                                <div class="col-md-3">
                                  <div id="Empleado" style="{{ $muestra }}" >
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            {{ Form::select('cargo_id',$cargos, $_persona->cargo_id,array('class'=>'form-control','style'=>''
                                            ,'id'=>'cargo_id','placeholder'=>'Selecciona Cargo','disabled'=>'disabled')) }}
                                        </div>
                                      </div>
                                </div> 

                                <div class="col-md-6">
                                </div> 

                            </div>

                        </div>
                        <div class="form-actions">
                            
                            <a href="{{ route('persona.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
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

           if(ocu.trim()=='Empleado')
                {  
                    $("#Empleado").show();
                    $('#cargo_id').attr('disabled', true);   
                    $('#cargo_id').attr('required', true);   
                }
            else
                { 
                    $('#cargo_id').attr('disabled', true);  
                    $("#Empleado").hide(); 
                    $('#cargo_id').attr('required', true);  
            }
    });




function mostrar(id) {
    if (id == "Empleado") {
        $("#Empleado").show();
    }

    if (id == "Arrendador") {
        $("#Empleado").hide();
    }

    if (id == "Arrendatario") {
        $("#Empleado").hide();
 
    }
}





</script>
@endsection