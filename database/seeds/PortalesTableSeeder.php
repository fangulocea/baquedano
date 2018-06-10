<?php

use Illuminate\Database\Seeder;
use App\Portales;

class PortalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Portales::create([
            'nombre'    => 'www.portalinmobiliario.com',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.elrastro.cl',
            'estado'    => 1,
        ]);
         Portales::create([
            'nombre'    => 'www.propiedades.emol.com',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.yapo.cl',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.mercadolibre.cl',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'emol propiedades',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.economicos.cl',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.goplaceit.com',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'chilepropiedades.cl',
            'estado'    => 1,
        ]);
        Portales::create([
            'nombre'    => 'www.planetapropiedades.com',
            'estado'    => 1,
        ]);
    }
}
