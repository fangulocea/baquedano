<?php

namespace App\Http\Controllers;

use App\Portales;
use Illuminate\Http\Request;
use DB;

class PortalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portal = DB::table('portales')
        ->get();
        return view('portal.index',compact('portal'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('portal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('portales')
        ->Where('portales.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $portal = Portales::create($request->all());
            return redirect()->route('portal.index', $portal->id)
            ->with('status', 'Portal guardado con éxito');  }
        else
        {   return redirect()->route('portal.index')
            ->with('error', 'Portal Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portal = Portales::where('id', $id)->first();

        return view('portal.show', compact('portal', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portal = Portales::where('id', $id)->first();
        return view('portal.edit', compact('portal', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('portales')
        ->Where('portales.nombre','=',$request->nombre)
        ->Where('portales.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $cargo = Portales::whereId($id)->update($data);

            return redirect()->route('portal.index', $id)
            ->with('status', 'Portal guardado con éxito');  }
        else
        {   return redirect()->route('portal.index')
            ->with('error', 'Portal Ya Existe, no se puede ingresar');  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Portal  $portal
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Portales::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
