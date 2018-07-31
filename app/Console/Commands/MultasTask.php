<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PagosPropietarios;

class MultasTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'MultasTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generación de Multas';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pago = PagosPropietarios::create([
                        'id_contratofinal' => 1,
                        'gastocomun' => 0,
                         "id_publicacion"    =>  1,
                         "id_inmueble"       =>  1,
                        'E_S' => 'e',
                        'tipopago' => 'cargo',
                        'idtipopago' => 16,
                        'tipopropuesta' => 1,
                        'meses_contrato' => 12,
                        'fecha_iniciocontrato' => '2018-07-01',
                        'dia' => 1,
                        'mes' => 11,
                        'anio' => 2018,
                        'descuento' => 0,
                        'cant_diasmes' => 30,
                        'cant_diasproporcional' => 30,
                        'moneda' => 'CLP',
                        'valormoneda' => 1,
                        'valordia' => 1,
                        'precio_en_moneda' => 10000,
                        'precio_en_pesos' => 10000,
                        'id_creador' => 1,
                        'id_modificador' => 1,
                        'id_estado' => 1,
                        'gastocomun' =>0,
                        'canondearriendo' => 0
            ]);

            Log::info('Task Ejecutado con Exito');
    }
}
