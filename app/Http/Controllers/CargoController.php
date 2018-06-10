<?php

namespace App\Http\Controllers;

use App\Cargo;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;

class CargoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cargo = DB::table('cargos')
        ->Where('cargos.id','<>',1)
        ->get();

        return view('cargo.index',compact('cargo'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cargo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('cargos')
        ->Where('cargos.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $cargo = Cargo::create($request->all());
            return redirect()->route('cargo.index', $cargo->id)
            ->with('status', 'Cargo guardado con éxito');  }
        else
        {   return redirect()->route('cargo.index')
            ->with('error', 'Cargo Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cargo = Cargo::where('id', $id)->first();

        return view('cargo.show', compact('cargo', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cargo = Cargo::where('id', $id)->first();

        return view('cargo.edit', compact('cargo', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('cargos')
        ->Where('cargos.nombre','=',$request->nombre)
        ->Where('cargos.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $cargo = Cargo::whereId($id)->update($data);

            return redirect()->route('cargo.index', $id)
            ->with('status', 'Cargo guardada con éxito');  }
        else
        {   return redirect()->route('cargo.index')
            ->with('error', 'Cargo Ya Existe, no se puede ingresar');  }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cargo::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
