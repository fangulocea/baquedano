@extends('admin.layout')

@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Usuario</div>

                <div class="panel-body">                                        
                    <p><strong>Nombre</strong>     {{ $user->name }}</p>
                    <p><strong>Email</strong>      {{ $user->email }}</p>
                </div>
            </div>
                    <a href="{{ route('users.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
        </div>

    </div>
</div>
@endsection