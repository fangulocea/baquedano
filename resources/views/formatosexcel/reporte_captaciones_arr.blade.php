
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">ID</th>
        <th style="background-color: #F2F4F4;text-align: center">Direccion</th>
        <th style="background-color: #F2F4F4;text-align: center">Número</th>
        <th style="background-color: #F2F4F4;text-align: center">Departamento</th>
        <th style="background-color: #F2F4F4;text-align: center">Comuna</th>
        <th style="background-color: #F2F4F4;text-align: center">Arrendatario</th>
        <th style="background-color: #F2F4F4;text-align: center">Rut Arrendatario</th>
        <th style="background-color: #F2F4F4;text-align: center">Email</th>
        <th style="background-color: #F2F4F4;text-align: center">Teléfono</th>
        <th style="background-color: #F2F4F4;text-align: center">Aval</th>
        <th style="background-color: #F2F4F4;text-align: center">Rut Aval</th>


        <th style="background-color: #F2F4F4;text-align: center">Estado</th>
        <th style="background-color: #F2F4F4;text-align: center">Creador</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Creación</th>
    </tr>
    </thead>
    <tbody>
        
@foreach($reporte as $p)
    <tr>
       <td >{{  $p->id_publicacion }} </td>
        <td>{{  $p->direccion }} </td>
        <td>{{  $p->numero }} </td>
        <td>{{  $p->departamento }} </td>
        <td>{{  $p->comuna_nombre }} </td>
        <td >{{  $p->Arrendatario }} </td>
        <td >{{  $p->rut_arrendatario }} </td>
        <td >{{  $p->email }} </td>
        <td >{{  $p->telefono }} </td>
        <td >{{  $p->Aval }} </td>
        <td >{{  $p->rut_aval }} </td>
        <td >{{  $p->estado }} </td>
        <td >{{  $p->Creador }} </td>
        <td >{{  $p->fecha_creacion }} </td>
       </tr>
@endforeach
        

    </tbody>
</table>