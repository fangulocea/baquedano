@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Muestra Persona</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    
                        <div class="form-actions">
                            
                            <a href="{{ route('persona.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection