@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading">UF</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="#" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                                 <h3 class="box-title">Administrador de valores UF</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" placeholder="" required="required" value="{{ $uf->fecha }}" readonly="readonly" > <span class="help-block"> Fecha UF </span> </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label>Valor UF</label>
                                        <input name='valor' type="number" class="form-control" value="{{ $uf->valor }}"> </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <a href="{{ route('uf.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
