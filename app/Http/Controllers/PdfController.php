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
        $bodymail=str_replace("{persona}",$data->propietario,$bodymail);
        $bodymail=str_replace("{profesion}",$data->profesion_p,$bodymail);
        $bodymail=str_replace("{rut}",$data->rut_p,$bodymail);
        $bodymail=str_replace("{domicilioPersona}",$data->direccion_p,$bodymail);
        $bodymail=str_replace("{telefono}",$data->telefono_p,$bodymail);
        $bodymail=str_replace("{deptoPersona}",$data->depto_p,$bodymail);
        $bodymail=str_replace("{comunaPersona}",$data->comuna_p,$bodymail);
        $bodymail=str_replace("{regionPersona}",$data->region_p,$bodymail);
        $bodymail=str_replace("{rol}",$data->rol,$bodymail);
        $bodymail=str_replace("{direccionPropiedad}",$data->direccion_i,$bodymail);
        $bodymail=str_replace("{deptoPropiedad}",$data->depto_i,$bodymail);
        $bodymail=str_replace("{comunaPropiedad}",$data->comuna_i,$bodymail);
        $bodymail=str_replace("{dormitorio}",$data->dormitorio,$bodymail);
        $bodymail=str_replace("{bano}",$data->bano,$bodymail);
        // $bodymail=str_replace("{correo}",utf8_decode($_POST['correo']),$bodymail);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('
        <html>
            <head>
                <style>
                    @page {
                        margin: 0cm 0cm;
                    }
                    body {
                        margin-top:    3.5cm;
                        margin-bottom: 1cm;
                        margin-left:   1cm;
                        margin-right:  1cm;
                    }
                    #watermark {
                        position: fixed;
                        bottom:   0px;
                        left:     0px;
                        width:    21.8cm;
                        height:   28cm;
                        z-index:  -1000;
                    }
                </style>
            </head>
            <body>
                <div id="watermark">
                    <img src="borrador.jpg" height="100%" width="100%" />
                </div>
                <main> 
                    '. $bodymail .'
                </main>
            </body>
        </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i .'.pdf' );


        // $pdf->loadHTML('
        //     <!DOCTYPE html>
        //     <html lang="en">
        //     <head>
        //     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        //     </head>
        //     <body>'
        //     . $bodymail . 
        //     '</body>
        //     </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i .'.pdf' );
        return $pdf->stream();
    }


    public function pdfArrendatario($data) 
    {
        $body    = $data->bodyContrato;
        $bodymail=str_replace("{fecha}",$data->fecha,$body);
        $bodymail=str_replace("{persona}",$data->arrendatario,$bodymail);
        $bodymail=str_replace("{profesion}",$data->profesion_p,$bodymail);
        $bodymail=str_replace("{rut}",$data->rut_p,$bodymail);
        $bodymail=str_replace("{domicilioPersona}",$data->direccion_p,$bodymail);
        $bodymail=str_replace("{telefono}",$data->telefono_p,$bodymail);
        $bodymail=str_replace("{deptoPersona}",$data->depto_p,$bodymail);
        $bodymail=str_replace("{comunaPersona}",$data->comuna_p,$bodymail);
        $bodymail=str_replace("{regionPersona}",$data->region_p,$bodymail);
        $bodymail=str_replace("{rol}",$data->rol,$bodymail);
        $bodymail=str_replace("{direccionPropiedad}",$data->direccion_i,$bodymail);
        $bodymail=str_replace("{deptoPropiedad}",$data->depto_i,$bodymail);
        $bodymail=str_replace("{comunaPropiedad}",$data->comuna_i,$bodymail);
        $bodymail=str_replace("{dormitorio}",$data->dormitorio,$bodymail);
        $bodymail=str_replace("{bano}",$data->bano,$bodymail);
        $bodymail=str_replace("{Comisiones}",$data->comision,$bodymail);
        $bodymail=str_replace("{Flexibilidad}",$data->Flexibilidad,$bodymail);
        $bodymail=str_replace("{Servicio}",$data->Servicio,$bodymail);
        $bodymail=str_replace("{FormasDePago}",$data->FormasDePago,$bodymail);
        $bodymail=str_replace("{Multas}",$data->Multas,$bodymail);



        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('
        <html>
            <head>
                <style>
                    @page {
                        margin: 0cm 0cm;
                    }
                    body {
                        margin-top:    3.5cm;
                        margin-bottom: 1cm;
                        margin-left:   1cm;
                        margin-right:  1cm;
                    }
                    #watermark {
                        position: fixed;
                        bottom:   0px;
                        left:     0px;
                        width:    21.8cm;
                        height:   28cm;
                        z-index:  -1000;
                    }
                </style>
            </head>
            <body>
                <div id="watermark">
                    <img src="borrador.jpg" height="100%" width="100%" />
                </div>
                <main> 
                    '. $bodymail .'
                </main>
            </body>
        </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i .'.pdf' );


        // $pdf->loadHTML('
        //     <!DOCTYPE html>
        //     <html lang="en">
        //     <head>
        //     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        //     </head>
        //     <body>'
        //     . $bodymail . 
        //     '</body>
        //     </html>')->save( 'uploads/pdf/'. $data->id . $data->direccion_i .'.pdf' );
        return $pdf->stream();
    }


    public function crontratoFinalPdf($data,$numero) 
    {
        $body    = $data->bodyContrato;
        $bodymail=str_replace("{fecha}",$data->fecha,$body);
        $bodymail=str_replace("{profesion}",$data->profesion_p,$bodymail);
        $bodymail=str_replace("{rut}",$data->rut_p,$bodymail);
        $bodymail=str_replace("{domicilioPersona}",$data->direccion_p,$bodymail);
        $bodymail=str_replace("{telefono}",$data->telefono_p,$bodymail);
        $bodymail=str_replace("{deptoPersona}",$data->depto_p,$bodymail);
        $bodymail=str_replace("{comunaPersona}",$data->comuna_p,$bodymail);
        $bodymail=str_replace("{regionPersona}",$data->region_p,$bodymail);
        $bodymail=str_replace("{persona}",$data->propietario,$bodymail);
        $bodymail=str_replace("{rol}",$data->rol,$bodymail);
        $bodymail=str_replace("{direccionPropiedad}",$data->direccion_i,$bodymail);
        $bodymail=str_replace("{deptoPropiedad}",$data->depto_i,$bodymail);
        $bodymail=str_replace("{comunaPropiedad}",$data->comuna_i,$bodymail);
        $bodymail=str_replace("{dormitorio}",$data->dormitorio,$bodymail);
        $bodymail=str_replace("{bano}",$data->bano,$bodymail);
        // $bodymail=str_replace("{correo}",utf8_decode($_POST['correo']),$bodymail);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('
        <html>
            <head>
                <style>
                    @page {
                        margin: 0cm 0cm;
                    }
                    body {
                        margin-top:    3.5cm;
                        margin-bottom: 1cm;
                        margin-left:   1cm;
                        margin-right:  1cm;
                    }
                    #watermark {
                        position: fixed;
                        bottom:   0px;
                        left:     0px;
                        width:    21.8cm;
                        height:   28cm;
                        z-index:  -1000;
                    }
                </style>
            </head>
            <body>
                <div id="watermark">
                    
                </div>
                <main> 
                    '. $bodymail .'
                </main>
            </body>
        </html>')->save( 'uploads/pdf_final/'. $numero . $data->id . $data->direccion_i .'-FINAL.pdf' );
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


