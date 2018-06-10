<?php

namespace App\Http\Controllers;

use App\Comision;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;

class ComisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comision = Comision::all();
        return view('comision.index',compact('comision'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comision.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('comisiones')
        ->Where('comisiones.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $comision = Comision::create($request->all());
        return redirect()->route('comision.index', $comision->id)
            ->with('status', 'Comisión guardada con éxito');  }
        else
        {   return redirect()->route('comision.index')
            ->with('error', 'Comisión Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comision = Comision::where('id', $id)->first();

        return view('comision.show', compact('comision', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comision = Comision::where('id', $id)->first();

        return view('comision.edit', compact('comision', 'id'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('comisiones')
        ->Where('comisiones.nombre','=',$request->nombre)
        ->Where('comisiones.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $comision = Comision::whereId($id)->update($data);

            return redirect()->route('comision.index', $id)
            ->with('status', 'Comisión guardada con éxito');  }
        else
        {   return redirect()->route('comision.index')
            ->with('error', 'Comisión Ya Existe, no se puede ingresar');  }


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Comision::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
