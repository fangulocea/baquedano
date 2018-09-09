

<table>

                
                <tbody>
                    <tr>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Dirección</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->direccion }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Número</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->numero }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Departamento</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->departamento }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Comuna</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->comuna_nombre }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Referencia</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->referencia }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Rol</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->rol }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Año Antiguedad</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->anio_antiguedad }}</td>
                    </tr>
                    <tr >
                        <td style="background-color: #F2F4F4;text-align: center">Dormitorios</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->dormitorio  }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Baño</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->bano }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Piscina</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->piscina }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Bodega / Número Bodega</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->bodega }}  {{ $inmueble->nro_bodega }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Estacionamiento / Número Estacionamiento</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->estacionamiento }}  {{ $inmueble->nro_estacionamiento }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Gastos Comunes</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->gastoscomunes }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Canon de Arriendo</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->precio }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Nombre de Edificio</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->edificio }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Nombre Administrador</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->nom_administrador }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Email Administrador</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->email_administrador }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Estado</td>
                        <td style="font-weight: bold;;text-align: left">{{ $inmueble->estado }}</td>
                    </tr>
                </tbody>
            </table>