<?php

namespace Netsells\Exportable;

use Netsells\Exportable\Contracts\ExportableContract;
use Netsells\Exportable\Traits\ExportableCsv;
use Netsells\Exportable\Traits\ExportablePdf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;

/**
 * Class ExportableModel
 * @package Netsells\Exportable
 *
 * Extends Illuminate\Database\Eloquent\Model to add export functionality to all DB models extending it
 */
class ExportableModel extends Model implements ExportableContract
{
    use ExportablePdf;
    use ExportableCsv;

    /**
     * Compiles data and headers using view reference and exports as PDF format
     *
     * @param String $view
     * @param array  $exportData
     * @param array  $headers
     * @param array  $options Optional array
     * @param String $exportType Defaults to stream Options stream|output
     * @return Void
     * @see https://github.com/dompdf/dompdf
     * @see https://github.com/dompdf/dompdf/blob/master/src/Options.php
     */
    public static function exportToPdf(
        string $view,
        array $exportData,
        array $headers,
        array $options = [],
        string $exportType = 'stream'
    ) : Void {
        // Compile view with headers and data
        $view = View::make($view, compact('headers', 'exportData'));
        $contents = $view->render();

        static::exportPdf($contents, $options, $exportType);
    }

    /**
     * Compiles data and headers and exports to CSV file
     *
     * @param array $data
     * @param array $headers Optional array
     * @param array $layoutKeys Optional array
     * @return Void
     * @see https://github.com/netsells/csvme
     */
    public static function exportToCsv(array $data, array $headers = [], array $layoutKeys = []) : Void
    {
        if (empty($layoutKeys)) {
            $layoutKeys = array_keys($headers);
        }

        $layout = static::getLayoutClosure($data, $layoutKeys);
        if (empty($headers)) {
            $headers = array_keys($data);
        }
        static::exportCsv($data, $headers, $layout);
    }

    /**
     * Return closure used by CsvMe for layout of data
     *
     * @param array $data
     * @param array $keys
     * @return \Closure
     */
    public static function getLayoutClosure(array $data, array $keys) : \Closure
    {
        return function (array $data) use ($keys) {
            $layout = [];
            foreach ($keys as $index => $key) {
                if (array_key_exists($key, $data)) {
                    $layout[] = $data[$key];
                }
            }

            return $layout;
        };
    }

    /**
     * Returns the value of a class constant if defined or null if not
     *
     * @param string $constant
     * @return mixed | null
     */
    public static function getConstant(string $constant)
    {
        try {
            $reflectionClass = new \ReflectionClass(static::class);
            return $reflectionClass->getConstant($constant);
        } catch (\ReflectionException $exception) {
            return null;
        }
    }
}
