<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Region;
use Illuminate\Database\Query\Builder;
use DB;

class NotariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $notarias =DB::table('notarias')
        ->join('comunas', 'notarias.id_comuna', '=', 'comunas.comuna_id')
        ->whereNull('notarias.deleted_at')
        ->get();

        return view('notaria.index', compact('notarias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $regiones=Region::pluck('region_nombre','region_id');
        
        return view('notaria.create',compact('regiones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('notarias')
        ->Where('notarias.razonsocial','=',$request->razonsocial)
        ->count();

        if($valida == 0)
        {   $notaria = Notaria::create($request->all());
            return redirect()->route('notarias.index')
            ->with('status', 'Notaria guardada con éxito');  }
        else
        {   return redirect()->route('notarias.index')
            ->with('error', 'Notaria Ya Existe, no se puede ingresar');  }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $regiones=Region::pluck('region_nombre','region_id');
        $_notaria = Notaria::find($id);

        return view('notaria.show',compact('_notaria','regiones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regiones=Region::pluck('region_nombre','region_id');
        $_notaria = Notaria::find($id);

        return view('notaria.edit', compact('_notaria','regiones'));
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
        $valida = DB::table('notarias')
        ->Where('notarias.razonsocial','=',$request->razonsocial)
        ->Where('notarias.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $notaria = Notaria::whereId($id)->update($data);

            return redirect()->route('notarias.index', $id)
            ->with('status', 'Notaria guardada con éxito');  }
        else
        {   return redirect()->route('notarias.index')
            ->with('error', 'Notaria Ya Existe, no se puede ingresar');  }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notaria::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
