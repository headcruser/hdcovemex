<?php

return [
    'fonts' => [
        'nombre'    => realpath(public_path('vendor/firma-electronica/fonts/Constantia.ttf')),
        'puesto'    => realpath(public_path('vendor/firma-electronica/fonts/Gabriola.ttf')),
        'contacto'  => realpath(public_path('vendor/firma-electronica/fonts/Arial.ttf')),
    ],
    'template'  => realpath(public_path('vendor/firma-electronica/img/template.png')),
    'sitio-web' => 'www.covemex.com',
    'extension' => 'Tel: 413-690-1021  Ext. {extension}',
    'correo'    => 'Mail: {correo}',
];
