
@extends('admin.arrendatario')


@section('contenido')


<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box" >

                <div class="row" style="padding: 10px">
                    <div class="col-sm-12" style="background-color: #FFFAFA">
                        <div style="background-color: #FFFAFA">
                            <div class="row row-in">
                                <a href="#">
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-success"><i class="ti-clipboard"></i></span>
                                        </li>
                                        <li class="col-last">

                                        </li>
                                        <li class="col-middle">
                                            <h4>Contrato Digitalizado</h4>
                                            
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-danger"><i class="fa fa-dollar"></i></span>
                                        </li>
                                        <li class="col-last">
                                            
                                        </li>
                                        <li class="col-middle">
                                            <h4>Pagos Pendientes</h4>
                            
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-info"><i class="fa fa-dollar"></i></span>
                                        </li>
                                        <li class="col-last">
        
                                        </li>
                                        <li class="col-middle">
                                            <h4>Pagos Realizados</h4>
                                       
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            <a href="#">
                                <div class="col-lg-3 col-sm-6  b-0">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-primary"><i class="ti-clipboard"></i></span>
                                        </li>
                                        <li class="col-last">
                                           
                                        </li>
                                        <li class="col-middle">
                                            <h4>Datos de la Propiedad</h4>
 
                                        </li>
                                    </ul>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                        <hr>
<div class="row" style="padding: 10px">
<div class="col-md-12 col-lg-6 col-sm-12" style="padding-right: 30px; border-right: 1px solid #F0FFF0;">
                        <div style="background-color: #F0FFF0;" >
                            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                                <select class="form-control pull-right row b-none">
                                    <option>March 2017</option>
                                    <option>April 2017</option>
                                    <option>May 2017</option>
                                    <option>June 2017</option>
                                    <option>July 2017</option>
                                </select>
                            </div>
                            <h3 class="box-title">LIQUIDACIÓN MENSUAL</h3>
                            <div class="row" style="background-color: #F0FFF0;" >
                                <div class="col-md-6 col-sm-6 col-xs-6" >
                                    <h2>March 2017</h2>
                                    <p>SALES REPORT</p>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-6 ">
                                    <h1 class="text-right text-info m-t-20">$3,690</h1>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Elite admin</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="txt-oflo">Real Homes WP Theme</td>
                                            <td><span class="label label-info label-rouded">EXTENDED</span></td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">$1250</span></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td class="txt-oflo">Ample Admin</td>
                                            <td><span class="label label-info label-rouded">EXTENDED</span></td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">$1250</span></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td class="txt-oflo">Medical Pro WP Theme</td>
                                            <td><span class="label label-danger label-rouded">TAX</span></td>
                                            <td class="txt-oflo">April 20, 2017</td>
                                            <td><span class="text-danger">-$24</span></td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td class="txt-oflo">Hosting press html</td>
                                            <td><span class="label label-warning label-rouded">SALE</span></td>
                                            <td class="txt-oflo">April 21, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td class="txt-oflo">Digital Agency PSD</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 23, 2017</td>
                                            <td><span class="text-danger">-$14</span></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td class="txt-oflo">Helping Hands WP Theme</td>
                                            <td><span class="label label-warning label-rouded">member</span></td>
                                            <td class="txt-oflo">April 22, 2017</td>
                                            <td><span class="text-success">$64</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5 col-lg-6 col-sm-12" style="padding-left: 30px">
                    <div class="row" style="background-color: #F8F8FF;">
                         <h3 class="box-title">CHECK IN DE LA PROPIEDAD</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Elite admin</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row" style="background-color: #E0FFFF">
                         <h3 class="box-title">AUTORIZACIONES POST ATENCIÓN</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th>STATUS</th>
                                            <th>DATE</th>
                                            <th>PRICE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td class="txt-oflo">Elite admin</td>
                                            <td><span class="label label-success label-rouded">SALE</span> </td>
                                            <td class="txt-oflo">April 18, 2017</td>
                                            <td><span class="text-success">$24</span></td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td class="txt-oflo">Real Homes WP Theme</td>
                                            <td><span class="label label-info label-rouded">EXTENDED</span></td>
                                            <td class="txt-oflo">April 19, 2017</td>
                                            <td><span class="text-info">$1250</span></td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
</div>
<hr>
                 <div class="row"  >
                            <div class="panel" >
                            <div class="panel-heading">DATOS PARA TRANSFERENCIAS</div>
                            <div class="table-compact" >
                                <table class="table table-hover manage-u-table" >
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>BANCO</th>
                                            <th>NÚMERO DE CUENTA</th>
                                            <th>RUT</th>
                                            <th>EMAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td></td>
                                            <td>BANCO ESTADO</td>
                                            <td>444444444
                                                </td>
                                            <td>44444-4</td>

                                            <td>
                                                contacto@ibaquedano.cl
                                            </td>
                                        </tr>

                                       
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="panel">
                            <div class="panel-heading">CONTACTOS BAQUEDANO</div>
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;" class="text-center">#</th>
                                            <th>NOMBRE</th>
                                            <th>DEPARTAMENTO</th>
                                            <th>EMAIL</th>
                                            <th>TELÉFONO</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td class="text-center">1</td>
                                            <td><span class="font-medium">Neila Chavez</span>
                                                <br/><span class="text-muted">Ejecutiva Administración</span></td>
                                            <td>Departamento de Administración
                                                </td>
                                            <td>neila@ibaquedano.cl</td>

                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 2 323 07 257
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td><span class="font-medium">Ejectivos Post Atención</span>
                                                <br/><span class="text-muted">Post Venta</span></td>
                                            <td>Departamento Post Atención
                                                </td>
                                            <td>postventa@ibaquedano.cl</td>

                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 9 581 63 021
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td> <span class="font-medium">Javier Faria A.</span>
                                                <br/><span class="text-muted">Agente Inmobiliario</span></td>
                                            <td>Departamento Contact Center
                                                </td>
                                            <td>javier@ibaquedano.cl
                                                </td>
                                            <td>
                                                +56 2 290 23 010<br/>
                                                +56 9 525 42 709
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>

   <div class="row" style="background-color: #f4f4f4">
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/inv.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>INVERSIONES</strong></h3>
                            <p>Compra y venta de terrenos, desarrollos inmobiliarios.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/inversiones-baquedano" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/broker.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>BROKER</strong></h3>
                            <p>Compra y venta de <br>inmuebles.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-broker" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/imr.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>RENTAS</strong></h3>
                            <p>Arriendo Garantizado de departamentos.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-rentas" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                        <center> <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="user" style="width: 70%" src="{{ URL::asset('plugins/images/im1.png') }}"></center>
                        <div class="white-box">
                            <h3 class="m-t-20 m-b-20" style="    font-size: 1.25em; ">BAQUEDANO <strong>PROPIEDADES</strong></h3>
                            <p>Compra y venta de <br>inmuebles.</p>
                            <button class="btn btn-success btn-rounded waves-effect waves-light m-t-20"><a href="http://ibaquedano.cl/baquedano-propiedades" target="_blank" style="color:white">Ver más</a></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>  

@endsection
