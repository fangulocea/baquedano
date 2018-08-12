<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Condicion;
use Illuminate\Database\Query\Builder;
use DB;


class CondicionController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $cond = DB::table('condicions')
        ->Where('condicions.id','<>',1)
        ->get();

        return view('condicion.index',compact('cond'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('condicion.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('condicions')
        ->Where('condicions.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $condicion = Condicion::create($request->all());
        return redirect()->route('condicion.index', $condicion->id)
            ->with('status', 'Condicion guardada con éxito');  }
        else
        {   return redirect()->route('condicion.index')
            ->with('error', 'Condicion Ya Existe, no se puede ingresar');  }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cond = Condicion::where('id', $id)->first();

        return view('condicion.show', compact('cond', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cond = Condicion::where('id', $id)->first();

        return view('condicion.edit', compact('cond', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $valida = DB::table('condicions')
        ->Where('condicions.nombre','=',$request->nombre)
        ->Where('condicions.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $cond = Condicion::whereId($id)->update($data);

            return redirect()->route('condicion.index', $id)
            ->with('status', 'Condición guardada con éxito');  }
        else
        {   return redirect()->route('condicion.index')
            ->with('error', 'Condicion Ya Existe, no se puede ingresar');  }

    }

        public function Condicion($id)
    {
        $cond = Notaria::find($id);

        return view('notaria.show',compact('cond'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Condicion::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}