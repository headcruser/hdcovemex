<?php

if (!function_exists('generar_firma')) {

    /**
     * Genera la firma electronica del usuario
     *
     * @param string $nombre
     * @param string $puesto
     * @param string $correo
     * @param string $extension
     *
     * @return array|false Matriz de valores de la imagen
     */
    function generar_firma(string $nombre, string $puesto, string $correo, string $extension)
    {
        # FUENTES
        $fontNombre = config('firma-electronica.fonts.constantia');
        $fontPuesto = config('firma-electronica.fonts.gabriola');
        $fontContacto = config('firma-electronica.fonts.arial');

        # INFORMACION IMAGEN
        $nombreImagen = config('firma-electronica.template');
        $Sitioweb = config('firma-electronica.sitio-web');
        $Correo = str_replace('{correo}', $correo, config('firma-electronica.correo'));
        $Telefono = str_replace('{extension}', $extension, config('firma-electronica.extension'));

        # GENERACION IMAGEN
        $firma = imagecreatefrompng($nombreImagen);
        $color = imagecolorallocate($firma, 255, 255, 255);
        $colorSitio = imagecolorallocate($firma, 255, 218, 147);

        # POSICIONAMIENTO
        $sizeNombre = 14.5;
        $sizePuesto = 16;
        $sizeContacto = 10.5;
        $angulo = 0;
        $espacio = 10;
        $x = 85;
        $y = 35;
        $x2 = 85;
        $y2 = $y + $espacio + $sizeNombre + 1;
        $lineContacto = $y + $espacio + $sizeNombre + $sizePuesto + 22;
        $lineTelefono = $y + $espacio + $sizeNombre + $sizePuesto + $sizeContacto + 30;
        $lineSitioweb = $y + $espacio + $sizeNombre + $sizePuesto + $sizeContacto + 47;

        # NOMBRE
        imagettftext($firma, $sizeNombre, $angulo, $x, $y, $color, $fontNombre, $nombre);
        # PUESTO
        imagettftext($firma, $sizePuesto, $angulo, $x2, $y2, $color, $fontPuesto, $puesto);
        # CORREO
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineContacto, $color, $fontContacto, $Correo);
        # TELEFONO
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineTelefono, $color, $fontContacto, $Telefono);
        # WEB
        imagettftext($firma, $sizeContacto, $angulo, $x2, $lineSitioweb, $colorSitio, $fontContacto, $Sitioweb);

        return $firma;
    }
}
