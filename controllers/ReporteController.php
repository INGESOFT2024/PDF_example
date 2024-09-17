<?php

namespace Controllers;

use Mpdf\Mpdf;
use Model\ActiveRecord;
use MVC\Router;

class ReporteController {
    public static function pdf(Router $router)
    {

        $mpdf = new Mpdf(
            [
                'default_font_size' => '12',
                'default_font' => 'arial',
                'orientation' => 'p',
                'margin_top' => '30',
                'format' => 'Letter',
                //'format' => [35,45],
            ]
            );

        $sql = ActiveRecord::fetchArray("SELECT * FROM productos");
        $resultado = $sql;

        $html = $router->load('pdf/reporte',[
            'resultado' => $resultado
        ]);

        $header = $router->load('pdf/header', []);
        $footer = $router->load('pdf/footer', []);
        $css = $router->load('pdf/style', []);

        $mpdf->SetHTMLHeader($header);
        $mpdf->SetHTMLFooter($footer);

        $mpdf->WriteHTML($css);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

}