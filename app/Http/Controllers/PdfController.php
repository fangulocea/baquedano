<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade as PDF;
use DateTime;

class PdfController extends Controller
{
    public function Index($data) 
    {
        $fecha = DateTime::createFromFormat('d-m-Y', $data->fecha);
        //$fecha = date_format($data->fecha, 'm-d-Y');
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(
            '<!DOCTYPE html>
            <html lang="en">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            </head>
            <body>
            <h1>Contrato Borrador     '. $data->fecha .'</h1>
            <br><br><br>
            <p>Texto del Contrato y parametros pasados.</p>
            <br><br><br>
            <p>Notaria      : '. $data->n_n .'  </p>
            <p>Servicio     : '. $data->n_s .'  </p>
            <p>Flexibilidad : '. $data->n_f .'  </p>
            <p>Comisiones   : '. $data->n_c .'  </p>
            <p>Propietario   : '. $data->propietario .' Rut: '. $data->rut_p .' Dirección '. $data->direccion_p .' N° '. $data->numero_p .' Comuna: '. $data->comuna_p .' </p>
            <p>inmueble   : '. $data->direccion_i .' N° '. $data->numero_i .'   Comuna: '. $data->comuna_i .'    Departamento: '. $data->depto_i .'    Dormitorios '. $data->dormitorio .'    Baño '. $data->bano .'    Estacionamiento '. $data->bodega .'    Piscina ' . $data->piscina . '    Precio: '. $data->precio .'    Gastos Comunes: '. $data->gastosComunes .' </p>
            </body>
            </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i . $data->numero_i .'.pdf' );
        return $pdf->stream();
    }

 

}


