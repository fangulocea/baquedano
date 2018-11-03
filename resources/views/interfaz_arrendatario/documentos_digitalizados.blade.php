
@extends('admin.propietario')


@section('contenido')


<div class="responsive">
    <div class="row">
        <div class="col-sm-12">
            <div class="white-box" >

                <div class="col-sm-6">
                    <div class="white-box"> 
                        <table id="ssss"  cellspacing="0" width="100%" style="border: 1px solid black;" >
                            <thead>
                                <tr>

                                    <th><center>Click Ver Documento</center></th>
                            <th><center>Borrar</center></th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($documentos as $pi)
                                <tr>
                                    <td  width="10px" height="10px" style="border: 1px solid black;" >
                            <center>{{ $pi->direccion }}
                                <br/>
                                <b>{{ $pi->tipo }}</b>
                                <br/>
                                <a href="{{ URL::asset($pi->ruta.'/'.$pi->nombre) }}" target="_blank">BAJAR ARCHIVO {{ $pi->nombre }} </a></center>


                            @can('finalContrato.edit')
                            <td width="10px" style="border: 1px solid black;" >
                            <center>
                                <a href="{{ route('finalContrato.eliminarfoto', $pi->id) }}" 
                                   class="btn btn-danger btn-circle btn-lg">
                                    <i class="fa fa-check"></i>
                                </a>
                            </center>
                            </td>
                            @endcan
                            </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>