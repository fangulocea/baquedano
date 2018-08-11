<?php

namespace App\Http\Controllers;

use App\PostVenta;
use Illuminate\Http\Request;
use App\Persona;
use App\Mensajes;
use DB;

class PostVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('postventa.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = Persona::where('tipo_cargo', '=', 'Corredor - Externo')
                ->Orwhere('tipo_cargo', '=', 'Empleado')
                ->select(DB::raw('id , CONCAT_WS(" ",nombre,apellido_paterno,apellido_materno) as empleado'))
                ->orderby('empleado',"asc")
                ->get();

        $estados = Mensajes::where('nombre_modulo', '=', 'Post Venta')
                 ->select(DB::raw('id_estado , nombre'))
                ->orderby('nombre',"asc")
                ->get();

        return view('postventa.create',compact('empleados','estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function show(PostVenta $postVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(PostVenta $postVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostVenta $postVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PostVenta  $postVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostVenta $postVenta)
    {
        //
    }
}
