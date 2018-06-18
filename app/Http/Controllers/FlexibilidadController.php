<?php

namespace App\Http\Controllers;

use App\Flexibilidad;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;

class FlexibilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flex = DB::table('flexibilidads')
        ->Where('flexibilidads.id','<>',1)
        ->get();
        return view('flexibilidad.index',compact('flex'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('flexibilidad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('flexibilidads')
        ->Where('flexibilidads.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $flex = Flexibilidad::create($request->all());
        return redirect()->route('flexibilidad.index', $flex->id)
            ->with('status', 'Flexibilidad guardada con éxito');  }
        else
        {   return redirect()->route('flexibilidad.index')
            ->with('error', 'Flexibilidad Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flex = Flexibilidad::where('id', $id)->first();

        return view('flexibilidad.show', compact('flex', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flex = Flexibilidad::where('id', $id)->first();

        return view('flexibilidad.edit', compact('flex', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('flexibilidads')
        ->Where('flexibilidads.nombre','=',$request->nombre)
        ->Where('flexibilidads.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $flex = Flexibilidad::whereId($id)->update($data);

            return redirect()->route('flexibilidad.index', $id)
            ->with('status', 'Flexibilidad guardada con éxito');  }
        else
        {   return redirect()->route('flexibilidad.index')
            ->with('error', 'Flexibilidad Ya Existe, no se puede ingresar');  }        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Flexibilidad::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
