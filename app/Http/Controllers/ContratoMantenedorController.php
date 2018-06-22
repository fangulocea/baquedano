<?php

namespace App\Http\Controllers;

use App\ContratoMantenedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ContratoMantenedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contrato = ContratoMantenedor::all();
        return view('contrato.index',compact('contrato'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contrato.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('contratos')
        ->Where('contratos.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $contrato = ContratoMantenedor::create($request->all());
        return redirect()->route('contrato.index')
            ->with('status', 'Contrato guardado con éxito');  }
        else
        {   return redirect()->route('contrato.index')
            ->with('error', 'Contrato Ya Existe, no se puede ingresar');  }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\ContratoMantenedor  $contratoMantenedor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contrato = ContratoMantenedor::where('id', $id)->first();

        return view('contrato.show', compact('contrato', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ContratoMantenedor  $contratoMantenedor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contrato = ContratoMantenedor::where('id', $id)->first();

        return view('contrato.edit', compact('contrato', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ContratoMantenedor  $contratoMantenedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('contratos')
        ->Where('contratos.nombre','=',$request->nombre)
        ->Where('contratos.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
        $contrato = ContratoMantenedor::whereId($id)->update($data);

        return redirect()->route('contrato.index', $id)
            ->with('status', 'Contrato guardado con éxito');  }
        else
        {   return redirect()->route('contrato.index', $id)
            ->with('error', 'Contrato Ya Existe, no se puede ingresar');  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ContratoMantenedor  $contratoMantenedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ContratoMantenedor::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
