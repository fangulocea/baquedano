@extends('admin.layout')

@section('contenido')

<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nueva Persona</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('persona.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-body">
                            <h3 class="box-title">Información de Persona</h3>
                            <hr>

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Rut</label>
                                        <input type="text" name="rut" class="form-control" placeholder="" oninput='checkRut(this)' > 
                                    </div>
                                </div>
                                
                                <div class="col-md-10">
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" required="required" > 
                                     </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" name="apellido_paterno" class="form-control" placeholder=""  > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" name="apellido_materno" class="form-control" placeholder=""  >
                                        </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Profesión / Ocupación</label>
                                        <div id="profesion">
                                                    <input name='profesion' id='profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" > 
                                            </div>
                                    </div>
                                </div>
                                  <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Estado civíl</label>
                                           <select class="form-control" name="estado_civil"  >
                                            <option value="">Selecione Estado Civil</option>
                                            <option value="Soltero/a">Soltero/a</option>
                                            <option value="Casado/a">Casado/a</option>
                                            <option value="Viudo/a">Viudo/a</option>
                                            <option value="Divorciado/a">Divorciado/a</option>
                                            <option value="Separado/a">Separado/a</option>
                                            <option value="Conviviente">Conviviente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <div id="direcciones">
                                                    <input name='direccion' id='direccion' class="typeahead form-control" type="text" placeholder="Dirección" > 
                                            </div>
                                    </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Número</label>
                                            <input name='numero' id='numero' class="form-control" type="text" placeholder="Dirección" > 
                                    </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                            <input name='departamento' id='departamento' class=" form-control" type="text" placeholder="Dirección" > 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
   
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input name='telefono' type="numero" class="form-control"> </div>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name='email' type="text" class="form-control"> </div>
                                </div>

                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, null,array('class'=>'form-control','style'=>'','required'=>'required','id'=>'regiones',''=>'Selecciona región')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',[''=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',[''=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas')) }}
                                        </div>
                                </div>
                            </div>
                            <!--/row-->

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        <select class="form-control" name="banco"  >
                                            <option value="">Selecione Banco</option>
                                            <option value=" Banco Bice  ">  Banco Bice  </option>
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

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo de Cuenta</label>
                                        <select class="form-control" name="tipo_cuenta"  >
                                            <option value="">Selecione Tipo de Cuenta</option>
                                            <option value="Ahorro">Ahorro</option>
                                            <option value="Corriente">Corriente</option>
                                            <option value="Rut">Rut</option>
                                            <option value="Vista">Vista</option>
                                        </select>
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero de cuenta</label>
                                        <input name='cuenta' id='cuenta' class="form-control" type="number" placeholder="Número de cuenta" >
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rut Titular</label>
                                        <input type="text" name="rut_titular" class="form-control" placeholder="" oninput='checkRut(this)' >
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Titular</label>
                                        <input name='titular' id='titular' class=" form-control" type="text" placeholder="Nombre Titular" > 
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
                                        <select class="form-control" name="tipo_cargo" required="required" onChange="mostrar(this.value);" >
                                            <option value="">Selecione Opción</option>
                                            <option value="Propietario">Propietario</option>
                                            <option value="Arrendatario">Arrendatario</option>
                                            <option value="Empleado">Empleado</option>
                                            <option value="Corredor - Externo">Corredor - Externo</option>
                                            <option value="Aval">Aval</option>
                                        </select>
                                    </div>
                                </div>                                                                       


                                <div class="col-md-3">
                                  <div id="Empleado" style="display: none;">
                                        <div class="form-group">
                                            <label>Cargo</label>
                                            {{ Form::select('cargo_id',$cargos, null,array('class'=>'form-control','style'=>'','id'=>'cargo_id',''=>'Selecciona Cargo')) }}
                                        </div>
                                      </div>
                                </div> 

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="id_estado" required="required">
                                            <option value="">Seleccione Estado</option>
                                            <option value="1">Vigente</option>
                                            <option value="0">No Vigente</option>
                                        </select>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>


<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>

<script>

var direcciones = new Bloodhound({
        datumTokenizer: function(datum) {
            return Bloodhound.tokenizers.whitespace(datum.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: { 
            url: "/",
            transform: function(response) {
                    return $.map(response, function(dir) {
                        return { value: 'Id: '+dir.id+ ', Dir: '+ dir.direccion + ', Comuna: '+dir.comuna_nombre };
                    });
                }
        },
        remote: {
            wildcard: '%QUERY',
            url: "/persona/%QUERY",
                transform: function(response) {
                    return $.map(response, function(dir) {
                        return { value: dir.direccion + '  ,  '+dir.comuna_nombre,
                                option: dir.id  };
                    });
                }
        }
    });

    $('#direccion').typeahead({
        hint: false,
        highlight: true,
        minLength: 1,
        limit: 10
    },
    {
        name: 'direcciones',
        display: 'value',
        source: direcciones,
        
       
        templates: {
                header: '<h4 class="dropdown">Direcciones</h4>'
        } 
    });

jQuery('#direccion').on('typeahead:selected', function (e, datum) {
    window.location.href = '/persona/'+datum.option+'/edit'; 
});

$("#regiones").change(function (event) {
    $("#provincias").empty();
    $("#comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#provincias").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#provincias").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
})

$("#provincias").change(function (event) {
    $("#comunas").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#comunas").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#comunas").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
})



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