<?php

namespace App\Http\Controllers;

use App\ItemMateriales;
use App\FamiliaMateriales;
use Illuminate\Http\Request;
use DB;

class ItemMaterialesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = DB::table('post_itemmateriales as i')
        ->join('post_familiamateriales as f', 'f.id', '=', 'i.id_familia')
      ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Vigencia'"));
                 $join->on('m.id_estado', '=', 'i.id_estado');
            })
 ->select(DB::raw('i.id, i.item, i.id_estado, f.familia, m.nombre as id_estado'))
 ->get();

        return view('item.index',compact('item'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $familia=FamiliaMateriales::all();
        return view('item.create',compact('familia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = ItemMateriales::Where('item','=',$request->item)
        ->where('id_familia',"=",$request->id_familia)
        ->count();

        if($valida == 0)
        {   $item = ItemMateriales::create($request->all());
        return redirect()->route('item.index', $item->id)
            ->with('status', 'Item guardada con éxito');  }
        else
        {   return redirect()->route('familia.index')
            ->with('error', 'Item Ya Existe, no se puede ingresar');  }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $familia=FamiliaMateriales::all();
        $item = ItemMateriales::find($id);

        return view('item.edit', compact('item', 'id','familia'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
             $data = request()->except(['_token']);
            $item = ItemMateriales::whereId($id)->update($data);

            return redirect()->route('item.index', $id)
            ->with('status', 'Item guardada con éxito'); 



        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ItemMateriales::find($id)->update(['id_estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
