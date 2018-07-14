

<h4>Propietario:  {{  $header->Propietario }}</h4>
<h4>Contacto: {{ $header->Creador }}</h4>
<table id='headpropuesta1' name='headpropuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center">Propiedad</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Contrato</th>
        <th style="background-color: #F2F4F4;text-align: center">Cantidad Meses</th>
        <th style="background-color: #F2F4F4;text-align: center">Fecha Creación</th>
        <th style="background-color: #F2F4F4;text-align: center">Descuento</th>
        <th style="background-color: #F2F4F4;text-align: center">Nro. Cuotas</th>
        <th style="background-color: #F2F4F4;text-align: center">% Cobro Mensual</th>
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
    </tr>
    </tbody>
</table>
@php 
$fila1=$propuesta1->where("idtipopago",'=',1);
@endphp
<table id='propuesta1' name='propuesta1'>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4;text-align: center"><h3>Propuesta 1 : 1 Cuota </h3></th>
@foreach($fila1 as $p)
    <th style="background-color: #F2F4F4;text-align: center">{{  $meses[$p->mes] }}/{{ $p->anio }}</th>
@endforeach
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="background-color: #F2F4F4;text-align: center"><strong>Canon de Arriendo</strong></td>
@foreach($fila1 as $p)
       <td style="background-color: #F2F4F4;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>
@for ($i = 2; $i < 10; $i++)
    @php 
        $fila=$propuesta1->where("idtipopago",'=',$i);

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
$fila20=$propuesta1->where("idtipopago",'=',20);
@endphp
        <tr>
            <td style="background-color: #F6DDCC;text-align: center"><strong>Total Costos Propietario</strong></td>
@foreach($fila20 as $p)
       <td style="background-color: #F6DDCC;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

<tr></tr>
@php 
$fila21=$propuesta1->where("idtipopago",'=',21);
@endphp
        <tr>
            <td style="background-color: #D5F5E3;text-align: center"><strong>Saldo a depositar</strong></td>
@foreach($fila21 as $p)
       <td style="background-color: #D5F5E3;text-align: center">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

    </tbody>
</table>

