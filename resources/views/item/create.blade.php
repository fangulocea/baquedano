@extends('admin.layout')

@section('contenido')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-info">
            <div class="panel-heading"> Crear nuevo Item de Materiales</div>
            <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form action="{{ route('item.store') }}" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <h3 class="box-title">Información de  Item de Materiales</h3>
                            <hr>
                            <div class="row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Familia</label>
                                         <select class="form-control" name="id_familia" id="id_familia"  required="required" >
                                            <option value="">Selecione Familia</option>
                                            @foreach($familia as $n)
                                            <option value="{{ $n->id }}">{{ $n->familia }} </option>
                                            @endforeach  
                                        </select>

                                          </div>
                                    </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre del Item de Materiales</label>
                                        <input type="text" name="item" class="form-control" placeholder="" required="required" >  </div>
                                    </div>

                                      <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Estado</label>
                                                <select class="form-control" name="id_estado" required="required">
                                                    <option value="">Seleccione Estado</option>
                                                    <option value="1">Vigente</option>
                                                    <option value="0">No Vigente</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                                    <a href="{{ route('item.index') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Calcelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>

            

      @endsection