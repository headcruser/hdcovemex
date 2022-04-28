<?php

if (!function_exists('generar_firma')) {

    /**
     * Genera la firma electronica del usuario
     *
     * @param
     * @return
     */
    function generar_firma(string $nombre, string $puesto, string $correo, string $extension)
    {
        # FUENTES
        $fontNombre = config('firma-electronica.fonts.nombre');
        $fontPuesto = config('firma-electronica.fonts.puesto');
        $fontContacto = config('firma-electronica.fonts.puesto');

        # INFORMACION IMAGEN
        $nombreImagen = config('firma-electronica.template');
        $Sitioweb = config('firma-electronica.sitio-web');
        $Correo = str_replace('{correo}', $correo, config('firma-electronica.correo'));
        $Telefono = str_replace('{extension}', $extension, config('firma-electronica.extension'));

        # GENERACION IMAGEN
        $firma = imagecreatefrompng($nombreImagen);
        $color = imagecolorallocate($firma, 255, 255, 255);

        $sizeNombre = 13;
        $sizePuesto = 16;
        $sizeContacto = 11;
        $angulo = 0;
        $espacio = 10;
        $x = 87;
        $y = 35;
        $x2 = 87;
        $y2 = $y + $espacio + $sizeNombre + 1;
        $lineContacto = $y + $espacio + $sizeNombre + $sizePuesto + 15;
        $lineTelefono = $y + $espacio + $sizeNombre + $sizePuesto + $sizeContacto + 20;
        $lineSitioweb = $y + $espacio + $sizeNombre + $sizePuesto + $sizeContacto + 45;

        /* NOMBRE */
        imagettftext($firma, $sizeNombre, $angulo, $x, $y, $color, $fontNombre, $nombre);
        /* PUESTO */
        imagettftext($firma, $sizePuesto, $angulo, $x2, $y2, $color, $fontPuesto, $puesto);
        /* CORREO */
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineContacto, $color, $fontContacto, $Correo);
        /* TELEFONO */
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineTelefono, $color, $fontContacto, $Telefono);
        /* WEB */
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineSitioweb, $color, $fontContacto, $Sitioweb);

        return $firma;
    }
}
