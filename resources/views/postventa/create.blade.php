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
                        <li id="li_1"><a id="1" href="#section-iconbox-1" class="sticon ti-bookmark"><span>Post Atención</span></a></li>
                        <li id="li_2"><a id="2" href="#section-iconbox-2" class="sticon ti-home"><span>Propiedad</span></a></li>
                        <li id="li_3"><a id="3" href="#section-iconbox-3" class="fa fa-user"><span>Propietario</span></a></li>
                        <li id="li_4"><a id="4" href="#section-iconbox-4" class="fa fa-user"><span>Arrendatario</span></a></li>
                        <li id="li_5"><a id="5" href="#section-iconbox-5" class="fa fa-user"><span>Aval</span></a></li>
                        <li id="li_6"><a id="6" href="#section-iconbox-6" class="fa fa-key"><span>Administración</span></a></li>
                        <li id="li_7"><a id="7" href="#section-iconbox-7" class="sticon ti-camera"><span>Fotos</span></a></li>
                        <li id="li_8"><a id="8" href="#section-iconbox-8" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                        <li id="li_9"><a id="9" href="#section-iconbox-9" class="fa fa-usd"><span>Presupuestos</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Datos de la Atención</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Fecha Solicitud</label>
                                            <input type="date" name="fecha_solicitud" id="fecha_solicitud"  class="form-control">
                                        </div>
                                         <div class="col-md-3">
                                            <label>Asignado</label>
                                            <select name="asignado" id="asignado" class="form-control">
                                                <option value="">Seleccione</option>

                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tipo de Contrato</label>
                                            <select name="modulo" id="modulo" class="form-control">
                                                <option value="">Seleccione</option>
                                                <option value="Propietario">Propietario</option>
                                                <option value="Arrendatario">Arrendatario</option>
                                            </select>
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-md-12">
                                            <label>Seleccione contrato por Dirección</label>
                                            <input type="text" name="contrato" id="contrato"  class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    $("#6").click(function (event) {
        swal("Debe crear la atención");
        return false;
    });
    $.SweetAlert = new SweetAlert, $.SweetAlert.Constructor = SweetAlert
}(window.jQuery);
</script>
@endsection