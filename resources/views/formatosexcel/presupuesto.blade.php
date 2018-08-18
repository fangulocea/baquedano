

<table id='head' name='head'>
    <tbody>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Fecha Creación</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->fecha_creacion }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Propiedad</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->propiedad }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>ropietario</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->propietario }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Arrendatario</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->arrendatario }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Creador</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->creador }}%</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Responsable del Pago</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->responsable }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Fecha Contrato</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->fecha_contrato }}%</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Cantidad Meses</h3></td>
        <td style="background-color: #F2F4F4;">{{ $header->meses }}</td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Total</h3></td>
        <td style="background-color: #F2F4F4;"><h3>{{ $header->total }}</h3></td>
    </tr>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center"><h3>Estado</h3></td>
        <td style="background-color: #F2F4F4;"><h3>{{ $header->estado }}</h3></td>
    </tr>
    </tbody>
</table>
<br>
<h3>PRESUPUESTO DE REPARACIONES Y LIMPIEZA NÚMERO {{ $header->id }}</h3>
<br>
<table id='detalle' name='detalle'>
    <thead>
    <tr>
            <th style="background-color: #F2F4F4;text-align: center"><h3>Proveedor</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>Familia de Materiales</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>Item de Materiales</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>C/U $ Proveedor</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>C/U $ Baquedano</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>Cantidad</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>$ Proveedor</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>$ Baquedano</h3></th>
            <th style="background-color: #F2F4F4;text-align: center"><h3>$ Subtotal</h3></th>
    </tr>
    </thead>
    <tbody>
        
@foreach($detalle as $d)
<tr>
       <td>{{ $d->proveedor }} </td>
       <td>{{ $d->familia }} </td>
       <td>{{ $d->item }} </td>
       <td>{{ $d->valor_unitario_proveedor }} </td>
       <td>{{ $d->valor_unitario_baquedano }} </td>
       <td>{{ $d->cantidad }} </td>
       <td>{{ $d->monto_baquedano }} </td>
       <td>{{ $d->monto_proveedor }} </td>
       <td><h3>{{ $d->subtotal }}</h3> </td>
</tr>
@endforeach
 <tr>
       <td></td>
       <td> </td>
       <td> </td>
       <td> </td>
       <td></td>
       <td> </td>
       <td> </td>
       <td> </td>
       <td><h3>{{ $totalpesos }}</h3> </td>
</tr>
    </tbody>
</table>

