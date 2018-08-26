
@if( Auth::user()->roles[0]->slug !='Contact Center'  )
    @extends('admin.layout')
@endif

@section('contenido')
@php 
use App\Http\Controllers\PrimeraGestionController;
@endphp




@if( Auth::user()->roles[0]->slug !='Contact Center'  )

<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">

                        <div class="panel panel-info">
                            <div class="panel-heading"> Gestiones Captación Propietarios
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesDia() }}</h1>
                                                    <a href="{{ route('reporteGestion.index','0') }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión <br> Hoy</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                            <center>
                                                <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesMes() }}</h1>
                                                <a href="{{ route('reporteGestion.index',30) }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión<br> Mes</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesAnio() }}</h1>
                                                       <a href="{{ route('reporteGestion.index',365) }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión <br>Anual</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGestiones() }}</h1>
                                                       <a href="{{ route('reporteGestion.index',99) }}"> <span class="btn btn-block btn-primary btn-rounded">Total de<br> Gestiones</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantCaptacionesMensuales() }}</h1>
                                                       <a href="#"> <span class="btn btn-block btn-primary btn-rounded">Total Mensual<br>de Captaciones</span></a>
                                                   </center>
                                        </div>
                                       <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantCaptacionesAnuales() }}</h1>
                                                       <a href="#"> <span class="btn btn-block btn-primary btn-rounded">Total Anual<br>de Captaciones</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::Descartados() }}</h1>
                                                       <a href="{{ route('reporteGestion.index',0) }}"> <span class="btn btn-block btn-danger btn-rounded">Captaciones<br> Descatradas</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::SinRespuesta() }}</h1>
                                                       <a href="{{ route('reporteGestion.index',99) }}"> <span class="btn btn-block btn-danger btn-rounded">Captación<br> Sin Respuesta</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::PrimeraGestion() }}</h1>
                                                       <a href="{{ route('reporteCaptaciones.index',3) }}"> <span class="btn btn-block btn-danger btn-rounded">Primera <br>Gestión</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::SinGestion() }}</h1>
                                                       <a href="{{ route('reporteCaptaciones.index',99) }}"> <span class="btn btn-block btn-danger btn-rounded">Captaciones <br>Sin Gestión</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantborradores() }}</h1>
                                                       <a href="#"> <span class="btn btn-block btn-success btn-rounded">En Contrato<br>Borrador</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantactivos() }}</h1>
                                                       <a href="#"> <span class="btn btn-block btn-success btn-rounded">Contrato<br>Activo</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-inverse">
                            <div class="panel-heading"> Gestiones Captación Arrendatarios
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                             <center>
                                                     <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadmesual() }}</h1>
                                                    <a href="#"> <span class="btn btn-block btn-primary btn-rounded">Captación<br> Mensual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                            <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadanual() }}</h1>
                                                    <a href="#"> <span class="btn btn-block btn-primary btn-rounded">Captación<br> Anual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidaddescartada() }}</h1>
                                                    <a href="#"> <span class="btn btn-block btn-danger btn-rounded">Captaciones<br> Descartadas</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadborrador() }}</h1>
                                                    <a href="#"> <span class="btn btn-block btn-success btn-rounded">En Contrato<br> Borrador</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadfinal() }}</h1>
                                                    <a href="#"> <span class="btn btn-block btn-success btn-rounded">Contratos<br> Activos</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


    

                    </div>
                </div>
            </div>

        </div>  

@else
    <script>window.location = "/importExportcontact";</script>

@endif

        @endsection
