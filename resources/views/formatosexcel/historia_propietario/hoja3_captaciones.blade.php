
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">ID</th>
        <th style="background-color: #F2F4F4;text-align: center">Tipo</th>
        <th style="background-color: #F2F4F4;text-align: center">Direccion</th>
        <th style="background-color: #F2F4F4;text-align: center">Comuna</th>
        <th style="background-color: #F2F4F4;text-align: center">Propietario</th>
        <th style="background-color: #F2F4F4;text-align: center">Email</th>
        <th style="background-color: #F2F4F4;text-align: center">Teléfono</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha de Publicación</th>
        <th style="background-color: #F2F4F4;text-align: center">Tipo Contacto</th>
        <th style="background-color: #F2F4F4;text-align: center">Creador Gestión</th>
        <th style="background-color: #F2F4F4;text-align: center">Estado</th>
        <th style="background-color: #F2F4F4;text-align: center">Portal</th>
        <th style="background-color: #F2F4F4;text-align: center">URL</th>
         <th style="background-color: #F2F4F4;text-align: center">Código Publicación</th>
        <th style="background-color: #F2F4F4;text-align: center">Creador</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Creación</th>
    </tr>
    </thead>
    <tbody>
        
@foreach($captaciones as $p)
    <tr>
       <td >{{  $p->id_publicacion }} </td>
        <td >{{  $p->tipo }} </td>
        <td>{{  $p->Direccion }} </td>
        <td>{{  $p->comuna_nombre }} </td>
        <td >{{  $p->Propietario }} </td>
        <td >{{  $p->email }} </td>
        <td >{{  $p->telefono }} </td>
        <td >{{  $p->fecha_publicacion }} </td>
        <td >{{  $p->tipo_contacto }} </td>
        <td >{{  $p->creador_gestion }} </td>
        <td >{{  $p->id_estado }} </td>
        <td>{{  $p->portal }} </td>
        <td>{{  $p->url }} </td>
        <td>{{  $p->codigo_publicacion }} </td>
        <td >{{  $p->Creador }} </td>
        <td >{{  $p->fecha_creacion }} </td>
       </tr>
@endforeach
        

    </tbody>
</table>