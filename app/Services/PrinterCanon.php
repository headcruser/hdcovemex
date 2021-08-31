<?php

namespace HelpDesk\Services;

use Illuminate\Support\Collection;

final class PrinterCanon
{
    private const CONDITIONAL_BW = 6;
    protected $_data;

    function __construct(){
    }

    public function read(string $data)
    {
        $this->_data = $data;
    }

    public function render(): string
    {
        if (empty($this->_data)) {
            return '';
        }

        if ($this->validatedBW($this->_data)) {
            return $this->renderBW(
                $this->cleanBnN($this->_data)
            );
        } else {
            return $this->renderColor(
                $this->cleanSlash_Color($this->_data)
            );
        }
    }

    public function toCollection(): Collection
    {
        if (empty($this->_data)) {
            return '';
        }

        $impresiones = null;

        if ($this->validatedBW($this->_data)) {
            $registros = $this->cleanBnN($this->_data);

            $registros_en_negro = $registros->map(function($registro){
                return (object)[
                    'id'    => $registro->id,
                    'negro' => $registro->total,
                    'color' => 0,
                    'total' => $registro->total,
                ];
            });

            $impresiones = $registros_en_negro;
        }

        $impresiones = $this->cleanSlash_Color($this->_data);


        $impresiones_filtradas = $impresiones->filter(function($impresion){
            return $impresion->total > 0;
        });

        return $impresiones_filtradas;
    }

    private function validatedBW(string $data)
    {
        $firstLine = preg_replace('/\t/', ' ', strtok($data, "\n"));
        $rowsTxt = explode(' ', $firstLine);

        return sizeof($rowsTxt) >= self::CONDITIONAL_BW;
    }

    private function cleanTextLine(string $text): array
    {
        $lines = str_replace(' ', '', $text);
        $lines = preg_replace('/\t/', ' ', $text);
        return  explode("\n", $lines);
    }

    private function cleanBnN(string $textCopied)
    {
        $splitLines = $this->cleanTextLine($textCopied);

        $trimedArray = array();
        foreach ($splitLines as $v) {
            $trimedArray[] = implode(' ', array_slice(explode(' ', trim($v)), 0, 2));
        }

        $data = [];
        foreach ($trimedArray as $key) { # Get columns to parse
            $str_arr = array_map('intval', explode(" ", $key));
            $data[] = (object)[
                'id'    => $str_arr[0],
                'total' => $str_arr[1],
            ];
        }

        return collect($data);
    }

    private function cleanSlash_Color(string $textCopied)
    {
        # Clean method line by line
        $rows = $this->cleanTextLine($textCopied);

        $unwanted = "\/";
        $cleanArray = preg_grep("/$unwanted/", $rows, PREG_GREP_INVERT);


        $trimedArray = array();
        foreach ($cleanArray as $v) {
            $trimedArray[] = implode(' ', array_slice(explode(' ', trim($v)), 0, 3));
        }

        $data = [];

        foreach ($trimedArray as $key) {
            $str_arr = array_map('intval', explode(" ", $key));
            $total_negro = abs($str_arr[1] - $str_arr[2]);

            $data[] = (object)[
                'id'    => $str_arr[0],
                'color' => $str_arr[2],
                'negro' => $total_negro,
                'total' => $str_arr[1]
            ];
        }

        return collect($data);
    }

    private function renderBW($data) {
        $template = "
            <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <th>
                            TOTAL IMPRESIONES
                        </th>
                        <td>
                            {$data->sum('total')}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div style='overflow-y: auto;height:550px;'>
                <table class='table table-bordered' id='tbImpr'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                <tbody>";

        foreach ($data as $item) {
            $template .= "
                <tr>
                    <td>{$item->id}</td>
                    <td>{$item->total}</td>
                </tr>";
        }

        $template  .= '</tbody>
            </table>
        </div>';

        return $template;
    }

    private function renderColor($data) {


        $template = "
        <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <th>
                            BLANCO Y NEGRO
                        </th>
                        <td>
                            {$data->sum('negro')}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            COLOR
                        </th>
                        <td>
                            {$data->sum('color')}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            TOTAL
                        </th>
                        <td>
                            {$data->sum('total')}
                        </td>
                    </tr>

                </tbody>
            </table>

            <div style='overflow-y: auto;height:550px;'>
            <table class='table table-bordered' id='tbImpr'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>COLOR</th>
                        <th>NEGRO</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
            <tbody>";

        foreach ($data as $item) {
            $template .= "
            <tr>
                <td>{$item->id}</td>
                <td>{$item->color}</td>
                <td>{$item->negro}</td>
                <td>{$item->total}</td>
            </tr>";
        }

        $template  .= '</tbody>
                </table>
        </div>';

        return $template;
    }
}
