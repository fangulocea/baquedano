@extends('admin.layout')
@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<div class="row">
    <div class="col-md-12">
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li><a href="#section-iconbox-1" class="sticon ti ti-user"><span>Arrendatario</span></a></li>
                        <li><a id="4" href="#section-iconbox-4" class="sticon ti-camera"><span>Documentos</span></a></li>
                        <li><a id="5" href="#section-iconbox-5" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Nuevo Arrendatario</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('arrendatario.store') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                            <h3 class="box-title">Información del Arrendatario</h3>
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
                                                        <label>Estado</label>
                                                        <select class="form-control" name="id_estado" required="required">
                                                            <option value="">Seleccione Estado</option>
                                                            <option value="0">Descartado</option>
                                                            <option value="1">Sin Gestión (Activo)</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                        </div>
                        <div class="form-actions">
                            <input type="hidden" name="id_creador" value="{{ Auth::user()->id_persona}}">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('arrendatario.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section id="section-iconbox-2" >
                        <h2>Tabbing 2</h2></section>
                    <section id="section-iconbox-4">
                        <h2>Tabbing 4</h2></section>
                    <section id="section-iconbox-5">
                        <h2>Tabbing 5</h2></section>
                </div>
                <!-- /content -->
            </div>
            <!-- /tabs -->
        </section>
    </div>
</div>


<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap Core JavaScript -->
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>


<script src="{{ URL::asset('plugins/bower_components/typeahead.js-master/dist/typeahead.bundle.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.min.js') }}"></script>
<script>

var SweetAlert = function () {};

//examples 
SweetAlert.prototype.init = function () {

    //Basic
    $("#2").click(function (event) {
        swal("Debe crear Arrendatario");
        return false;
    });
    $("#3").click(function (event) {
        swal("Debe crear Arrendatario");
        return false;
    });
    $("#4").click(function (event) {
        swal("Debe crear Arrendatario");
        return false;
    });
    $("#5").click(function (event) {
        swal("Debe crear Arrendatario");
        return false;
    });
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery),
        jQuery('#datepicker-fecha_publicacion').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy'
});

jQuery('#datepicker-fecha_expiracion').datepicker({
    autoclose: true,
    todayHighlight: true,
    format: 'dd/mm/yyyy'
});

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


</script>
@endsection

