    @extends('admin.arrendatario')

@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Cambio de contraseña</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('cambiopassword') }}">
                        {{ csrf_field() }}

                        
                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Contraseña Anterior</label>

                            <div class="col-md-6">
                                <input id='id' name="id" type="hidden" value="{{ Auth::user()->id }}">
                                <input id="anterior" type="password" class="form-control" name="anterior" required>
                            </div>
                        </div>

                       <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Nueva Contraseña</label>

                            <div class="col-md-6">
                                <input id="nueva" type="password" class="form-control" name="nueva" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-md-4 control-label">Confirmar Nueva Contraseña</label>

                            <div class="col-md-6">
                                <input id="repetir" type="password" class="form-control" name="repetir" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection