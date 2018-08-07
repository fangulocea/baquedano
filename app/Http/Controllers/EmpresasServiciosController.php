<?php

namespace App\Http\Controllers;

use App\EmpresasServicios;
use Illuminate\Http\Request;
use DB;

class EmpresasServiciosController extends Controller
{/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $flex = DB::table('post_empresasservicios')
        ->Where('post_empresasservicios.id_estado','<>',0)
        ->get();
        return view('empresasservicios.index',compact('flex'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empresasservicios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('post_empresasservicios')
        ->Where('post_empresasservicios.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $flex = EmpresasServicios::create($request->all());
        return redirect()->route('empresas.index', $flex->id)
            ->with('status', 'Empresa guardada con éxito');  }
        else
        {   return redirect()->route('empresas.index')
            ->with('error', 'Empresa Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $flex = EmpresasServicios::where('id', $id)->first();

        return view('empresasservicios.show', compact('flex', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flex = EmpresasServicios::where('id', $id)->first();

        return view('empresasservicios.edit', compact('flex', 'id'));
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
        $valida = DB::table('post_empresasservicios')
        ->Where('post_empresasservicios.nombre','=',$request->nombre)
        ->Where('post_empresasservicios.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $flex = EmpresasServicios::whereId($id)->update($data);

            return redirect()->route('empresas.index', $id)
            ->with('status', 'Empresa guardada con éxito');  }
        else
        {   return redirect()->route('empresas.index')
            ->with('error', 'Empresa Ya Existe, no se puede ingresar');  }        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Flexibilidad  $flexibilidad
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        EmpresasServicios::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
