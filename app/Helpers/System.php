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
