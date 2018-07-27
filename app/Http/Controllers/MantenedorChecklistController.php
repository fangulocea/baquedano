<?php

namespace App\Http\Controllers;

use App\MantenedorChecklist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MantenedorChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $check = MantenedorChecklist::all();
        return view('mantenedorchecklist.index',compact('check'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mantenedorchecklist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $valida = DB::table('checklist')
        ->Where('checklist.nombre','=',$request->nombre)
        ->count();

        if($valida == 0)
        {   
            $check = MantenedorChecklist::create($request->all());
            return redirect()->route('mantenedorchecklist.index')
            ->with('status', 'Checklist guardado con éxito');  
        }
        else
        {   
            return redirect()->route('mantenedorchecklist.index')
            ->with('error', 'Checklist Ya Existe, no se puede ingresar');  
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MantenedorChecklist  $mantenedorChecklist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = MantenedorChecklist::where('id', $id)->first();
        return view('mantenedorchecklist.show', compact('check', 'id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MantenedorChecklist  $mantenedorChecklist
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $check = MantenedorChecklist::where('id', $id)->first();
        return view('mantenedorchecklist.edit', compact('check', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MantenedorChecklist  $mantenedorChecklist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $valida = DB::table('checklist')
        ->Where('checklist.nombre','=',$request->nombre)
        ->Where('checklist.id','<>',$id)
        ->count();

        if($valida == 0)
        {   $data = request()->except(['_token']);
            $cond = MantenedorChecklist::whereId($id)->update($data);

            return redirect()->route('mantenedorchecklist.index', $id)
            ->with('status', 'Checklist guardado con éxito');  }
        else
        {   return redirect()->route('mantenedorchecklist.index')
            ->with('error', 'Checklist Ya Existe, no se puede ingresar');  }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MantenedorChecklist  $mantenedorChecklist
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        MantenedorChecklist::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');
    }
}
