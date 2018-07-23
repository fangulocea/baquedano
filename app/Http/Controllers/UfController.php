<?php

namespace App\Http\Controllers;

use App\Uf;
use Illuminate\Http\Request;
use DB;

class UfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ufs = DB::table('adm_uf')
        ->get();

        return view('uf.index',compact('ufs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('uf.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $valida = DB::table('adm_uf')
        ->Where('fecha','=',$request->fecha)
        ->count();

        if($valida == 0)
        {   $uf = Uf::create($request->all());
            return redirect()->route('uf.index', $uf->id)
            ->with('status', 'Uf guardado con éxito');  }
        else
        {   return redirect()->route('cargo.index')
            ->with('error', 'Uf Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uf = Uf::where('id', $id)->first();

        return view('uf.show', compact('uf', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $uf = Uf::where('id', $id)->first();

        return view('uf.edit', compact('uf', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = request()->except(['_token']);
        $uf = Uf::find($id)->update($data);
        return redirect()->route('uf.index', $id)
            ->with('status', 'UF guardada con éxito');  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Uf  $uf
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Uf::find($id)->delete();
        return back()->with('status', 'registro eliminado');
    }
}
