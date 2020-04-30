<?php

if (!function_exists('getLocale')) {

    /**
     * Obtiene el idioma local del sistema
     *
     * @return string
     */
    function getLocale(): string
    {
        return str_replace('_', '-', app()->getLocale());
    }
}

if (!function_exists('formatBytes')) {

    /**
     * Obtiene el idioma local del sistema
     *
     * @return string
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);
        #$bytes /= (1 << (10 * $pow));


        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
