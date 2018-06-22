<?php

namespace App\Http\Controllers;

use App\FormasDePago;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use DB;

class FormasDePagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formas = FormasDePago::all();
        return view('formasDePago.index',compact('formas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formasDePago.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('formasdepagos')
        ->Where('formasdepagos.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $formas = FormasDePago::create($request->all());
        return redirect()->route('formasDePago.index', $formas->id)
            ->with('status', 'Forma de pago guardada con éxito');  }
        else
        {   return redirect()->route('formasDePago.index')
            ->with('error', 'Forma de pago Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FormasDePago  $formasDePago
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formas = FormasDePago::where('id', $id)->first();

        return view('formasDePago.show', compact('formas', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FormasDePago  $formasDePago
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $formas = FormasDePago::where('id', $id)->first();

        return view('formasDePago.edit', compact('formas', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FormasDePago  $formasDePago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('formasdepagos')
        ->Where('formasdepagos.nombre','=',$request->nombre)
        ->Where('formasdepagos.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $formas = FormasDePago::whereId($id)->update($data);

            return redirect()->route('formasDePago.index', $id)
            ->with('status', 'Forma de Pago guardada con éxito');  }
        else
        {   return redirect()->route('formasDePago.index')
            ->with('error', 'Forma de pago Ya Existe, no se puede ingresar');  }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FormasDePago  $formasDePago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        FormasDePago::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
