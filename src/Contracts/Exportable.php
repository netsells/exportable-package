<?php

namespace Netsells\Exportable\Contracts;

/**
 * Interface ExportableContract
 * @package Netsells\Exportable\Contracts
 *
 * Interface for classes implementing the ExportablePdf and PortableCsv traits
 * @see https://netsells.atlassian.net/wiki/spaces/CLS/pages/567672833/Exportables
 */
interface ExportableContract
{
    /**
     * Export to PDF format using the export type passed, defaults to stream
     * view hold string ref to view used to compile data and headers to HTML view
     * options used to define PDF options for output
     * exportType stream|output
     *
     * @param String $view
     * @param array  $exportData
     * @param array  $headers
     * @param array  $options
     * @param String $exportType
     * @return Void
     */
    public static function exportToPdf(
        string $view,
        array $exportData,
        array $headers,
        array $options = [],
        string $exportType = 'stream'
    ) : Void;

    /**
     * Compiles data and headers and exports to CSV file
     *
     * @param array $data
     * @param array $headers
     * @return Void
     */
    public static function exportToCsv(array $data, array $headers = []) : Void;

    /**
     * Return closure used by CsvMe for layout of data
     *
     * @param array $data
     * @param array $keys
     * @return \Closure
    */
    public static function getLayoutClosure(array $data, array $keys) : \Closure;

    /**
     * Returns the value of a class constant if defined or null if not
     *
     * @param string $constant
     * @return mixed | null
     */
    public static function getConstant(string $constant);
}
