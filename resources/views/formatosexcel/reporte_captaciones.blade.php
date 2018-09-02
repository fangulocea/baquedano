
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">ID</th>
        <th style="background-color: #F2F4F4;text-align: center">Tipo</th>
        <th style="background-color: #F2F4F4;text-align: center">Captador Externo</th>
        <th style="background-color: #F2F4F4;text-align: center">Direccion</th>
        <th style="background-color: #F2F4F4;text-align: center">Número</th>
        <th style="background-color: #F2F4F4;text-align: center">Departamento</th>
        <th style="background-color: #F2F4F4;text-align: center">Comuna</th>
        <th style="background-color: #F2F4F4;text-align: center">Propietario</th>
        <th style="background-color: #F2F4F4;text-align: center">Email</th>
        <th style="background-color: #F2F4F4;text-align: center">Teléfono</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha de Publicación</th>
        <th style="background-color: #F2F4F4;text-align: center">Estado</th>
        <th style="background-color: #F2F4F4;text-align: center">Portal</th>
        <th style="background-color: #F2F4F4;text-align: center">Creador</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Creación</th>
        <th style="background-color: #F2F4F4;text-align: center">Tipo Contacto</th>
        <th style="background-color: #F2F4F4;text-align: center">Creador Gestión</th>
        <th style="background-color: #F2F4F4;text-align: center">Cantidad Correos</th>
        <th style="background-color: #F2F4F4;text-align: center">Cantidad Gestiones</th>
    </tr>
    </thead>
    <tbody>
        
@foreach($reporte as $p)
    <tr>
       <td >{{  $p->id_publicacion }} </td>
        <td >{{  $p->tipo }} </td>
        <td >{{  $p->Externo }} </td>
        <td>{{  $p->direccion }} </td>
        <td>{{  $p->numero }} </td>
        <td>{{  $p->departamento }} </td>
        <td>{{  $p->comuna_nombre }} </td>
        <td >{{  $p->Propietario }} </td>
        <td >{{  $p->email }} </td>
        <td >{{  $p->telefono }} </td>
        <td >{{  $p->fecha_publicacion }} </td>
        <td >{{  $p->estado }} </td>
        <td>{{  $p->portal }} </td>
        <td >{{  $p->Creador }} </td>
        <td >{{  $p->fecha_creacion }} </td>
        <td >{{  $p->ultimo_tipo_contacto }} </td>
        <td >{{  $p->creador_gestion }} </td>
        <td >{{  $p->cantCorreos }} </td>
        <td >{{  $p->cantGes }} </td>
       </tr>
@endforeach
        

    </tbody>
</table>