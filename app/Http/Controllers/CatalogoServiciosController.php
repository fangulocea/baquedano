<?php

namespace App\Http\Controllers;

use App\CatalogoServicios;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class CatalogoServiciosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $servicio = CatalogoServicios::all();
        return view('catalogo.index',compact('servicio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
        return view('catalogo.create',compact('uf'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $valida = DB::table('post_catalogoservicios')
        ->Where('post_catalogoservicios.nombre_servicio','=',$request->nombre_servicio)
        ->count();

        if($valida == 0)
        {   
            $valor_en_pesos=$request->valor_en_moneda*$request->valor_moneda;
            $request->merge(['valor_en_pesos'=>  $valor_en_pesos]);
            $request->merge(['fecha_moneda'=>  Carbon::now()->format('Y/m/d')]);
            $CatalogoServicios = CatalogoServicios::create($request->all());

        return redirect()->route('catalogo.index', $CatalogoServicios->id)
            ->with('status', 'Servicio guardado con éxito');  }
        else
        {   return redirect()->route('catalogo.index')
            ->with('error', 'Servicio Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CatalogoServicios  $catalogoServicios
     * @return \Illuminate\Http\Response
     */
    public function show(CatalogoServicios $catalogoServicios)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CatalogoServicios  $catalogoServicios
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {

        $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();
       $servicio = CatalogoServicios::where('id', $id)->first();

        return view('catalogo.edit', compact('servicio', 'id','uf'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CatalogoServicios  $catalogoServicios
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $valida = DB::table('post_catalogoservicios')
        ->Where('nombre_servicio','=',$request->nombre_servicio)
        ->Where('id','<>',$id)
        ->count();

        if($valida == 0)
        {
            $uf = DB::table('adm_uf')
                ->where("fecha", "=", Carbon::now()->format('Y/m/d'))
                ->first();

                if($request->moneda=="UF"){
                    $valor_moneda=$uf->valor;
                }else{
                    $valor_moneda=1;
                }

            $valor_en_pesos=$request->valor_en_moneda*$valor_moneda;
            $request->merge(['valor_moneda'=>  $valor_moneda]);
            $request->merge(['valor_en_pesos'=>  $valor_en_pesos]);
            $request->merge(['fecha_moneda'=>  Carbon::now()->format('Y/m/d')]);
            $data = request()->except(['_token']);
            $CatalogoServicios = CatalogoServicios::whereId($id)->update($data);

            return redirect()->route('catalogo.index', $id)
            ->with('status', 'Servicio guardada con éxito');  }
        else
        {   return redirect()->route('catalogo.index')
            ->with('error', 'Servicio Ya Existe, no se puede ingresar');  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CatalogoServicios  $catalogoServicios
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
              CatalogoServicios::find($id)->update(['id_estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
