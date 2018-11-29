
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
@can('alerta.captaciones')
                        <div class="panel panel-inverse">
                            <div class="panel-heading"> Gestiones Captación Propietarios
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-2">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesDia() }}</h1>
                                                    <a href="{{ route('alertas.gestion_hoy') }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión <br> Hoy</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                            <center>
                                                <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesMes() }}</h1>
                                                <a href="{{ route('alertas.gestion_mes') }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión<br> Mes</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGesAnio() }}</h1>
                                                       <a href="{{ route('alertas.gestion_anual') }}"> <span class="btn btn-block btn-primary btn-rounded">Gestión <br>Anual</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantGestiones() }}</h1>
                                                       <a href="{{ route('alertas.gestion_total') }}"> <span class="btn btn-block btn-primary btn-rounded">Total de<br> Gestiones</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantCaptacionesMensuales() }}</h1>
                                                       <a href="{{ route('alertas.cap_mes') }}"> <span class="btn btn-block btn-primary btn-rounded">Total Mensual<br>de Captaciones</span></a>
                                                   </center>
                                        </div>
                                       <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantCaptacionesAnuales() }}</h1>
                                                       <a href="{{ route('alertas.cap_anual') }}"> <span class="btn btn-block btn-primary btn-rounded">Total Anual<br>de Captaciones</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::Descartados() }}</h1>
                                                       <a href="{{ route('alertas.cap_descartadas') }}"> <span class="btn btn-block btn-danger btn-rounded">Captaciones<br> Descatradas</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::SinRespuesta() }}</h1>
                                                       <a href="{{ route('alertas.cap_sin_respuesta') }}"> <span class="btn btn-block btn-danger btn-rounded">Captación<br> Sin Respuesta</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::PrimeraGestion() }}</h1>
                                                       <a href="{{ route('alertas.cap_primera_gestion') }}"> <span class="btn btn-block btn-danger btn-rounded">Primera <br>Gestión</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::SinGestion() }}</h1>
                                                       <a href="{{ route('alertas.cap_sin_gestion') }}"> <span class="btn btn-block btn-danger btn-rounded">Captaciones <br>Sin Gestión</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantborradores() }}</h1>
                                                       <a href="{{ route('alertas.cap_borrador') }}"> <span class="btn btn-block btn-success btn-rounded">En Contrato<br>Borrador</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ PrimeraGestionController::cantactivos() }}</h1>
                                                       <a href="{{ route('alertas.cap_contrato') }}"> <span class="btn btn-block btn-success btn-rounded">Contrato<br>Activo</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endcan
@can('alerta.captaciones')
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
                                                    <a href="{{ route('alertas.cap_mes_arr') }}"> <span class="btn btn-block btn-primary btn-rounded">Captación<br> Mensual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                            <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadanual() }}</h1>
                                                    <a href="{{ route('alertas.cap_anual_arr') }}"> <span class="btn btn-block btn-primary btn-rounded">Captación<br> Anual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidaddescartada() }}</h1>
                                                    <a href="{{ route('alertas.cap_descartadas_arr') }}"> <span class="btn btn-block btn-danger btn-rounded">Captaciones<br> Descartadas</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadborrador() }}</h1>
                                                    <a href="{{ route('alertas.cap_borrador_arr') }}"> <span class="btn btn-block btn-success btn-rounded">En Contrato<br> Borrador</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-2">
                                                    <center>
                                                    <h1 class="counter m-t-15">{{ PrimeraGestionController::arr_cantidadfinal() }}</h1>
                                                    <a href="{{ route('alertas.cap_contrato_arr') }}"> <span class="btn btn-block btn-success btn-rounded">Contratos<br> Activos</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endcan
@can('alerta.administracion')
                    <div class="panel panel-success">
                            <div class="panel-heading"> Contratos Propietarios
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendientePasadoPro() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.adm_contratomespro') }}"> <span class="btn btn-block btn-primary btn-rounded">Salida Mensual<br>Mes Anterior</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendienteActualPro() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.adm_contratomespro') }}"> <span class="btn btn-block btn-primary btn-rounded">Salida Mensual<br> Mes Actual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendienteProximoPro() , 0, '.', ',')}}</h1>
                                                        
                                                       <a href="{{ route('alertas.adm_contratomespro') }}"> <span class="btn btn-block btn-primary btn-rounded">Salida Mensual <br>Próximo Mes</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                       
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MorososPasadoPro() , 0, '.', ',')}}</h1>
                                                       <a href="{{ route('alertas.adm_morosopro') }}"> <span class="btn btn-block btn-danger btn-rounded">Montos Morosos<br>Mes Anterior</span></a>
                                                   </center>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPagadoAnteriorPro() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.adm_pagadospro') }}"> <span class="btn btn-block btn-primary btn-rounded">Monto Pagado<br>Mes Anterior</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPagadoActualPro() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.adm_pagadospro') }}"> <span class="btn btn-block btn-primary btn-rounded">Monto Pagado<br> Mes Actual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                               
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                       
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MorosoActualPro() , 0, '.', ',')}}</h1>
                                                       <a href="{{ route('alertas.adm_morosopro') }}"> <span class="btn btn-block btn-danger btn-rounded">Transferencias Atrasadas<br> Mes Actual</span></a>
                                                   </center>
                                        </div>
                                    </div>

                                    <div class="row">
                                                <div class="col-sm-3">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::transhoypro() , 0, '.', ',')}}</h1>
                                                        
                                                       <a href="{{ route('alertas.gestion_anual') }}"> <span class="btn btn-block btn-info btn-rounded">Hacer Transferencia <br>Hoy</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                       
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::transmananaPro() , 0, '.', ',')}}</h1>
                                                       <a href="{{ route('alertas.gestion_total') }}"> <span class="btn btn-block btn-info btn-rounded">Hacer Transferencia<br> Mañana</span></a>
                                                   </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
  
    <div class="panel panel-success">
                            <div class="panel-heading"> Contratos Arrendatarios
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendientePasadoARR() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.gestion_hoy') }}"> <span class="btn btn-block btn-primary btn-rounded">Entrada Mensual<br>Mes Anterior</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendienteActualARR() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.gestion_mes') }}"> <span class="btn btn-block btn-primary btn-rounded">Entrada Mensual<br> Mes Actual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPendienteProximoARR() , 0, '.', ',')}}</h1>
                                                        
                                                       <a href="{{ route('alertas.gestion_anual') }}"> <span class="btn btn-block btn-primary btn-rounded">Entrada Mensual <br>Próximo Mes</span></a>
                                                   </center>
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                       
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MorososPasadoARR() , 0, '.', ',')}}</h1>
                                                       <a href="{{ route('alertas.gestion_total') }}"> <span class="btn btn-block btn-danger btn-rounded">Montos Morosos<br>Mes Anterior</span></a>
                                                   </center>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPagadoAnteriorARR() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.gestion_hoy') }}"> <span class="btn btn-block btn-primary btn-rounded">Monto Pagado<br>Mes Anterior</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MontoPagadoActualARR() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.gestion_mes') }}"> <span class="btn btn-block btn-primary btn-rounded">Monto Pagado<br> Mes Actual</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                               
                                        </div>
                                        <div class="col-sm-3">
                                                    <center>
                                                       
                                                        <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::MorosoActualARR() , 0, '.', ',')}}</h1>
                                                       <a href="{{ route('alertas.gestion_total') }}"> <span class="btn btn-block btn-danger btn-rounded">Pagos Atrasadas<br> Mes Actual</span></a>
                                                   </center>
                                        </div>
                                    </div>

                                  
                                </div>
                            </div>
                        </div>
                          @endcan
@can('alerta.postventa')
 <div class="panel panel-primary">
                            <div class="panel-heading"> Post Atención
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> <a href="#" data-perform="panel-dismiss"><i class="ti-close"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::solpaarr() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.solpa_arr') }}"> <span class="btn btn-block btn-info btn-rounded">Revisión SOLPA<br>30 Días Arrendatario</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::solpapro() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.solpa_pro') }}"> <span class="btn btn-block btn-info btn-rounded">Revisión SOLPA<br>30 Días Propietario</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::sin_solparr() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.solpa_sinrevisar_arr') }}"> <span class="btn btn-block btn-info btn-rounded">Sin Revisar SOLPA<br>Menor a 30 Días Arrendatario</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::sin_solppro() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.solpa_sinrevisar_pro') }}"> <span class="btn btn-block btn-info btn-rounded">Sin Revisar SOLPA<br>Menor a 30 Días Propietario</span></a>
                                            </center>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">
                                             <center>
                                                    <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::sin_revisar() , 0, '.', ',')}}</h1>
                                                    <a href="{{ route('alertas.cuentas') }}"> <span class="btn btn-block btn-info btn-rounded">Cuentas Básicas<br>Sin Revisar menor 30 días</span></a>
                                            </center>
                                        </div>
                                        <div class="col-sm-3">
                                            <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::solpv_pro() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.solpv_pro') }}"> <span class="btn btn-block btn-info btn-rounded">Solicitud de Pago<br> Activas Propietario</span></a>
                                            </center>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                                      <center>
                                                <h1 class="counter m-t-15">{{ number_format(PrimeraGestionController::solpv_arr() , 0, '.', ',')}}</h1>
                                                <a href="{{ route('alertas.solpv_arr') }}"> <span class="btn btn-block btn-info btn-rounded">Solicitud de Pago<br> Activas Arrendatarios</span></a>
                                            </center>
                                        </div>
                                    </div>

                                  
                                </div>
                            </div>
                        </div>
@endcan
                    </div>
                </div>
            </div>

        </div>  

@else
    <script>window.location = "/importExportcontact";</script>

@endif

        @endsection
