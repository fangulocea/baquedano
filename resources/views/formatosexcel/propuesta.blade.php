<h4>Propietario:  {{  $header->Propietario }}</h4>
<h4>Contacto: {{ $header->Creador }}</h4>
<table>
    <thead>
    <tr>
        <th style="background-color: #F2F4F4">Propiedad</th>
        <th style="background-color: #F2F4F4">Fecha Contrato</th>
        <th style="background-color: #F2F4F4">Cantidad Meses</th>
        <th style="background-color: #F2F4F4">Fecha Creación</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="background-color: #F2F4F4">{{ $header->propiedad }}</td>
        <td style="background-color: #F2F4F4">{{ $header->fecha_iniciocontrato }}</td>
        <td style="background-color: #F2F4F4">{{ $header->meses_contrato }}</td>
        <td style="background-color: #F2F4F4">{{ $header->fecha_creacion }}</td>
    </tr>
    </tbody>
</table>
@php 
$fila1=$propuesta1->where("idtipopago",'=',1);
@endphp
<table>
    <thead>
    <tr>
        <th><h3>Propuesta 1 : 1 Cuota (Descuento {{ $descuento }}%)</h3></th>
@foreach($fila1 as $p)
    <th style="background-color: #F2F4F4">{{  $meses[$p->mes] }}/{{ $p->anio }}</th>
@endforeach
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="background-color: #F2F4F4"><strong>Canon de Arriendo</strong></td>
@foreach($fila1 as $p)
       <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
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
                    <td style="background-color: #F2F4F4">{{  $p->tipopago}} </td>
                    <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
                    @php
                    $flag=1;
                    @endphp
                @else
                    <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
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
            <td style="background-color: #F6DDCC"><strong>Total Costos Propietario</strong></td>
@foreach($fila20 as $p)
       <td style="background-color: #F6DDCC">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

<tr></tr>
@php 
$fila21=$propuesta1->where("idtipopago",'=',21);
@endphp
        <tr>
            <td style="background-color: #D5F5E3"><strong>Saldo a depositar</strong></td>
@foreach($fila21 as $p)
       <td style="background-color: #D5F5E3">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

    </tbody>
</table>

<hr>
<!-- PROPUESTA 2 -->

@php 
$fila1=$propuesta2->where("idtipopago",'=',1);
@endphp
<table>
    <thead>
    <tr>
        <th><h3>Propuesta 2: PIE + 11 CUOTAS (Descuento {{ $descuento }}%)</h3></th>
@foreach($fila1 as $p)
    <th style="background-color: #F2F4F4">{{  $meses[$p->mes] }}/{{ $p->anio }}</th>
@endforeach
    </tr>
    </thead>
    <tbody>
        <tr>
            <td style="background-color: #F2F4F4"><strong>Canon de Arriendo</strong></td>
@foreach($fila1 as $p)
       <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>
@for ($i = 2; $i < 50; $i++)
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
                    <td style="background-color: #F2F4F4">{{  $p->tipopago}} </td>
                    <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
                    @php
                    $flag=1;
                    @endphp
                @else
                    <td style="background-color: #F2F4F4">{{  $p->precio_en_pesos }} </td>
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
            <td style="background-color: #F6DDCC"><strong>Total Costos Propietario</strong></td>
@foreach($fila20 as $p)
       <td style="background-color: #F6DDCC">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>

<tr></tr>
@php 
$fila21=$propuesta1->where("idtipopago",'=',21);
@endphp
        <tr>
            <td style="background-color: #D5F5E3"><strong>Saldo a depositar</strong></td>
@foreach($fila21 as $p)
       <td style="background-color: #D5F5E3">{{  $p->precio_en_pesos }} </td>
@endforeach
        </tr>



    </tbody>
</table>