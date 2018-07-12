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
                        <li><a href="#section-iconbox-1" class="sticon ti-bookmark"><span>Aviso</span></a></li>
                        <li id="li_2"><a id="2" href="#section-iconbox-2" class="sticon ti-home"><span>Propiedad / Propietario</span></a></li>
                        <li><a id="4" href="#section-iconbox-4" class="sticon ti-camera"><span>Fotos</span></a></li>
                        <li><a id="5" href="#section-iconbox-5" class="sticon ti-agenda"><span>Gestiones</span></a></li>
                    </ul>
                </nav>
                <div class="content-wrap">
                    <section id="section-iconbox-1">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Nuevo Aviso Portal Inmobiliario</div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <form action="{{ route('captacion.store') }}" method="post">
                                        {!! csrf_field() !!}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <div class="form-body">
                                        <div class="row">
                                                <div class="col-md-6">
                                                      <div class="col-md-12">
                                                            <div class="form-group">
                                                                <h3 class="box-title">Seleccione contacto para captación externa</h3>
                                                                <hr>
                                                                <label>Corredor  / Externos</label>
                                                                <div class="input-group">
                                                                    {{ Form::select('id_corredor',$corredores, null,array('class'=>'form-control','style'=>'','id'=>'id_corredor','placeholder'=>'Seleccione corredor')) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="col-md-6">
                                            
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="box-title">Información de la publicación web del portal</h3>
                                                            <hr>
                                                            <div class="form-group">
                                                                <label class="control-label">URL</label>
                                                                <input type="hidden" name="paso" value="1">
                                                                <input type="text" name="url" class="form-control"  placeholder="http://portal.dominio.com/publicacion" > <span class="help-block"> Url del Portal </span> </div>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                            <div class="col-md-6 ">
                                                            <div class="form-group">
                                                                <label>Portal</label>
                                                        {{ Form::select('portal',$portales, null,array('class'=>'form-control','style'=>'','id'=>'portal','placeholder'=>'Seleccione portal')) }}
                                                        </div>
                                                    </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Código publicación</label>
                                                                <input name='codigo_publicacion' type="text" class="form-control"> </div>
                                                        </div>

                                                    </div>
                                    
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                <div class="row">
                                              <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha Captación / Publicación</label>
                                                        <div class="input-group">
                                                            <input name="fecha_publicacion" autocomplete="off" type="text" class="form-control" id="datepicker-fecha_publicacion" placeholder="dd/mm/yyyy" required="required"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Fecha Expiración</label>
                                                        <div class="input-group">
                                                            <input name="fecha_expiracion" autocomplete="off" type="text" class="form-control" id="datepicker-fecha_expiracion" placeholder="dd/mm/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                                            <input type="hidden" name="id_estado" value="1">
                                                    </div>
                                                </div>
                                                    </div>
                                            </div>

                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                            <a href="{{ route('captacion.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
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
        swal("Debe crear publicación web");
        return false;
    });
    $("#3").click(function (event) {
        swal("Debe crear publicación web");
        return false;
    });
    $("#4").click(function (event) {
        swal("Debe crear publicación web");
        return false;
    });
    $("#5").click(function (event) {
        swal("Debe crear publicación web");
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
</script>
@endsection