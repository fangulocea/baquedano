@extends('admin.layout')

@section('contenido')
@php 
use App\Http\Controllers\PrimeraGestionController;
@endphp
<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box">
                <div class="row row-in">

                    <div class="col-lg-3 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-danger"><i class="ti ti-files"></i></span>
                            </li>
                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::cantGesDia() }}</h3>
                            </li>
                            <li class="col-middle">
                                <h4>Gestión Hoy</h4>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <a href="{{ route('reporteGestion.index','0') }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                            </li>
                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::cantGesMes() }}</h3></li>
                                <li class="col-middle">
                                    <h4>Gestión Mes</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <a href="{{ route('reporteGestion.index',30) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                </li>
                            </ul>
                        </div>                                

                        <div class="col-lg-3 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::cantGesAnio() }}</h3></li>
                                    <li class="col-middle">
                                        <h4>Gestión Año</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                        <a href="{{ route('reporteGestion.index',365) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                    </li>
                                </ul>
                            </div>

                        <div class="col-lg-3 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::cantGestiones() }}</h3></li>
                                    <li class="col-middle">
                                        <h4>Total Gestión</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                        <a href="{{ route('reporteGestion.index',99) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                    </li>
                                </ul>
                            </div>


                        </div>

                <br><br>

                <div class="row row-in">

                    <div class="col-lg-3 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-danger"><i class="ti ti-files"></i></span>
                            </li>
                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::SinRespuesta() }}</h3>
                            </li>
                            <li class="col-middle">
                                <h4>Gestión S/Resp.</h4>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                                <a href="{{ route('reporteCaptaciones.index',2) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-sm-12 row-in-br">
                        <ul class="col-in">
                            <li>
                                <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                            </li>
                            <li class="col-last">
                                <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::Descartados() }}</h3></li>
                                <li class="col-middle">
                                    <h4>Gestión Descartadas</h4>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                            <span class="sr-only"></span>
                                        </div>
                                    </div>
                                    <a href="{{ route('reporteCaptaciones.index',0) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                </li>
                            </ul>
                        </div>                                

                        <div class="col-lg-3 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::PrimeraGestion() }}</h3></li>
                                    <li class="col-middle">
                                        <h4>Primera Gestión</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                        <a href="{{ route('reporteCaptaciones.index',3) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                    </li>
                                </ul>
                            </div>

                        <div class="col-lg-3 col-sm-12 row-in-br  b-r-none">
                            <ul class="col-in">
                                <li>
                                    <span class="circle circle-md bg-danger"><i class="ti-files"></i></span>
                                </li>
                                <li class="col-last">
                                    <h3 class="counter text-right m-t-15">{{ PrimeraGestionController::SinGestion() }}</h3></li>
                                    <li class="col-middle">
                                        <h4>Sin Gestión</h4>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                <span class="sr-only"></span>
                                            </div>
                                        </div>
                                        <a href="{{ route('reporteCaptaciones.index',99) }}" class="btn btn-info" style="color:white"><i class="fa fa-check"></i>&nbsp;&nbsp;&nbsp;Ver&nbsp;&nbsp;&nbsp;</a>
                                    </li>
                                </ul>
                            </div>


                        </div>














                    </div>
                </div>
            </div>

        </div>  



        @endsection
