<?php

namespace App\Http\Controllers;

use App\PagosMensualesArrendatarios;
use App\Arrendatario;
use App\Persona;
use DB;
use App\DetallePagosArrendatarios;
use Illuminate\Http\Request;
use Auth;

class PagosMensualesArrendatariosController extends Controller
{

public function volver_pago($id)
    {
        $pago= PagosMensualesArrendatarios::find($id);
      return redirect()->route('finalContratoArr.edit', [$pago->id_publicacion, 0, 0, 5])
                        ->with('status', 'Contrato Final guardado con éxito'); 
    }



    public function ir_al_pago($id)
    {
        $meses = array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $pago= PagosMensualesArrendatarios::find($id);
  
        $publicacion=Arrendatario::find($pago->id_publicacion);
        $persona = Persona::find($publicacion->id_arrendatario);
        $inmueble = DB::table('inmuebles')
        ->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')
        ->where("inmuebles.id","=",$pago->id_inmueble)
        ->first();
        $mes=$meses[$pago->mes];

        $valor_pagado=DetallePagosArrendatarios::where("id_pagomensual","=",$id)->sum("valor_pagado");
 
        $saldo=$pago->pago_a_rentas-$valor_pagado;

        $documentos=DetallePagosArrendatarios::where("id_pagomensual","=",$id)->get();

        return view('finalContratoArr.gestion',compact('pago','persona','inmueble','mes','saldo','valor_pagado','documentos'));
    }


    public function efectuarpago(Request $request, $id){

        if (!isset($request->archivo)) {
            return redirect()->route('pagosarrendatario.ir_al_pago', $id)->with('error', 'Debe seleccionar archivo');
        }

        $destinationPath = 'uploads/docpagosarrendatarios';
        $archivo = rand() . $request->archivo->getClientOriginalName();
        $file = $request->file('archivo');
        $file->move($destinationPath, $archivo);

        $pago= PagosMensualesArrendatarios::find($id);

        $valor_pagado=DetallePagosArrendatarios::where("id_pagomensual","=",$id)->sum("valor_pagado");
        $valor_original=$pago->pago_a_rentas;
        $saldo_actual=$pago->pago_a_rentas-$valor_pagado;
        $saldo=$saldo_actual-$request->monto;

//dd("valor pagado:".$valor_pagado."  valor_original:".$valor_original."    saldo_actual:".$saldo_actual."     saldo: ".$saldo);
        $detalle=DetallePagosArrendatarios::create([
            "id_pagomensual" => $id,
            "fecha_pago"=>$request->fecha_pago,
            "id_publicacion" => $pago->id_publicacion,
            "id_inmueble" => $pago->id_inmueble,
            "valor_original" => $pago->pago_a_rentas,
            "valor_pagado" => $request->monto,
            "saldo_actual" => $saldo_actual,
            "saldo" => $saldo,
            "E_S" => "",
            "id_modificador"=> Auth::user()->id,
            'tipo' => "Pago Mensual",
            'nombre' => $archivo,
            'ruta' => $destinationPath,
            "id_creador"=> Auth::user()->id,
            "id_estado"=> 1
        ]);
        $estado=1;
        if($valor_original>$valor_pagado){
            $estado=2;
        }

        if($saldo<=0){
            $estado=3;
        }



        $pago= PagosMensualesArrendatarios::find($id)->update([
            "id_estado"=> $estado
        ]);


        return redirect()->route('pagosarrendatario.ir_al_pago', $id)->with('status', 'Pago ingresado con exito');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function show(PagosMensualesArrendatarios $pagosMensualesArrendatarios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function edit(PagosMensualesArrendatarios $pagosMensualesArrendatarios)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PagosMensualesArrendatarios $pagosMensualesArrendatarios)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PagosMensualesArrendatarios  $pagosMensualesArrendatarios
     * @return \Illuminate\Http\Response
     */
    public function destroy(PagosMensualesArrendatarios $pagosMensualesArrendatarios)
    {
        //
    }
}
