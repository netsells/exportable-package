<?php

namespace Netsells\Exportable\Traits;

use \Dompdf\Dompdf;

/**
 * Trait ExportablePDF
 * Allows class to set options and export as PDF
 *
 * @package Netsells\Exportable\Traits
 * @see https://github.com/dompdf/dompdf  DomPdf
 * @see https://github.com/dompdf/dompdf/blob/master/src/Options.php  DomPdf Options
 * @see https://netsells.atlassian.net/wiki/spaces/CLS/pages/567672833/Exportables
 */
trait ExportablePdf
{
    protected static $defaultOptions = [
        'defaultPaperOrientation' => 'portrait',
        'defaultPaperSize' => 'A4',
    ];

    public static function exportPdf(String $content, array $options = [], $function = 'stream')
    {
        if (empty($options)) {
            $options = static::$defaultOptions;
        }

        // Add CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $pdf = new Dompdf($options);
        $pdf->loadHtml($content);
        $pdf->render();
        $pdf->$function();
    }
}
