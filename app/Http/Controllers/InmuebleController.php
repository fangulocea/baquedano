<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inmueble;
use App\Condicion;
use App\Region;
use Illuminate\Database\Query\Builder;
use DB;



class InmuebleController extends Controller
{

    public function getInmuebles($text){
        $inmuebles=Inmueble::inmuebles($text);
        return response()->json($inmuebles);
        
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {
            $inm = DB::table('inmuebles')->join('comunas', 'inmuebles.id_comuna', '=', 'comunas.comuna_id')->get();

            return view('inmueble.index',compact('inm'));
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $regiones=Region::pluck('region_nombre','region_id');
        return view('inmueble.create',compact('regiones'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $inmueble = Inmueble::create($request->all());

        return redirect()->route('inmueble.index', $inmueble->id)
        ->with('status', 'Inmueble guardado con éxito');
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
        $inmueble = Inmueble::find($id);

        return view('inmueble.show',compact('inmueble','regiones'));
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
        $inmueble = Inmueble::find($id);

        return view('inmueble.edit',compact('inmueble','regiones'));
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
        $data = request()->except(['_token']);
        $inmueble = Inmueble::whereId($id)->update($data);

        return redirect()->route('inmueble.index', $id)
        ->with('status', 'Notaria guardada con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inmueble::find($id)->update(['estado' => 0]);
        return back()->with('status', 'registro No Vigente');        
    }
}