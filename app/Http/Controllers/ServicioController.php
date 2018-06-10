<?php

namespace App\Http\Controllers;

use App\Servicio;
use Illuminate\Http\Request;
use DB;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicio = Servicio::all();
        return view('servicio.index',compact('servicio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicio.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('servicios')
        ->Where('servicios.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $servicio = Servicio::create($request->all());
        return redirect()->route('servicio.index')
            ->with('status', 'Servicio guardado con éxito');  }
        else
        {   return redirect()->route('servicio.index')
            ->with('error', 'Servicio Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $servicio = Servicio::where('id', $id)->first();

        return view('servicio.show', compact('servicio', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $servicio = Servicio::where('id', $id)->first();

        return view('servicio.edit', compact('servicio', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('servicios')
        ->Where('servicios.nombre','=',$request->nombre)
        ->Where('servicios.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
        $servicio = Servicio::whereId($id)->update($data);

        return redirect()->route('servicio.index', $id)
            ->with('status', 'Servicio guardado con éxito');  }
        else
        {   return redirect()->route('servicio.index')
            ->with('error', 'Servicio Ya Existe, no se puede ingresar');  }


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicio::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
