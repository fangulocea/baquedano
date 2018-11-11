
@extends('admin.arrendatario')


@section('contenido')


<div class="responsive">

    <div class="row" style="padding-top: 100px">
        <div class="col-sm-12">
            <div class="white-box" >
                        <div class="table-responsive">
                        <table class="table table-bordered" >
                            <thead>
                                <tr>

                                    <th>Dirección</th>
                                    <th>Tipo de Documento</th>
                                    <th>Bajar Archivo</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($docs as $pi)
                                <tr>
                                    <td><center>{{ $pi->direccion }}</center></td>
                                    <td><b>{{ $pi->tipo }}</b></td>
                                    <td> 
                                        <center>
                                            <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">
                                                <button type="button" class="btn btn-info btn-circle btn-lg">
                                                    <i class="fa fa-cloud-download"></i> 
                                                </button>
                                            </a>
                                        </center>
                                     </td>

                            
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                        <div class="form-actions">
                                <center>
                                <a href="{{ route('home_arrendatario') }}" class="btn btn-info" style="color:white"><i class="fa fa-times-circle"></i>&nbsp;&nbsp;Volver</a>
                                </center>
                            </div>
                    </div>

        </div>
    </div>
</div>