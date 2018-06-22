<?php

namespace App\Http\Controllers;

use App\Multa;
use Illuminate\Http\Request;
use DB;

class MultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $multa = Multa::all();
        return view('multa.index',compact('multa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('multa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('multas')
        ->Where('multas.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $multa = Multa::create($request->all());
        return redirect()->route('multa.index', $multa->id)
            ->with('status', 'Multa guardada con éxito');  }
        else
        {   return redirect()->route('multa.index')
            ->with('error', 'Multa Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $multa = Multa::where('id', $id)->first();

        return view('multa.show', compact('multa', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $multa = Multa::where('id', $id)->first();

        return view('multa.edit', compact('multa', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $valida = DB::table('multas')
        ->Where('multas.nombre','=',$request->nombre)
        ->Where('multas.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $multa = Multa::whereId($id)->update($data);

            return redirect()->route('multa.index', $id)
            ->with('status', 'Multa guardada con éxito');  }
        else
        {   return redirect()->route('multa.index')
            ->with('error', 'Multa Ya Existe, no se puede ingresar');  }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Multa  $multa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Multa::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
