<?php

return [
    'equipos' => [
        'status' => [
            'class' => [
                'Activo'    => 'badge bg-success',
                'Inactivo'  => 'badge bg-danger',
                'Desechado' => 'badge bg-gray',
            ],
            'values' => [
                'Activo'    => 'Activo',
                'Inactivo'  => 'Inactivo',
                'Desechado' => 'Desechado',
            ]
        ],
        'tipo' => [
            'values' => [
                'Escritorio'    => 'Escritorio',
                'Laptop'        => 'Laptop',
                'Servidor'      => 'Servidor',
            ]
        ]
    ]
];
