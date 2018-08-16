<?php

namespace App\Http\Controllers;

use App\FamiliaMateriales;
use Illuminate\Http\Request;

class FamiliaMaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $familia = FamiliaMateriales::all();
        return view('familia.index',compact('familia'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('familia.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = FamiliaMateriales::Where('familia','=',$request->familia)
        ->count();

        if($valida == 0)
        {   $familia = FamiliaMateriales::create($request->all());
        return redirect()->route('familia.index', $familia->id)
            ->with('status', 'familia guardada con éxito');  }
        else
        {   return redirect()->route('familia.index')
            ->with('error', 'Familia Ya Existe, no se puede ingresar');  }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $familia = FamiliaMateriales::find($id);

        return view('familia.edit', compact('familia', 'id'));
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
        $valida = FamiliaMateriales::Where('familia','=',$request->familia)
        ->Where('id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $familia = FamiliaMateriales::whereId($id)->update($data);

            return redirect()->route('familia.index', $id)
            ->with('status', 'Familia guardada con éxito');  }
        else
        {   return redirect()->route('familia.index')
            ->with('error', 'Familia Ya Existe, no se puede ingresar');  }


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FamiliaMateriales::find($id)->update(['id_estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
