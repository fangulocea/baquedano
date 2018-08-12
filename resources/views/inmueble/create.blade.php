@extends('admin.layout')

@section('contenido')
    <link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nuevo Inmueble</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('inmueble.store') }}" method="post">
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
                                                    <input name='direccion' id='direccion' class="typeahead form-control" type="text" placeholder="Dirección" required="required"> 
                                            </div>
                                        
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-2">
                                    <div class="form-group">
                                       
                                        <label>Nro.</label>
                                        <input name='numero' type="text" class="form-control" > </div>
                                    
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       
                                        <label>Departamento</label>
                                        <input name='departamento' type="text" class="form-control" > </div>
                                    
                                </div>
                                 <div class="col-md-2">
                                    <div class="form-group">
                                       
                                        <label>Rol</label>
                                        <input name='rol' type="text" class="form-control" > </div>
                                    
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="form-group">
                                         
                                            <label>Referencias de la dirección</label>
                                            <div id="referencia">
                                                    <input name='referencia' id='referencia' class="typeahead form-control" type="text" placeholder="Referencia" > 
                                            </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Región</label>
                                        {{ Form::select('id_region',$regiones, null,array('class'=>'form-control','style'=>'','id'=>'regiones','placeholder'=>'Selecciona región', 'required'=>'required')) }}
                                    </div>
                                </div>

                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Provincia</label>
                                        {{ Form::select('id_provincia',['placeholder'=>'Seleccione provinvia'], null, array('class'=>'form-control','style'=>'','id'=>'provincias', 'required'=>'required')) }} </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        {{ Form::select('id_comuna',['placeholder'=>'Seleccione comuna'], null, array('class'=>'form-control','style'=>'','id'=>'comunas', 'required'=>'required')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Dormitorio</label>
                                        <input name='dormitorio' type="number" class="form-control" required="required"> </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Baños</label>
                                        <input name='bano' type="number" class="form-control" required="required"> 
                                    </div>
                                </div>
                                <!--/span-->
  
                  
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Piscina</label>
                                        <select class="form-control" name="piscina" >
                                            <option value="">Sel. Opción</option>
                                            <option value="SI">SI</option>
                                            <option value="NO">NO</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Bodega</label>
                                        <select class="form-control" name="bodega" >
                                            <option value="">Sel. Opción</option>
                                            <option value="1">SI</option>
                                            <option value="0">NO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Número de Bodega</label>
                                        <input name='nro_bodega' type="number" class="form-control" >
                                    </div>
                                </div>
                              <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Estacionamiento</label>
                                        <input name='estacionamiento' type="number" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nro. Estacionamiento</label>
                                        <input name='nro_estacionamiento' type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Año Antiguedad</label>
                                        <input name='anio_antiguedad' type="number" class="form-control" >
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Gasto Común</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">$</span>
                                            <input name='gastosComunes' type="number" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <div class="input-group"> 
                                            <span class="input-group-addon">$</span>
                                            <input name='precio' type="number" step="any" class="form-control" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Estado</label>
                                        <select class="form-control" name="estado" required="required">
                                            <option value="">Seleccione Estado</option>
                                            <option value="1">Vigente</option>
                                            <option value="0">No Vigente</option>
                                        </select>
                                    </div>
                                </div>
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Condición</label>
                                        <select class="form-control" name="condicion" required="required">
                                            <option value="">Seleccione Condición</option>
                                            <option value="Nuevo">Nuevo</option>
                                            <option value="Usado">Usado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row"> 
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombre Edificio</label>
                                            <input name='edificio' type="text" class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombre Administrador</label>
                                              <input name='nom_administrador' type="text"  class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Teléfono Administrador</label>
                                              <input name='tel_administrador' type="text"  class="form-control" >
                                    </div>
                                </div>
                               <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Email Administrador</label>
                                        <input name='email_administrador' type="email"  class="form-control" >

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

$("#regiones").change(function (event) {
    $("#provincias").empty();
    $("#comunas").empty();
    $.get("/provincias/" + event.target.value + "", function (response, state) {
        $("#provincias").append("<option value=''>Seleccione provincia</option>");
        for (i = 0; i < response.length; i++) {
            $("#provincias").append("<option value='" + response[i].provincia_id + "'>" + response[i].provincia_nombre + "</option>");
        }
    });
});

$("#provincias").change(function (event) {
    $("#comunas").empty();
    $.get("/comunas/" + event.target.value + "", function (response, state) {
        $("#comunas").append("<option value=''>Seleccione comuna</option>");
        for (i = 0; i < response.length; i++) {
            $("#comunas").append("<option value='" + response[i].comuna_id + "'>" + response[i].comuna_nombre + "</option>");
        }
    });
});
</script>
@endsection