
<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title>Login - Baquedano Renta</title>
<!-- Bootstrap Core CSS -->
 <link rel="stylesheet" href="{{ URL::asset('bootstrap/dist/css/bootstrap.min.css') }}">
<!-- animation CSS -->
       <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
<!-- color CSS -->
<link href="{{ URL::asset('css/colors/blue.css') }}" id="theme"  rel="stylesheet">

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register" >
  <div class="login-box login-sidebar">
    <div class="white-box">
      <form class="form-horizontal form-material" id="loginform" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <a href="javascript:void(0)" class="text-center db"><img src="plugins/images/logo-Baquedano-small.png" alt="Home" width="130" height="100" /></a>  
        
        <div class="form-group m-t-40">
          <div class="col-xs-12">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"></label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Correo Electrónico">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"></label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Contraseña">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary pull-left p-t-0">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="checkbox-signup"> Recordar su ingreso</label>
            </div>
            <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Olvidó su Contraseña?</a> </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Acceder a Baquedano Rentas</button>
          </div>
        </div>
 
      </form>
      
    </div>
  </div>
</section>
<!-- jQuery -->
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/custom.min.js"></script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>