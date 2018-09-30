<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Caffeinated\Shinobi\Models\Role;
use App\User;
use App\Persona;
use App\Role_User;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
              $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

        public function cambiopassword_form()
    {
        return view('users.password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        return redirect()->route('users.index')
            ->with('status', 'Usuario guardado con éxito');

    }


    public function crear_propietario($id)
    {

         $contrato = DB::table('adm_contratofinal as pg')
                   ->where('pg.id','=',$id)
                   ->first();

        $propietario_propiedad = DB::table('cap_publicaciones as c')
                    ->leftjoin('personas as p', 'c.id_propietario', '=', 'p.id')
                    ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                    ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                    ->where('c.id','=',$contrato->id_publicacion)
                    ->select(DB::raw(' c.id_propietario, p.nombre, p.apellido_paterno, p.apellido_materno, p.email, i.id as id_inmueble, i.direccion, i.numero, co.comuna_nombre as comuna '))
                    ->first(); 

        if($propietario_propiedad->email==''){
            return redirect()->back()->with('error', 'La persona no cuenta con correo eléctornico registrado en el sistema');
        }

        $user = DB::table('users')
                   ->where('email','=',$propietario_propiedad->email)
                   ->first();

        $persona = Persona::find($propietario_propiedad->id_propietario)->update([
            'tipo_cargo' => 'Propietario',
        ]);

        if(count($user)>0){
            return redirect()->back()->with('error', 'El Email tiene cuenta creada en el sistema');
        }



        $role = User::create([
            'name' => $propietario_propiedad->nombre.' '.$propietario_propiedad->apellido_paterno.' '.$propietario_propiedad->apellido_materno,
            'email' => $propietario_propiedad->email,
            'password' => bcrypt('123456'),
        ]);


        $ru=Role_User::create([
            'role_id' => 3,
            'user_id' => $role->id
        ]);
        return redirect()->back()->with('status', 'Se ha creado la cuenta de propietario con éxito, debe ingresar con su Email y contraseña 123456');

    }



     public function crear_arrendatario($id)
    {

         $contrato = DB::table('adm_contratofinalarr as pg')
                   ->where('pg.id','=',$id)
                   ->first();

        $arr_propiedad = DB::table('arrendatarios as c')
                    ->leftjoin('personas as p', 'c.id_arrendatario', '=', 'p.id')
                    ->leftjoin('inmuebles as i', 'c.id_inmueble', '=', 'i.id')
                    ->leftjoin('comunas as co', 'i.id_comuna', '=', 'co.comuna_id')
                    ->where('c.id','=',$contrato->id_publicacion)
                    ->select(DB::raw(' c.id_arrendatario, p.nombre, p.apellido_paterno, p.apellido_materno, p.email, i.id as id_inmueble, i.direccion, i.numero, co.comuna_nombre as comuna '))
                    ->first(); 

        if($arr_propiedad->email==''){
            return redirect()->back()->with('error', 'La persona no cuenta con correo eléctornico registrado en el sistema');
        }

        $user = DB::table('users')
                   ->where('email','=',$arr_propiedad->email)
                   ->first();

        $persona = Persona::find($arr_propiedad->id_arrendatario)->update([
            'tipo_cargo' => 'Arrendatario',
        ]);

        if(count($user)>0){
            return redirect()->back()->with('error', 'El Email tiene cuenta creada en el sistema');
        }



        $role = User::create([
            'name' => $arr_propiedad->nombre.' '.$arr_propiedad->apellido_paterno.' '.$arr_propiedad->apellido_materno,
            'email' => $arr_propiedad->email,
            'password' => bcrypt('123456'),
        ]);


        $ru=Role_User::create([
            'role_id' => 4,
            'user_id' => $role->id
        ]);
        return redirect()->back()->with('status', 'Se ha creado la cuenta de arrendatario con éxito, debe ingresar con su Email y contraseña 123456');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
               $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $user = User::find($id);
        $roles = Role::get();
        return view('users.edit', compact('user', 'roles'));
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
        $user = User::find($id);
        $user->update($request->all());
        $user->roles()->sync($request->get('roles'));
        return redirect()->route('users.index', $user->id)
            ->with('status', 'Usuario guardado con éxito');
    }

   
    public function cambiopassword(Request $request)
    {
        $user = User::find($request['id']);
        if(!Hash::check($request['anterior'], $user->password)){
            return redirect()->back()->with('error', 'La contraseña anterior no concuerda con nuestros registros');
        }


        if($request['nueva']!=$request['repetir']){
            return redirect()->back()->with('error', 'La nueva contraseña no es igual a la confirmación');
        }

        $role = User::find($request['id'])->update([
            'password' => bcrypt($request['nueva'])
        ]);
        return redirect()->route('home')->with('status', 'La contraseña ha sido cambiada con éxito');
    }


       public function reset($id)
    {
        $user = User::find($id);

        $role = User::find($id)->update([
            'password' => bcrypt('123456')
        ]);
        return redirect()->back()->with('status', 'La contraseña ha sido cambiada a 123456 con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
               $user = User::find($id)->delete();
        return back()->with('status', 'Eliminado correctamente');
    }
}
