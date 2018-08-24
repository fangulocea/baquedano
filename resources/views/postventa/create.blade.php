@extends('admin.layout')

@section('contenido')
<link href="{{ URL::asset('/plugins/bower_components/typeahead.js-master/dist/typehead-min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('plugins/bower_components/sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css">
<style>
#scrollable-dropdown-menu .tt-dropdown-menu {
  max-height: 130px;
  overflow-y: auto;
}
</style>
<div class="row" >
    
</style>>
    <div class="col-md-12">
        <section>
            <div class="sttabs tabs-style-iconbox">
                <nav>
                    <ul>
                        <li id="li_1"><a id="1" href="#section-iconbox-1" class="sticon ti-bookmark"><span>Post Atención</span></a></li>
                        <li id="li_2"><a id="2" href="#section-iconbox-2" class="sticon ti-home"><span>Solicitud</span></a></li>
                        <li id="li_3"><a id="3" href="#section-iconbox-2" class="sticon ti-home"><span>Propiedad</span></a></li>
                        <li id="li_4"><a id="4" href="#section-iconbox-3" class="sticon ti-user"><span>Propietario</span></a></li>
                        <li id="li_5"><a id="5" href="#section-iconbox-4" class="sticon ti-user"><span>Arrendatario</span></a></li>
                        <li id="li_6"><a id="6" href="#section-iconbox-5" class="sticon ti-user"><span>Aval</span></a></li>
                        <li id="li_7"><a id="7" href="#section-iconbox-6" class="sticon ti-key"><span>Administración</span></a></li>
                        <li id="li_8"><a id="8" href="#section-iconbox-7" class="sticon ti-clip"><span>Documentos</span></a></li>
                        <li id="li_9"><a id="9" href="#section-iconbox-8" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                        <li id="li_10"><a id="10" href="#section-iconbox-9" class="sticon ti-money"><span>Presupuestos</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1" style="height: 500px">
                        <form action="{{ route('postventa.grabar') }}" method="post" id="form">
                            {!! csrf_field() !!}
                        <div class="panel panel-info">
                            <div class="panel-heading"> Datos de la Atención</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                       
                                        
                                        <div class="col-md-3">
                                            <label>Fecha Solicitud</label>
                                            @php

                                                    $fecha = date('Y-m-d');
                                                    
                                            @endphp
                                            <input type="hidden" name="id_contrato" id="id_contrato" >
                                            <input type="hidden" name="id_modulo" id="id_modulo" >
                                            <input type="date" name="fecha_solicitud" id="fecha_solicitud" value="{{ $fecha }}"  class="form-control">
                                        </div>
                                         <div class="col-md-3">
                                            <label>Asignado</label>
                                            <select name="asignado" id="asignado" class="form-control">
                                                <option value="">Seleccione</option>

                                                @foreach($empleados as $e )
                                                    <option value="{{ $e->id }}">{{ $e->empleado }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                         <div class="col-md-3">
                                            <label>Estado</label>
                                            <select name="estado" id="estado" class="form-control">
                                                <option value="">Seleccione</option>
                                                @foreach($estados as $e )
                                                    <option value="{{ $e->id_estado }}">{{ $e->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <label>Tipo de Contrato</label>
                                            <select name="modulo" id="modulo" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="1">Propietario</option>
                                                <option value="2">Arrendatario</option>
                                            </select>
                                        </div>
        
                                    </div>
                                    <hr>
                                <div class="row" id="propietario" style="display:none">
                                        <div class="col-md-12">
                                            <label>Seleccione contrato por Dirección</label>
                                            <div id="scrollable-dropdown-menu">
                                            <input type="text" name="direccion" id="direccion"  class="form-control">
                                        </div>
                                        </div>
                                    </div>
                              <div class="row" id="arrendatario" style="display:none">
                                        <div class="col-md-12">
                                            <label>Seleccione contrato por Dirección</label>
                                            <div id="scrollable-dropdown-menu">
                                            <input type="text" name="direccion2" id="direccion2"  class="form-control">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </section>
                    <section id="section-iconbox-2">
                        
                    </section>
                    <section id="section-iconbox-3">
                        
                    </section>
                    <section id="section-iconbox-4">
                        
                    </section>
                    <section id="section-iconbox-5">
                        
                    </section>
                    <section id="section-iconbox-6">
                        
                    </section>
                    <section id="section-iconbox-7">
                        
                    </section>
                    <section id="section-iconbox-8">
                        
                    </section>
                    <section id="section-iconbox-9">
                        
                    </section>
                    <section id="section-iconbox-10">
                        
                    </section>
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
        swal("Debe crear la atención");
        return false;
    });
    $("#3").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#4").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#5").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#7").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#8").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#9").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
        $("#10").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $("#6").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);



var direcciones = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (dir) {
                return {value: 'Id: ' + dir.id + ', Dir: ' + dir.direccion + ', Nro: ' + dir.numero + ', Comuna: ' + dir.comuna_nombre};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/inmuebles/1/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' ' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
                    option: dir.id, modulo:1};
            });
        }
    }
});




$('#direccion').typeahead({

    hint: false,
    highlight: true,
    minLength: 1,
    val:'',
    limit: 10
},
        {
            name: 'direcciones',
            display: 'value',
            limit: 20,
            source: direcciones
        });

jQuery('#direccion').on('typeahead:selected', function (e, datum) {

    if($("#fecha_solicitud").val()=='' || $("#asignado").val()=='' || $("#modulo").val()=='' || $("#estado").val()=='' ){

        swal({   
            title: "Debe completar todos los campos del formulario",    
            type: "error",     
            confirmButtonColor: "#DD6B55",   
            closeOnConfirm: true 
        }, function(){   
             
        }); 
        
        return false;

    }
 
        swal({   
            title: "Esta seguro que desea crear una solicitud con el siguiente contrato?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
            $("#id_contrato").val(datum.option);
            $("#id_modulo").val(1);
             $('#form').submit();
        });

   
});


var direcciones1 = new Bloodhound({
    datumTokenizer: function (datum) {
        return Bloodhound.tokenizers.whitespace(datum.value);
    },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: {
        url: "/",
        transform: function (response) {
            return $.map(response, function (dir) {
                return {value: 'Id: ' + dir.id + ', Dir: ' + dir.direccion + ', Nro: ' + dir.numero + ', Comuna: ' + dir.comuna_nombre};
            });
        }
    },
    remote: {
        wildcard: '%QUERY',
        url: "/inmuebles/2/%QUERY",
        transform: function (response) {
            return $.map(response, function (dir) {
                var num=dir.numero==null?'':dir.numero;
                var dpto=dir.departamento==null?'':dir.departamento;
                return {value: dir.direccion + ' ' + num  + ' Dpto '+ dpto +',  ' + dir.comuna_nombre,
                    option: dir.id};
            });
        }
    }
});




$('#direccion2').typeahead({

    hint: false,
    highlight: true,
    minLength: 1,
    val:'',
    limit: 10
},
        {
            name: 'direcciones',
            display: 'value',
            limit: 20,
            source: direcciones1
        });

jQuery('#direccion2').on('typeahead:selected', function (e, datum) {

    if($("#fecha_solicitud").val()=='' || $("#asignado").val()=='' || $("#modulo").val()=='' || $("#estado").val()=='' ){

        swal({   
            title: "Debe completar todos los campos del formulario",    
            type: "error",     
            confirmButtonColor: "#DD6B55",   
            closeOnConfirm: true 
        }, function(){   
             
        }); 
        
        return false;

    }
 
        swal({   
            title: "Esta seguro que desea crear una solicitud con el siguiente contrato?",   
            text: datum.value,   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "SI",   
            closeOnConfirm: false 
        }, function(){   
            $("#id_contrato").val(datum.option);
            $("#id_modulo").val(2);
             $('#form').submit();
        });

   
});

    $("#asignado").change(function (event) {
        jQuery('#direccion').val("");
        return false;
    });
        $("#modulo").change(function (event) {
            if(this.value==1){
                $("#arrendatario").hide();
                $("#propietario").show();
            }else if(this.value==2){
                $("#arrendatario").show();
                $("#propietario").hide();
            }else{
                $("#arrendatario").hide();
                $("#propietario").hide();
            }
        jQuery('#direccion').val("");
        return false;
    });
            $("#estado").change(function (event) {
        jQuery('#direccion').val("");
        return false;
    });
</script>
@endsection