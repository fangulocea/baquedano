@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Editar UF</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('uf.update', $uf->id) }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                          <input type="hidden" name="id_modificador" value="{{ Auth::user()->id}}">
                                    <div class="form-body">
                            <h3 class="box-title">Administrador de valores UF</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">Fecha</label>
                                        <input type="date" name="fecha" class="form-control" placeholder="" required="required" value="{{ $uf->fecha }}" readonly="readonly" > </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Valor UF</label>
                                        <input name='valor' type="number" class="form-control" value="{{ $uf->valor }}"> </div>
                                </div>
                            </div>


                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                            <a href="{{ route('uf.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection