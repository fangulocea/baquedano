
@foreach($propietarios as $p)

<table>

                
                <tbody>
                    <tr>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Rut / Pasaporte</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->rut }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Nombre</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->nombre }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Apellido Paterno</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->apellido_paterno }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Apellido Materno</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->apellido_materno }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Dirección</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->direccion }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Número</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->numero }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Departamento</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->departamento }}</td>
                    </tr>
                    <tr >
                        <td style="background-color: #F2F4F4;text-align: center">Comuna</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->comuna_nombre  }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Profesión</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->profesion }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Estado Civil</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->estado_civil }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Teléfono</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->telefono }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Email</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->email }}</td>
                    </tr>
                    <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Banco</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->banco }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Tipo Cuenta</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->tipo_cuenta }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Cuenta</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->cuenta }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Titular</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->titular }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Rut Titular</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->rut_titular }}</td>
                    </tr>
                     <tr>
                        <td style="background-color: #F2F4F4;text-align: center">Estado</td>
                        <td style="font-weight: bold;;text-align: left">{{ $p->estado }}</td>
                    </tr>
                </tbody>
            </table>

@endforeach

