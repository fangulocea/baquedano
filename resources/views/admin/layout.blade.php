<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::asset('plugins/images/ico.png') }}">
        <title>Sistema de Información - Baquedano Rentas</title>
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">

        <!-- Menu CSS -->
        <link href="{{ URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
        <!-- toast CSS -->
        <link href="{{ URL::asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
        <!-- morris CSS -->
        <link href="{{ URL::asset('plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
        <!-- Calendar CSS -->
        <link href="{{ URL::asset('plugins/bower_components/calendar/dist/fullcalendar.css') }}" rel="stylesheet" />
        <!-- animation CSS -->
        <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
        <!-- color CSS -->
        <link href="{{ URL::asset('css/colors/megna-dark.css') }}" id="theme" rel="stylesheet">

        <script src="{{ URL::asset('js/ValidarRut.js') }}"></script>




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body class="fix-header">
        <!-- ============================================================== -->
        <!-- Preloader -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
        <!-- ============================================================== -->
        <!-- Wrapper -->
        <!-- ============================================================== -->
        <div id="wrapper">
            <!-- ============================================================== -->
            <!-- Topbar header - style you can find in pages.scss -->
            <!-- ============================================================== -->
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <!-- Logo -->
                        <a class="logo" href="{{ route('home') }}">
                            <!-- Logo icon image, you can use font-icon also --><b>
                                <!--This is dark logo icon--><img src="{{ URL::asset('plugins/images/logo-Baquedano-small.png') }}" width="80" height="50" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="{{ URL::asset('plugins/images/logo-Baquedano-small.png') }}" alt="home" class="light-logo" width="80" height="50" />
                                <img src="{{ URL::asset('plugins/images/inicio.png') }}" alt="home" class="light-logo" width="80" height="50" />
                            </b> </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Search input and Toggle icon -->
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="ti-menu"></i></a></li>
                        
                        
                    </ul>
                    <button class="right-side-toggle waves-effect waves-light btn-info btn-circle pull-right m-l-20"><i class="ti-settings text-white"></i></button>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form role="search" class="app-search hidden-sm hidden-xs m-r-10">

                                <input type="text" placeholder="Buscar" class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                        </li>

                        @if (Auth::guest())
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @else

                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ URL::asset('plugins/images/users/baquedano.png') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }} </b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="{{ URL::asset('plugins/images/users/baquedano.png') }}" alt="user" /></div>
                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p><a href="{{ route('persona.edithome',Auth::user()->id_persona) }}" class="btn btn-rounded btn-danger btn-sm">Ver Perfil</a></div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>

                                <li><a href="{{ route('persona.edithome',Auth::user()->id_persona) }}"><i class="ti-user"></i> Mi Perfil</a></li>
                                <li><a href="#"><i class="ti-email"></i> Bandeja de Entrada</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="#"><i class="ti-settings"></i>Configuración de Cuenta</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>

                        @endif



                        <!-- /.dropdown -->
                    </ul>
                </div>
                <!-- /.navbar-header -->
                <!-- /.navbar-top-links -->
                <!-- /.navbar-static-side -->
            </nav>
            <!-- End Top Navigation -->
            <!-- ============================================================== -->
            <!-- Left Sidebar - style you can find in sidebar.scss  -->
            <!-- ============================================================== -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav slimscrollsidebar">
                    <div class="sidebar-head">
                        <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                    <ul class="nav" id="side-menu">

                         <li> <a href="#" class="waves-effect"><i class="mdi mdi-account-card-details fa-fw" data-icon="v"></i> <span class="hide-menu"> Mis Datos <span class="fa arrow"></span> <span class="label label-rouded label-primary pull-right">4</span></span></a>
                            <ul class="nav nav-second-level">
                                 
                                <li><a href="{{ route('persona.edithome',Auth::user()->id_persona) }}"><i class="ti-user"></i> <span class="hide-menu">Mi Información</span></a></li>
                                <li><a href="javascript:void(0)"><i class="ti-email"></i> <span class="hide-menu">Bandeja de Entrada</span></a></li>
                                <li><a href="javascript:void(0)"><i class="ti-settings"></i> <span class="hide-menu">Configuración de Cuenta</span></a></li>
                               <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> <span class="hide-menu">Cerrar Sesión</span></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form></li>
                            </ul>
                        </li>
                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-settings fa-fw" data-icon="v"></i> <span class="hide-menu"> Administrador <span class="fa arrow"></span> <span class="label label-rouded label-primary pull-right">2</span></span></a>
                            <ul class="nav nav-second-level">

                                @can('users.index')
                                <li> <a href="{{ route('users.index') }}"><i class=" fa-fw">U</i><span class="hide-menu">Usuarios</span></a> </li>
                                @endcan
                                @can('roles.index')
                                <li> <a href="{{ route('roles.index') }}"><i class=" fa-fw">R</i><span class="hide-menu">Roles</span></a> </li>
                                @endcan
                            </ul>
                        </li>
                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-clipboard-text fa-fw" data-icon="v"></i> <span class="hide-menu"> Mantenedores <span class="fa arrow"></span> <span class="label label-rouded label-warning pull-right">7</span></span></a>
                            <ul class="nav nav-second-level">
                                @can('notarias.index')
                                <li> <a href="{{ route('notarias.index') }}"><i class=" fa-fw">N</i><span class="hide-menu">Notaria</span></a> </li>
                                @endcan
                                @can('condicion.index')
                                <li> <a href="{{ route('condicion.index') }}"><i class=" fa-fw">C</i><span class="hide-menu">Condición</span></a> </li>
                                @endcan
                                @can('inmueble.index')
                                <li> <a href="{{ route('inmueble.index') }}"><i class=" fa-fw">I</i><span class="hide-menu">Inmueble</span></a> </li>
                                @endcan
                                @can('persona.index')
                                <li> <a href="{{ route('persona.index') }}"><i class=" fa-fw">P</i><span class="hide-menu">Personas</span></a> </li>
                                @endcan
                                @can('cargo.index')
                                <li> <a href="{{ route('cargo.index') }}"><i class=" fa-fw">C</i><span class="hide-menu">Cargos</span></a> </li>
                                @endcan
                                @can('servicio.index')
                                <li> <a href="{{ route('servicio.index') }}"><i class=" fa-fw">S</i><span class="hide-menu">Servicios</span></a> </li>
                                @endcan
                                @can('multa.index')
                                <li> <a href="{{ route('multa.index') }}"><i class=" fa-fw">M</i><span class="hide-menu">Multas</span></a> </li>
                                @endcan
                                @can('formasDePago.index')
                                <li> <a href="{{ route('formasDePago.index') }}"><i class=" fa-fw">F</i><span class="hide-menu">Formas de Pago</span></a> </li>
                                @endcan
                                @can('comision.index')
                                <li> <a href="{{ route('comision.index') }}"><i class=" fa-fw">C</i><span class="hide-menu">Comisión</span></a> </li>
                                @endcan
                                @can('flexibilidad.index')
                                <li> <a href="{{ route('flexibilidad.index') }}"><i class=" fa-fw">F</i><span class="hide-menu">Flexibilidad</span></a> </li>
                                @endcan
                                @can('personaInmueble.index')
                                <li> <a href="{{ route('personaInmueble.index') }}"><i class=" fa-fw">PI</i><span class="hide-menu">Persona Inmueble</span></a> </li>
                                @endcan
                                @can('correo.index')
                                <li> <a href="{{ route('correo.index') }}"><i class=" fa-fw">C</i><span class="hide-menu">Correo Tipo   </span></a> </li>
                                @endcan
                                @can('portal.index')
                                <li> <a href="{{ route('portal.index') }}"><i class=" fa-fw">P</i><span class="hide-menu">Portal   </span></a> </li>
                                @endcan
                            </ul>
                        </li>
                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-settings fa-fw" data-icon="v"></i> <span class="hide-menu"> Captaciones <span class="fa arrow"></span> <span class="label label-rouded label-primary pull-right">6</span></span></a>
                            <ul class="nav nav-second-level">
                                @can('captacion.index')
                                <li> <a href="{{ route('captacion.index') }}"><i class=" fa-fw">CP</i><span class="hide-menu">Captación de Propietarios</span></a> </li>
                                @endcan
                                @can('captacionArrendador.index')
                                <li> <a href="{{ route('captacionArrendador.index') }}"><i class=" fa-fw">CA</i><span class="hide-menu">Captación de Arrendatarios</span></a> </li>
                                @endcan
                                @can('captacion.index')
                                <li> <a href="{{ route('captacioncorredor.index') }}"><i class=" fa-fw">CC</i><span class="hide-menu">Captación por corredores</span></a> </li>
                                @endcan
                                @can('captacion.index')
                                <li> <a href="{{ route('captacion.importExport') }}"><i class=" fa-fw">PC</i><span class="hide-menu">Proceso de Captación</span></a> </li>
                                @endcan
                                 @can('captacion.index')
                                <li> <a href="{{ route('captacion.reportes') }}"><i class=" fa-fw">RS</i><span class="hide-menu">Reporte de seguimiento</span></a> </li>
                                @endcan
                                @can('primeraGestion.index')
                                <li> <a href="{{ route('primeraGestion.index',1) }}"><i class=" fa-fw">EC</i><span class="hide-menu">Envío de Correos</span></a> </li>
                                @endcan


                            </ul>
                        </li>
                        <li> <a href="#" class="waves-effect"><i class="mdi mdi-settings fa-fw" data-icon="v"></i> <span class="hide-menu"> Administración <span class="fa arrow"></span> <span class="label label-rouded label-primary pull-right">2</span></span></a>
                            <ul class="nav nav-second-level">
                                @can('revisioncomercial.index')
                                <li> <a href="{{ route('revisioninmueble.index') }}"><i class=" fa-fw">CP</i><span class="hide-menu">Revisión Comercial Inmueble</span></a> </li>
                                @endcan
                                @can('revisioncomercial.index')
                                <li> <a href="{{ route('revisionpersona.index') }}"><i class=" fa-fw">CA</i><span class="hide-menu">Revisión Comercial Persona</span></a> </li>
                                @endcan
                            </ul>
                        </li>
                        <li><a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i>
                            Cerrar Sesión</a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form></li>
                        <li class="devider"></li>
                        <li><a href="#" class="waves-effect"><i class="fa fa-circle-o text-danger"></i> <span class="hide-menu">Documentación</span></a></li>
                        <li><a href="#" class="waves-effect"><i class="fa fa-circle-o text-info"></i> <span class="hide-menu">Galería de imágenes</span></a></li>
                        <li><a href="#" class="waves-effect"><i class="fa fa-circle-o text-success"></i> <span class="hide-menu">Preguntas frecuentes</span></a></li>
                    </ul>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Left Sidebar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Page Content -->
            <!-- ============================================================== -->
            <div id="page-wrapper">
                <div class="container-fluid">
                    <br/>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                     @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @yield('contenido')


                    <div class="right-sidebar">
                        <div class="slimscrollright">
                            <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                            <div class="r-panel-body">
                                <ul id="themecolors" class="m-t-20">
                                    <li><b>With Light sidebar</b></li>
                                    <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
                                    <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                    <li><a href="javascript:void(0)" data-theme="gray" class="yellow-theme">3</a></li>
                                    <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                    <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                    <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                    <li class="full-width"><b>With Dark sidebar</b></li>
                                    <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                    <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                    <li><a href="javascript:void(0)" data-theme="gray-dark" class="yellow-dark-theme">9</a></li>
                                    <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                    <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                    <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme working">12</a></li>
                                </ul>
                            
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end right sidebar -->
                    <!-- ============================================================== -->
                </div>
                <!-- /.container-fluid -->
                <footer class="footer text-center"> 2018 &copy; EsquemaWeb </footer>
            </div>
            <!-- ============================================================== -->
            <!-- End Page Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="{{ URL::asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
        <!--slimscroll JavaScript -->
        <script src="{{ URL::asset('js/jquery.slimscroll.js') }}"></script>
        <!--Wave Effects -->
        <script src="{{ URL::asset('js/waves.js') }}"></script>
        <!--Counter js -->
        <script src="{{ URL::asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
        <script src="{{ URL::asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
        <!--Morris JavaScript -->
        <script src="{{ URL::asset('plugins/bower_components/raphael/raphael-min.js') }}"></script>
        <script src="{{ URL::asset('plugins/bower_components/morrisjs/morris.js') }}"></script>
        <!-- Calendar JavaScript -->
        <script src="{{ URL::asset('plugins/bower_components/moment/moment.js') }}"></script>
        <script src="{{ URL::asset('plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
        <script src="{{ URL::asset('plugins/bower_components/calendar/dist/cal-init.js') }}"></script>
        <!-- Custom Theme JavaScript -->
        <script src="{{ URL::asset('js/custom.min.js') }}"></script>
        <script src="{{ URL::asset('js/dashboard1.js') }}"></script>
        <!-- Custom tab JavaScript -->
        <script src="{{ URL::asset('js/cbpFWTabs.js') }}"></script>
        <script type="text/javascript">
                                           (function () {
                                               [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                                                   new CBPFWTabs(el);
                                               });
                                           })();
        </script>
        <script src="{{ URL::asset('plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
        <!--Style Switcher -->
        <script src="{{ URL::asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>


    </body>

</html>
