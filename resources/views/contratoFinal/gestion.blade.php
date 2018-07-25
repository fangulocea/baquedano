@extends('admin.layout')

@section('contenido')
<link rel="stylesheet" href="{{ URL::asset('plugins/bower_components/dropify/dist/css/dropify.min.css')}}">
<div class="row">
    <div class="col-md-12">
<div class="white-box">


    <div class="col-md-12 col-sm-4 p-20">
                                    <ul class="list-group">
                                        <li class="list-group-item list-group-item-success"><h3 class="box-title m-b-0">INMUEBLE : {{ $inmueble->direccion or null }} # {{ $inmueble->numero or null}} Dpto {{ $inmueble->departamento or null}}, {{ $inmueble->comuna_nombre or null}}</h3></li>
                                        <li class="list-group-item list-group-item-info"><h3 class="box-title m-b-0">PROPIETARIO : {{ $persona->nombre or null}} {{ $persona->apellido_paterno or null}}, Fono : {{ $persona->telefono or null}}, Email: {{ $persona->email or null}}</h3></li>
                                        <li class="list-group-item list-group-item-warning">
                                        <table class="display nowrap" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td><h3 class="box-title m-b-0">MES : {{ $mes }} / {{ $pago->anio }}</h3></td>
                                                    <td><h3 class="box-title m-b-0">ESTADO : {{ trans_choice('mensajes.pagopropietario', $pago->id_estado) }}
                                        </h3></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                            </li>
                                        <li class="list-group-item list-group-item-danger"> <h3 class="box-title m-b-0"><table class="display nowrap" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>Valor Original : $ <?= $pago->pago_propietario_moneda  ?></td>
                                                    <td><center>Moneda  : <?= $pago->moneda ?></center></td>
                                                    <td align="right">Valor UF HOY : <?= $uf->valor ?></td>
                                                </tr>
                                            </tbody>
                                        </table></h3></li> 
                                       <li class="list-group-item list-group-item-default"><h3 class="box-title m-b-0">
                                        <table class="display nowrap" cellspacing="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>Valor en Pesos   : $ <?= round($saldo_pesos)  ?></td>
                                                    <td><center>Valor Pagado   : $ <?= $valor_pagado  ?></center></td>
                                                    <td align="right">Saldo a Pagar  : $ <?= $saldo_moneda  ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        </h3></li> </li>
                                    </ul>
                                </div>

<div class="row">

    <div class="col-md-6">
        <form action="{{ route('pagospropietario.efectuarpago',$pago->id) }}"  method="post" enctype='multipart/form-data' >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <!--  <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione garantía, si desea cancelar</label>
                                <select class="form-control" name="id_garantia" id="id_garantia" >
                                        <option value="">Seleccione garantía</option>
                                        @foreach($garantias as $n)
                                        <option value="{{ $n->id }}">{{ $n->mes }}/{{ $n->ano }} - ${{ $n->valor }}</option>
                                        @endforeach   
                                    </select> 

                    </div>
            </div> -->

            <div class="row">
                    <div class="col-md-12">
                        <label>Seleccione el cheque, si fue ingresado en el contrato</label>
                                <select class="form-control" name="id_cheque" id="id_cheque" >
                                        <option value="">Seleccione cheque</option>
                                        @foreach($cheques as $n)
                                        <option value="{{ $n->id }}">{{ $n->fecha_pago }} - {{ $n->numero }}</option>
                                        @endforeach   
                                    </select> 

                    </div>
            </div>
            <hr>
            <div class="row">
                    <div class="col-md-6">
                        <label>Monto a Pagar</label>
                                                        <div class="input-group"> 
                                                            <span class="input-group-addon">$</span>
                                                            <input type="hidden" name="id_pagomensual" id="id_pagomensual" value="{{ $pago->id }}">
                                                            <input name='monto' id='monto' type="number" class="form-control"   placeholder="$" value="{{ round($saldo_pesos)  }}" required="required"">
                                                        </div>
                                                </div>
                    <div class="col-md-6">
                        <label>Fecha de Pago</label>
                                                        <div class="input-group"> 
                                                            <input name='fecha_pago'  id='fecha_pago' type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" required="required"">
                                                        </div>
                                                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <br/>
                <label for="input-file-now-custom-1">Comprobante de Pago</label>
                                <input type="file" id="archivo" name="archivo"  class="dropify" required="required"  /> 
                </div>
            </div>
            <div class="row">

                <div class="col-md-12" style="text-align: center">
                        <div class="form-actions" >
                            <br/>
                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Pago</button>

                        </div>
                </div>

            </div>
           
        </form>
    </div>

    <div class="col-md-6">
         <center><a href="{{ route('PagosMensualesPropietarios.comprobantedepago',$pago->id) }}" class="btn btn-info" style="color:white">COMPROBANTE DE PAGO</a></center><br/>
             <table id="listusers1" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr><th style="border: 1px solid black;text-align: center">Fecha Pago</th>
                                <th style="border: 1px solid black;text-align: center">Cheque</th>
                                <th style="border: 1px solid black;text-align: center">Detalle</th>
                                <th style="border: 1px solid black;text-align: center">Valor Pagado</th>
                                <th style="border: 1px solid black;text-align: center">Saldo</th>
                                <th style="border: 1px solid black;text-align: center">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documentos as $pi)
                                                        <tr>
                                                            <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                                                {{ $pi->fecha_pago }}
                                                            </td>
                                                             <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                                                {{ $pi->numero }}
                                                            </td>
                                                                 <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                                                {{ $pi->detalle }}
                                                            </td>
                                                            <td  width="10px" height="10px" style="border: 1px solid black;text-align: center" >
                                                                $ {{ number_format($pi->valor_pagado) }}
                                                            </td>
                                                            <td  width="10px" height="10px" style="border: 1px solid black;text-align: center" >
                                                                $ {{ number_format($pi->saldo) }}
                                                            </td>
                                                            <td  width="10px" height="10px" style="border: 1px solid black;text-align: center" >
                                                        <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO {{ $pi->nombre }} </a></center>

                                                            </td>
                                                        </tr>
                            @endforeach

                        </tbody>
                    </table>
    </div>
</div>
        


<br><br><br>

       
<a href="{{ route('finalContrato.edit',[$pago->id_publicacion,0,0,5]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
</div>

    </div>  
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script>
     $("#id_cheque").change(function (event) {
        $.get("/contratofinal/cheque/"+this.value+"",function(response,state){
                    $("#monto").val(response.monto);
            });
        

    });
          $("#id_garantia").change(function (event) {
        $.get("/contratofinal/garantia/"+this.value+"",function(response,state){
                    $("#monto").val(response.valor);
            });
        

    });
            // Basic
        $('.dropify').dropify({
            messages: {
                default: 'Arrastra y suelta un archivo aquí o haz clic',
                replace: 'Arrastra y suelta un archivo o haz clic para reemplazar',
                remove: 'Eliminar',
                error: 'Lo siento, el archivo es demasiado grande'
            }
        });
        // Translated

        // Used events
        var drEvent = $('#input-file-events').dropify();
        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Esta seguro de eliminar  \"" + element.file.name + "\" ?");
        });
        drEvent.on('dropify.afterClear', function(event, element) {
            alert('Archivo Borrado');
        });
        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });
        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
</script>

@endsection