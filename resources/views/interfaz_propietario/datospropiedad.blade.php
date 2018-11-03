
@extends('admin.propietario')


@section('contenido')
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>

<?php $ini=1; ?>
<div class="responsive">

    <div class="row" style="padding-top: 50px">
        <div class="col-sm-12">
            <div class="white-box" >

                @foreach($docs as $inmueble)

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Información del inmueble - Contrato {{ $ini }}</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="form-body">
                                        <div class="row"> 

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label>Dirección</label>
                                                    <div id="direcciones">
                                                        <input name='direccion' id='direccion' class=" form-control" type="text" placeholder="Dirección" value='{{ $inmueble->direccion or ''}}' readonly="readonly"> 
                                                    </div>

                                                </div>
                                            </div>



                                            <!--/span-->
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Nro.</label>
                                                    <input name='numero' value='{{ $inmueble->numero or ''}}' type="text" class="form-control" readonly="readonly"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Departamento</label>
                                                    <input name='departamento' value='{{ $inmueble->departamento or ''}}' type="text" class="form-control" readonly="readonly"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">

                                                    <label>Rol</label>
                                                    <input name='rol' type="text" class="form-control" value='{{ $inmueble->departamento or ''}}' readonly="readonly"> </div>

                                            </div> 
                                        </div>
                                       
                                        <div class="row"> 
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Región</label>
                                                    {{ Form::select('id_region',$regiones, $inmueble->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Seleccione región', 'readonly'=>'readonly')) }}
                                                </div>
                                            </div>

                                            <!--/span-->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Provincia</label>
                                                    {{ Form::select('id_provincia',['placeholder'=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias', 'readonly'=>'readonly')) }} </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Comuna</label>
                                                    {{ Form::select('id_comuna',['placeholder'=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas', 'readonly'=>'readonly')) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Dormitorio</label>
                                                    <input name='dormitorio' type="number" class="form-control" value='{{ $inmueble->dormitorio }}' readonly="readonly"> </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Baños</label>
                                                    <input name='bano' type="number" class="form-control" value='{{ $inmueble->bano }}' readonly="readonly"> </div>
                                            </div>
                                            <!--/span-->



                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Piscina</label>
                                                    {{ Form::select('piscina',['SI'=>'SI','NO'=>'NO'], $inmueble->piscina ,array('class'=>'form-control','style'=>'','id'=>'piscina','placeholder'=>'Seleccione piscina','readonly'=>'readonly')) }}
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    @if(!isset($inmueble->bodega))
                                                    <?php $idpi = null; ?>
                                                    @else
                                                    <?php $idpi = $inmueble->bodega; ?>
                                                    @endif
                                                    <label>Bodega</label>
                                                    {{ Form::select('bodega',['1'=> 'SI', '0'=>'NO'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'bodega','placeholder'=>'Seleccione','readonly'=>'readonly')) }}
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Número de Bodega</label>
                                                    <input name='nro_bodega' type="text" class="form-control" value='{{ $inmueble->nro_bodega or '' }}' readonly="readonly" >
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Estacionamiento</label>
                                                    <input name='estacionamiento' type="number" class="form-control" value='{{ $inmueble->estacionamiento }}' readonly="readonly">
                                                </div>
                                            </div>                                <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nro. Estacionamiento</label>
                                                    <input name='nro_estacionamiento' type="text" class="form-control" value='{{ $inmueble->nro_estacionamiento or '' }}' readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label>Año Antiguedad</label>
                                                    <input name='anio_antiguedad' type="number" class="form-control" value='{{ $inmueble->anio_antiguedad or '' }}' readonly="readonly">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Gasto Común</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">$</span>
                                                        <input name='gastosComunes' type="number" class="form-control" value='{{ $inmueble->gastosComunes }}'  readonly="readonly">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Precio</label>
                                                    <div class="input-group"> 
                                                        <span class="input-group-addon">$</span>
                                                        <input name='precio' type="number" step="any" class="form-control"
                                                               value='{{ $inmueble->precio }}' readonly="readonly" min="1" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Estado</label>
                                                    {{ Form::select('estado',['1'=>'Vigente','0'=>'No Vigente','2'=>'Reservado'], $inmueble->estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','readonly'=>'readonly')) }}
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    @if(!isset($inmueble->condicion))
                                                    <?php $idpi = null; ?>
                                                    @else
                                                    <?php $idpi = $inmueble->condicion; ?>
                                                    @endif
                                                    <label>Condición</label>
                                                    {{ Form::select('condicion',['Nuevo'=> 'Nuevo', 'Usado'=>'Usado'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'condicion','placeholder'=>'Seleccione','readonly'=>'readonly')) }}

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombre Edificio</label>
                                                    <input name='edificio' type="text" class="form-control" value='{{ $inmueble->edificio or '' }}' readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Nombre Administrador</label>
                                                    <input name='nom_administrador' type="text"  class="form-control" value='{{ $inmueble->nom_administrador or '' }}' readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Teléfono Administrador</label>
                                                    <input name='tel_administrador' type="text"  class="form-control" value='{{ $inmueble->tel_administrador or '' }}' readonly="readonly">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Email Administrador</label>
                                                    <input name='email_administrador' type="email"  class="form-control" value='{{ $inmueble->email_administrador or '' }}' readonly="readonly">

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                $(function() {

                $("#provincias").empty();
                $("#comunas").empty();
                $.get("/provincias/" + {{ $inmueble->id_region}} + "", function(response, state){
                for (i = 0; i < response.length; i++){
                sel = '';
                if (response[i].provincia_id == {{ $inmueble->id_provincia }}){
                sel = ' selected="selected"';
                }
                $("#provincias").append("<option value='" + response[i].provincia_id + "' " + sel + ">" + response[i].provincia_nombre + "</option>");
                }
                });
                $.get("/comunas/" + {{ $inmueble->id_provincia }} + "", function(response, state){
                for (i = 0; i < response.length; i++){
                sel = '';
                if (response[i].comuna_id == {{ $inmueble->id_comuna }}){
                sel = ' selected="selected"';
                }
                $("#comunas").append("<option value='" + response[i].comuna_id + "' " + sel + ">" + response[i].comuna_nombre + "</option>");
                }
                });
                });
                </script>


<?php $ini=$ini+1;?>

                @endforeach


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">Información del Propietario</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label">Rut / Pasaporte</label>
                                        <input type="text" name="rut" class="form-control" placeholder=""  value="{{ $_persona->rut }}" readonly="readonly"> 
                                    </div>
                                </div>
                                
                                <div class="col-md-10">
                                </div>
                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                        <input type="text" name="nombre" class="form-control" placeholder="" readonly="readonly"value="{{ $_persona->nombre }}" > 
                                     </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Paterno</label>
                                        <input type="text" name="apellido_paterno" class="form-control" placeholder=""  readonly="readonly" value="{{ $_persona->apellido_paterno }}"  > 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Apellido Materno</label>
                                        <input type="text" name="apellido_materno" class="form-control" placeholder="" value="{{ $_persona->apellido_materno }}"  readonly="readonly">
                                        </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Profesión / Ocupación</label>
                                        <div id="profesion">
                                                    <input name='profesion' id='profesion' class="typeahead form-control" type="text" placeholder="Profesión / Ocupación" value="{{ $_persona->profesion }}" readonly="readonly"> 
                                            </div>
                                    </div>
                                </div>
                                  <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Estado civil</label>
                                            {{ Form::select('estado_civil',['Soltero/a'=>'Soltero/a','Casado/a'=>'Casado/a','Viudo/a'=>'Viudo/a','Divorciado/a'=>'Divorciado/a','Separado/a'=>'Separado/a','Conviviente'=>'Conviviente'], $_persona->estado_civil ,array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'estado_civil')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input name='direccion' type="text" class="form-control" value="{{ $_persona->direccion }}" readonly="readonly" > </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Número</label>
                                            <input name='numero' id='numero' class="typeahead form-control" type="text" placeholder="Dirección" value="{{ $_persona->numero }}" readonly="readonly"> 
                                    </div>
                                </div>
                                  <div class="col-md-3 ">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                            <input name='departamento' id='departamento' class="typeahead form-control" type="text" value="{{ $_persona->departamento }}" placeholder="Dirección" readonly="readonly"> 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 ">
                                    <div class="form-group">
                                        <label>Teléfono</label>
                                        <input name='telefono' type="numero" readonly="readonly" class="form-control" value="{{ $_persona->telefono }}" > </div>
                                </div>
                                <div class="col-md-8 ">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input name='email' type="text" readonly="readonly" class="form-control"  value="{{ $_persona->email }}" > </div>
                                </div>

                            </div>

                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $_persona->id_region,array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'_regiones','placeholder'=>'Seleccione región')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',[], null, array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'_provincias')) }} </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',[], null, array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'_comunas')) }}
                                        </div>
                                </div>
                            </div>
                            <!--/row-->


                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Banco</label>
                                        {{ Form::select('banco',['Banco Bice'=>'Banco Bice','Banco BTG Pactual Chile'=>'Banco BTG Pactual Chile','Banco Consorcio'=>'Banco Consorcio','Banco de Chile, Edwards '=>'Banco de Chile, Edwards','Banco Estado'=>'Banco Estado','Banco de Crédito e Inversiones'=>'Banco de Crédito e Inversiones','Banco de la Nacion Argentina'=>'Banco de la Nacion Argentina','Banco Falabella'=>'Banco Falabella','Banco Internacional'=>'Banco Internacional','Banco Itaú Chile'=>'Banco Itaú Chile','Banco Paris'=>'Banco Paris','Banco Penta'=>'Banco Penta','Banco RIpley'=>'Banco RIpley','Banco Santander'=>'Banco Santander','Banco Security'=>'Banco Security','BBVA'=>'BBVA','Deutsche Bank'=>'Deutsche Bank','HSBC Bank (Chile)'=>'HSBC Bank (Chile)','JP Morgan Chase Bank'=>'JP Morgan Chase Bank','Rabobank Chile'=>'Rabobank Chile','Scotiabank Chile'=>'Scotiabank Chile','The Bank of Tokyo'=>'The Bank of Tokyo'], $_persona->banco ,array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'banco')) }}
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Tipo de Cuenta</label>
                                        {{ Form::select('tipo_cuenta',['Ahorro'=>'Ahorro','Corriente'=>'Corriente','Rut'=>'Rut','Vista'=>'Vista'], $_persona->tipo_cuenta ,array('readonly'=>'readonly','class'=>'form-control','style'=>'','id'=>'tipo_cuenta')) }}
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Numero de cuenta</label>
                                        <input name='cuenta' id='cuenta' value="{{ $_persona->cuenta }}" class="form-control" type="number" placeholder="Número de cuenta" readonly="readonly" >
                                    </div>
                                </div>
                            </div>
                            <!--/row-->
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Rut / Pasaporte Titular</label>
                                        <input type="text" name="rut_titular" value="{{ $_persona->rut_titular }}" class="form-control" placeholder="" readonly="readonly">
                                     </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Nombre Titular</label>
                                        <input name='titular' id='titular' value="{{ $_persona->titular }}" class=" form-control" type="text" placeholder="Nombre Titular" readonly="readonly"> 
                                    </div>
                                </div>
                                <!--/span-->
                                 <div class="col-md-4">
                                    
                                </div>
                            </div>
                            <!--/row-->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {


            $("#_provincias").empty();
            $("#_comunas").empty();
            $.get("/provincias/"+{{ $_persona->id_region }}+"",function(response,state){
                for(i=0; i<= response.length;i++){
                    sel='';
                    if(response[i].provincia_id=={{ $_persona->id_provincia }}){
                        sel=' selected="selected"';
                    }
                    $("#_provincias").append("<option value='"+response[i].provincia_id+"' "+sel+">"+response[i].provincia_nombre+"</option>");
                }
            });
            
            $.get("/comunas/"+{{ $_persona->id_provincia }}+"",function(response,state){
                for(i=0; i<= response.length;i++){
                    sel='';
                    if(response[i].comuna_id=={{ $_persona->id_comuna }}){
                        sel=' selected="selected"';
                    }
                    $("#_comunas").append("<option value='"+response[i].comuna_id+"' "+sel+">"+response[i].comuna_nombre+"</option>");
                }
            });


    });
</script>

                <div class="form-actions">
                    <center>
                        <a href="{{ route('home_propietario') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                    </center>
                </div>
            </div>

        </div>
    </div>
</div>