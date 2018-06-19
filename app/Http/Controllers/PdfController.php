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
        $body    = $data->bodyContrato;
        $bodymail=str_replace("{fecha}",$data->fecha,$body);
        $bodymail=str_replace("{profesion}",$data->profesion_p,$bodymail);
        $bodymail=str_replace("{rut}",$data->rut_p,$bodymail);
        $bodymail=str_replace("{domicilioDueno}",$data->direccion_p,$bodymail);
        $bodymail=str_replace("{telefono}",$data->telefono_p,$bodymail);
        $bodymail=str_replace("{deptoDueno}",$data->depto_p,$bodymail);
        $bodymail=str_replace("{comunaDueno}",$data->comuna_p,$bodymail);
        $bodymail=str_replace("{regionDueno}",$data->region_p,$bodymail);
        $bodymail=str_replace("{propietario}",$data->propietario,$bodymail);
        $bodymail=str_replace("{rol}",$data->rol,$bodymail);
        $bodymail=str_replace("{direccionPropiedad}",$data->direccion_i,$bodymail);
        $bodymail=str_replace("{deptoPropiedad}",$data->depto_i,$bodymail);
        $bodymail=str_replace("{comunaPropiedad}",$data->comuna_i,$bodymail);
        $bodymail=str_replace("{dormitorio}",$data->dormitorio,$bodymail);
        $bodymail=str_replace("{bano}",$data->bano,$bodymail);
        // $bodymail=str_replace("{correo}",utf8_decode($_POST['correo']),$bodymail);


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            </head>
            <body>'
            . $bodymail . 
            '</body>
            </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i .'.pdf' );
        return $pdf->stream();
    }

    public function show($data) 
    {
        $body    = $data->bodyContrato;
        $bodymail=str_replace("{fecha}",$data->fecha,$body);
        $bodymail=str_replace("{profesion}",$data->profesion_p,$bodymail);
        $bodymail=str_replace("{rut}",$data->rut_p,$bodymail);
        $bodymail=str_replace("{domicilioDueno}",$data->direccion_p,$bodymail);
        $bodymail=str_replace("{telefono}",$data->telefono_p,$bodymail);
        $bodymail=str_replace("{deptoDueno}",$data->depto_p,$bodymail);
        $bodymail=str_replace("{comunaDueno}",$data->comuna_p,$bodymail);
        $bodymail=str_replace("{regionDueno}",$data->region_p,$bodymail);
        $bodymail=str_replace("{propietario}",$data->propietario,$bodymail);
        $bodymail=str_replace("{rol}",$data->rol,$bodymail);
        $bodymail=str_replace("{direccionPropiedad}",$data->direccion_i,$bodymail);
        $bodymail=str_replace("{deptoPropiedad}",$data->depto_i,$bodymail);
        $bodymail=str_replace("{comunaPropiedad}",$data->comuna_i,$bodymail);
        $bodymail=str_replace("{dormitorio}",$data->dormitorio,$bodymail);
        $bodymail=str_replace("{bano}",$data->bano,$bodymail);
        
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            </head>
            <body>'
            . $bodymail . 
            '</body>
            </html>');
        return $pdf->stream();
    }
 

}


