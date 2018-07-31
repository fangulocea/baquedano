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
                                        <td><center>Moneda  : <?= $pago->moneda ?></center></td>
                                <td align="right">Valor UF HOY : <?= $uf->valor ?></td>
                                <td align="right">Saldo Pendiente  : $ <?= $saldo_moneda ?></td>
                                </tr>
                                </tbody>
                            </table></h3></li> 
                    </li>
                </ul>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <form action="{{ route('pagosarrendatarios.agregarcargo',$pago->id) }}"  method="post" enctype='multipart/form-data' >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="moneda" value="{{ $pago->moneda }}">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Tipo de Operación
                                    ..
                                </label>
                                <select class="form-control" name="tipo" id="tipo" required="required" >
                                    <option value="">Seleccione tipo</option>
                                    <option value="17">Abono</option>
                                    <option value="16">Cargo</option>
                                </select> 

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Monto</label>
                                <div class="input-group"> 
                                    <span class="input-group-addon">$</span>
                                    <input type="hidden" name="id_pagomensual" id="id_pagomensual" value="{{ $pago->id }}">
                                    <input name='monto' id='monto' type="number" class="form-control"   placeholder="$/UF"  required="required"">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Nombre operación</label>
                                <div class="input-group"> 
                                    <input name='nombreoperacion'  id='nombreoperacion' type="text" class="form-control" required="required"">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br/>
                                <label for="input-file-now-custom-1">Autorización del Cargo/Abono</label>
                                <input type="file" id="archivo" name="archivo"  class="dropify" required="required"  /> 
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-md-12" style="text-align: center">
                                <div class="form-actions" >
                                    <br/>
                                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar Operación</button>

                                </div>
                            </div>

                        </div>

                    </form>
                </div>

                <div class="col-md-6">
                    <center><a href="{{ route('PagosMensualesArrendatarios.comprobantedepago',$pago->id) }}" class="btn btn-info" style="color:white">GENERAR LIQUIDACIÓN DE PAGO</a></center><br/>
                    <table id="listusers1" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr><th style="border: 1px solid black;text-align: center">ID</th>
                                <th style="border: 1px solid black;text-align: center">Tipo</th>
                                <th style="border: 1px solid black;text-align: center">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documentos as $pi)
                            <tr>
                                <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                    {{ $pi->id }}
                                </td>
                                <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                    {{ trans_choice('mensajes.tipospagos', $pi->idtipopago) }}
                                </td>
                                <td  width="10px" height="10px" style="border: 1px solid black; text-align: center" >
                                    {{ $pi->precio_en_moneda }}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>



            <br><br><br>


            <a href="{{ route('finalContratoArr.edit',[$pago->id_publicacion,0,0,5]) }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
        </div>

    </div>  
</div>
<script src="{{ URL::asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ URL::asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('plugins/bower_components/dropify/dist/js/dropify.min.js') }}"></script>

<script>
     $("#id_cheque").change(function (event) {
        $.get("/contratofinalArr/cheque/"+this.value+"",function(response,state){
                    $("#monto").val(response.monto);
            });
        

    });
          $("#id_garantia").change(function (event) {
        $.get("/contratofinalArr/garantia/"+this.value+"",function(response,state){
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