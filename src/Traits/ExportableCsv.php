<?php

namespace Netsells\Exportable\Traits;

use Netsells\Csvme\Csvme;
use Closure;

/**
 * Trait ExportableCsv
 * Allows class to export data to CSV with headers and layout
 *
 * @package Netsells\Exportable\Traits
 * @see https://github.com/netsells/csvme
 * @see https://netsells.atlassian.net/wiki/spaces/CLS/pages/567672833/Exportables
 */
trait ExportableCsv
{
    public static function exportCsv(array $data, array $headers, Closure $layout)
    {
        $csv = new Csvme();

        // Add CORS headers
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: *");

        $csv->withHeader($headers)
            ->withLayout($layout)
            ->withItems($data)
            ->output();
    }
}
