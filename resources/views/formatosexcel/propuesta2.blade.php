<h4>Propietario:  {{  $header->Propietario }}</h4>
<h4>Contacto: {{ $header->Creador }}</h4>

<table >
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">Garantía</th>
    </tr>
    </thead>
    <tbody>
@php 
$fila21=$propuesta2->where("idtipopago",'=',11);
@endphp
        
@foreach($fila21 as $p)
<tr>
       <td style="background-color: #D5F5E3;text-align: center">{{  $p->precio_en_pesos }} </td>
</tr>
@endforeach
        </tbody>
    </table>
<table id='headpropuesta2' name='headpropuesta2'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">Propiedad</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Contrato</th>
        <th style="background-color: #F2F4F4;text-align: center">Cantidad Meses</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Creación</th>
        <th style="background-color: #F2F4F4;text-align: center">Descuento</th>
        <th style="background-color: #F2F4F4;text-align: center">Nro. Cuotas</th>
        <th style="background-color: #F2F4F4;text-align: center">% Cobro Mensual</th>
        <th style="background-color: #F2F4F4;text-align: center">Canon de Arriendo</th>
        <th style="background-color: #F2F4F4;text-align: center">Moneda</th>
        <th style="background-color: #F2F4F4;text-align: center">Valor Moneda</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->propiedad }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->fecha_iniciocontrato }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->meses_contrato }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->fecha_creacion }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->descuento }}%</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->nrocuotas }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->cobromensual }}%</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->canondearriendo }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->moneda }}</td>
        <td style="background-color: #F2F4F4;text-align: center">{{ $header->valormoneda }}</td>
    </tr>
    </tbody>
</table>
@php 
$fila1=$propuesta2->where("idtipopago",'=',1);
@endphp
<table id='propuesta2' name='propuesta2'>
    <thead>
    <tr>
        <th><h3>Propuesta 2: PIE + {{ $header->nrocuotas }} CUOTAS</h3></th>
@foreach($fila1 as $p)
    <th style="background-color: #F2F4F4;text-align: center">{{  $meses[$p->mes] }}/{{ $p->anio }}</th>
@endforeach
    </tr>
    </thead>
    <tbody>
         <tr>
            <td style="background-color: #F2F4F4;text-align: center"><strong>Días del Mes</strong></td>
@foreach($fila1 as $p)
       <td style="background-color: #F2F4F4;text-align: center">{{  $p->cant_diasproporcional }} </td>
@endforeach
        </tr>
        <tr>
            <td style="background-color: #F2F4F4;text-align: center"><strong>Canon de Arriendo</strong></td>
@foreach($fila1 as $p)
       <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>
@for ($i = 2; $i <= 33; $i++)
    @if($i==11)
        @php $i++; @endphp
    @endif
    @php 
        $fila=$propuesta2->where("idtipopago",'=',$i);

    @endphp
    @if(count($fila)>0)

        <tr>
            @php
            $flag=0;
            @endphp
            @foreach($fila as $p)
                @if($flag==0)
                    <td style="background-color: #F2F4F4;text-align: center">{{  $p->tipopago}} </td>
                    <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos }} </td>
                    @php
                    $flag=1;
                    @endphp
                @else
                    <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos }} </td>
                @endif
            @endforeach
        </tr>
    @endif
@endfor
<tr></tr>
@php 
$fila20=$propuesta2->where("idtipopago",'=',34);
@endphp
        <tr>
            <td style="background-color: #F6DDCC;text-align: center"><strong>Total Costos Propietario</strong></td>
@foreach($fila20 as $p)
       <td style="background-color: #F6DDCC;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

<tr></tr>
@php 
$fila21=$propuesta2->where("idtipopago",'=',35);
@endphp
        <tr>
            <td style="background-color: #D5F5E3;text-align: center"><strong>Saldo a depositar</strong></td>
@foreach($fila21 as $p)
       <td style="background-color: #D5F5E3;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>



    </tbody>
</table>