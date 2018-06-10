<?php

namespace App\Http\Controllers;

use App\Correo;
use Illuminate\Http\Request;
use DB;

class CorreoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $correo = Correo::all();
        return view('correo.index',compact('correo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('correo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('correos')
        ->Where('correos.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $correo = Correo::create($request->all());
        return redirect()->route('correo.index', $correo->id)
               ->with('status', 'Correo Tipo guardado con éxito');  }
        else
        {   return redirect()->route('correo.index')
            ->with('error', 'Correo Tipo Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Correo  $correo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $correo = Correo::where('id', $id)->first();
        return view('correo.show', compact('correo', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Correo  $correo
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $correo = Correo::where('id', $id)->first();

        return view('correo.edit', compact('correo', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Correo  $correo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('correos')
        ->Where('correos.nombre','=',$request->nombre)
        ->Where('correos.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $correo = Correo::whereId($id)->update($data);

            return redirect()->route('correo.index', $id)
            ->with('status', 'Correo guardado con éxito');  }
        else
        {   return redirect()->route('correo.index')
            ->with('error', 'Correo Tipo Ya Existe, no se puede ingresar');  }        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Correo  $correo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Correo::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
