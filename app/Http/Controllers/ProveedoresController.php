<?php

namespace App\Http\Controllers;

use App\Proveedores;
use Illuminate\Http\Request;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proveedor = Proveedores::all();
        return view('proveedor.index',compact('proveedor'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proveedor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = Proveedores::Where('nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   $proveedor = Proveedores::create($request->all());
        return redirect()->route('proveedor.index', $familia->id)
            ->with('status', 'proveedor guardado con éxito');  }
        else
        {   return redirect()->route('proveedor.index')
            ->with('error', 'Proveedor Ya Existe, no se puede ingresar');  }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedores::find($id);

        return view('proveedor.edit', compact('proveedor', 'id'));
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
            $proveedor = Proveedores::whereId($id)->update($data);

            return redirect()->route('proveedor.index', $id)
            ->with('status', 'proveedor guardado con éxito'); 


        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Proveedores::find($id)->update(['id_estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
