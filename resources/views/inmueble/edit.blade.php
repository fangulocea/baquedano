@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Editar Inmueble</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('inmueble.update',$inmueble->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información del inmueble</h3>
                            <hr>
                            <div class="row"> 

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <label>Dirección</label>
                                        <div id="direcciones">
                                            <input name='direccion' id='direccion' class="typeahead form-control" type="text" placeholder="Dirección" value='{{ $inmueble->direccion or ''}}' required="required"> 
                                        </div>
                                        
                                    </div>
                                </div>



                                <!--/span-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Nro.</label>
                                      <input name='numero' value='{{ $inmueble->numero or ''}}' type="text" class="form-control" required="required"> </div>
                                  </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                      <label>Departamento</label>
                                      <input name='departamento' value='{{ $inmueble->departamento or ''}}' type="text" class="form-control" > </div>
                                  </div>
                                  <div class="col-md-2">
                                    <div class="form-group">
                                       
                                        <label>Rol</label>
                                        <input name='rol' type="text" class="form-control" value='{{ $inmueble->departamento or ''}}'> </div>
                                    
                                </div> 
                              </div>
                            <div class="row"> 
                             <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Referencia</label>
                                        <div id="direcciones">
                                            <input name='referencia' id='referencia' class="typeahead form-control" type="text" placeholder="Referencia"  value='{{ $inmueble->referencia or '' }}'> 
                                        </div>
                                        
                                    </div>
                                </div>
                                                </div>
                              <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, $inmueble->id_region,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Seleccione región', 'required'=>'required')) }}
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Selecciona provincia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias', 'required'=>'required')) }} </div>
                                    </div>
                                    <!--/span-->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Comuna</label>
                                            {{ Form::select('id_comuna',['placeholder'=>'Selecciona comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas', 'required'=>'required')) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-md-2">
                                        <div class="form-group">
                                           <label>Dormitorio</label>
                                           <input name='dormitorio' type="number" class="form-control" value='{{ $inmueble->dormitorio }}' required="required"> </div>
                                       </div>
                                       <div class="col-md-2">
                                        <div class="form-group">
                                          <label>Baños</label>
                                          <input name='bano' type="number" class="form-control" value='{{ $inmueble->bano }}' required="required"> </div>
                                      </div>
                                      <!--/span-->
                                
      
        
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Piscina</label>
                                            {{ Form::select('piscina',['SI'=>'SI','NO'=>'NO'], $inmueble->piscina ,array('class'=>'form-control','style'=>'','id'=>'piscina','placeholder'=>'Seleccione piscina','required'=>'required')) }}
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
                                            {{ Form::select('bodega',['1'=> 'SI', '0'=>'NO'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'bodega','placeholder'=>'Seleccione','required'=>'required')) }}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Número de Bodega</label>
                                         <input name='nro_bodega' type="text" class="form-control" value='{{ $inmueble->nro_bodega or '' }}' >
                                    </div>
                                </div>
                                  <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Estacionamiento</label>
                                            <input name='estacionamiento' type="number" class="form-control" value='{{ $inmueble->estacionamiento }}' required="required">
                                        </div>
                                    </div>                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nro. Estacionamiento</label>
                                        <input name='nro_estacionamiento' type="text" class="form-control" value='{{ $inmueble->nro_estacionamiento or '' }}'>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Año Antiguedad</label>
                                        <input name='anio_antiguedad' type="number" class="form-control" value='{{ $inmueble->anio_antiguedad or '' }}'>
                                    </div>
                                </div>
                            </div>
                                <div class="row"> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Gasto Común</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">$</span>
                                                <input name='gastosComunes' type="number" class="form-control" value='{{ $inmueble->gastosComunes }}' >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Precio</label>
                                            <div class="input-group"> 
                                                <span class="input-group-addon">$</span>
                                                <input name='precio' type="number" step="any" class="form-control"
                                                value='{{ $inmueble->precio }}' required="required" min="1" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            {{ Form::select('estado',['1'=>'Vigente','0'=>'No Vigente','2'=>'Reservado'], $inmueble->estado ,array('class'=>'form-control','style'=>'','id'=>'estado','placeholder'=>'Selecciona estado','required'=>'required')) }}
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
                                                        {{ Form::select('condicion',['Nuevo'=> 'Nuevo', 'Usado'=>'Usado'], $idpi ,array('class'=>'form-control','style'=>'','id'=>'condicion','placeholder'=>'Seleccione','required'=>'required')) }}

                                                    </div>
                                                </div>
                                </div>
                                                      <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombre Edificio</label>
                                            <input name='edificio' type="text" class="form-control" value='{{ $inmueble->edificio or '' }}'>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombre Administrador</label>
                                              <input name='nom_administrador' type="text"  class="form-control" value='{{ $inmueble->nom_administrador or '' }}'>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Teléfono Administrador</label>
                                              <input name='tel_administrador' type="text"  class="form-control" value='{{ $inmueble->tel_administrador or '' }}'>
                                    </div>
                                </div>
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email Administrador</label>
                                        <input name='email_administrador' type="email"  class="form-control" value='{{ $inmueble->email_administrador or '' }}'>

                                    </div>
                                </div>
                            </div>

                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                <a href="{{ route('inmueble.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
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
                        return { value: 'Id: '+dir.id+ ', Dir: '+ dir.direccion + ', Nro: '+dir.numero+ ', Comuna: '+dir.comuna_nombre };
                    });
                }
            },
            remote: {
                wildcard: '%QUERY',
                url: "/inmuebles/%QUERY",
                transform: function(response) {
                    return $.map(response, function(dir) {
                        return { value: dir.direccion + '      , '+dir.numero+ ' ,  '+dir.comuna_nombre,
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
            window.location.href = '/inmueble/'+datum.option+'/edit'; 
        });



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
    </script>
    @endsection