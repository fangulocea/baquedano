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
        <link href="{{ URL::asset('css/style_contact.css') }}" rel="stylesheet">
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

    <body class="fix-header show-sidebar hide-sidebar content-wrapper">
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
                        <a class="logo" href="{{ route('home_propietario') }}">
                          <img src="{{ URL::asset('plugins/images/logo-Baquedano-small.png') }}" width="80" height="50" alt="home" class="dark-logo" /><!--This is light logo icon--><img src="{{ URL::asset('plugins/images/logo-Baquedano-small.png') }}" alt="home" class="light-logo" width="80" height="50" />

                             </a>

                    </div>
                    
                    <ul class="nav navbar-top-links navbar-left">
                        <center>
                            <a class="logo" href="{{ route('home_propietario') }}">
                    <img class="img-responsive mb-lg hidden-xs hidden-sm" alt="baquedano rentas" width="300" height="200" src="{{ URL::asset('plugins/images/subpropietario.png') }}" > </a>
                </center>
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                       

                        @if (Auth::guest())
                        <li><a href="{{ route('login_propietario') }}">Login</a></li>
                        @else

                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="{{ URL::asset('plugins/images/users/baquedano.png') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }} </b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-img"><img src="{{ URL::asset('plugins/images/users/baquedano.png') }}" alt="user" /></div>
                                        <div class="u-text">
                                            <h4>{{ Auth::user()->name }}</h4>
                                            <p class="text-muted">{{ Auth::user()->email }}</p></div>
                                    </div>
                                </li>
                                <li><a href="{{ route('cambiopassword_form_prop') }}"><i class="ti-settings"></i>Cambiar Contraseña</a></li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <a 
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    </form>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>

                        @endif



                        <!-- /.dropdown -->
                    </ul>
                </div>
            </nav>

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


                    
                </div>
                
                <!-- /.container-fluid -->
                <footer class="footer text-center">  <span class="ws-nowrap"><i class="icon-location-pin icons"></i> Av. Apoquindo 3669, piso 18, oficina 1801.
                                            Las Condes - Santiago de Chile</span>
                                            <br>2018 &copy; Desarrollado por FAC</footer>
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
