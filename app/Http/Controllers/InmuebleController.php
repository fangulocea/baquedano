<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inmueble;
use App\Condicion;
use App\Region;
use Illuminate\Database\Query\Builder;
use Yajra\Datatables\Datatables;
use DB;



class InmuebleController extends Controller
{


       public function getInmuebleContratoBorrador($id){
        $inmueble=Inmueble::find($id);
        return response()->json($inmueble);
    }


        public function updateInmuebleContratoBorrador(Request $request)
    {
        $id_inmueble=$request->id_inmueble;
        $id_publicacion=$request->id_publicacion;
        $data = request()->except(['_token','id_publicacion','id_inmueble']);
        $inmueble = Inmueble::whereId($id_inmueble)->update($data);
        return redirect()->route('borradorContrato.edit', [$id_publicacion,3])
        ->with('status', 'Inmueble Actualizado con éxito');
    }

        public function updateInmuebleArrendatarioBorrador(Request $request)
    {
        $id_inmueble=$request->id_inmueble;
        $id_persona=$request->id_persona;
        $data = request()->except(['_token','id_inmueble','id_persona','id_publicacion']);
        $inmueble = Inmueble::whereId($id_inmueble)->update($data);
        return redirect()->route('cbararrendatario.edit', [$request->id_publicacion,3])
        ->with('status', 'Inmueble Actualizado con éxito');
    }    

    public function getInmuebles($text){
        $inmuebles=Inmueble::inmuebles($text);
        return response()->json($inmuebles);
        
    }

    public function getInmuebles_modulo($modulo,$text){

        $inmuebles=Inmueble::inmuebles_modulo($text,$modulo);
        return response()->json($inmuebles);
        
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function index()
        {
            
            return view('inmueble.index');
        }


        public function index_ajax()
        {
            $inm = DB::table('inmuebles as i')
            ->join('comunas as c', 'i.id_comuna', '=', 'c.comuna_id')
            ->leftjoin('mensajes as m', function($join){
                 $join->on('m.nombre_modulo', '=',DB::raw("'Inmuebles'"));
                 $join->on('m.id_estado', '=', 'i.estado');
            })
            ->select(DB::raw("i.direccion, i.id, i.numero, i.departamento, i.precio, i.gastosComunes, c.comuna_nombre, m.nombre"))
            ->get();

            return Datatables::of($inm)
         ->addColumn('action', function ($inm) {
                               return  '<a href="/inmueble/'.$inm->id.'/edit"><span class="btn btn-warning btn-circle btn-sm"><i class="ti-pencil-alt"></i></span></a>';
        })
        ->addColumn('id_link', function ($inm) {
                               return  '<a href="/inmueble/'.$inm->id.'/edit"><span class="btn btn-success btn-sm"> '.$inm->id.'</span> </a>';
        })
        ->rawColumns(['id_link','action'])
        ->make(true);
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