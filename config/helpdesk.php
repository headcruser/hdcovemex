<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CONFIGURACION HELP DESK
    |--------------------------------------------------------------------------
    |
    | CONTIENE LA CONFIGURACION PARA QUE EL PROYECTO PUEDA FUNCIONAR CORRECTAMENTE
    */
    'tickets' => [
        'estado' => [
            'names' => [
                'Abierto'       => 'Abierto',
                'Finalizado'    => 'Finalizado',
                'Cancelado'     => 'Cancelado',
            ],
            'values' => [
                'Cancelado',
                'Abierto',
                'Finalizado'
            ],
            'alias' => [
                'ABT'  => 'Abierto',
                'FIN'  => 'Finalizado',
                'CAN'  => 'Cancelado',
            ]
        ],
        'prioridad' => [
            'values' => [
                1 => 'Alta',
                2 => 'Media',
                3 => 'Baja'
            ],
            'colors' => [
                1 => '#FF2020',
                2 => '#ff9f43',
                3 => '#7FF97F',
            ]
        ],

        'contacto' => [
            'values' => [
                'Telefonico',
                'Email',
                'Personal',
            ]
        ],
        'proceso' => [
            'values' => [
                'En proceso',
                'Finalizado',
                'En espera',
            ],
            'alias' => [
                'EPS'   => 'En proceso',
                'FIN'  => 'Finalizado',
                'CAN'  => 'Cancelado',
            ]
        ],
        'tipo' => [
            'values' => [
                'Personal' => [
                    'Actualizacion',
                    'Configuracion',
                    'Instalacion',
                    'Consumibles',
                    'Control de equipo',
                    'Asesoria',
                    'Revision',
                    'Mantenimiento',
                    'Reparacion'
                ],
                'Remoto' => [
                    'Actualizacion',
                    'Configuracion',
                    'Asesoria',
                    'Revisión',
                    'Desarrollo',
                    'Consumibles',
                    'Reparacion',
                    'Proveedores'
                ],
                'Solicitud' => [
                    'Seguimiento',
                ],
                'Servicio' => [
                    'Personal',
                    'Remoto',
                    'Solicitud'
                ],
                'Control de equipo' => []
            ]
        ]
    ],

    'solicitud' => [
        'statuses'    => [
            'names' => [
                'PEN'   => 'Ingresada',
                'PAS'   => 'Procesada',
                'END'   => 'Finalizada',
                'CAN'   => 'Cancelada',
            ],
            'colors' => [
                'PEN' => '#ff9f43',
                'PAS' => '#6c757d',
                'END' => '#28a745',
                'CAN' => '#dc3545',
            ],
            'values' => [
                'PEN'   => 1,
                'PAS'   => 2,
                'END'   => 3,
                'CAN'   => 4,
            ]
        ]
    ],

    'global' => [
        'visibilidad' => [
            'values' => ['S', 'N'],
            'select' => [
                'S' => 'Si',
                'N' => 'NO'
            ]
        ],
        'from_user_request' => 'soporte@covemex.com',
        'from_user_passwd'  => 'covemex@covemex.com',
        'format'            => 'd/m/Y',
        'copyright'         => 'Covemex',
        'company'           => 'Covemex',
        'name'              => 'Help Desk Covemex',
        'alias'             => 'hdcovemex'
    ],

    'mail' => [
        'request_subject'               => 'Aviso: se ingresó la solicitud de soporte #%1%',
        'alert_ticket_comment_subject'  => 'Aviso: el usuario (%usuario_id%) - %usuario_nombre% agregó un comentario al ticket #%ticket_id%"',
        'alert_comment_subject'         => 'Aviso: se agregó un comentario a su solicitud #%solicitud_id%',
    ],
    'roles' => [
        'names' => [
            'ADM'   => 'admin',
            'SOP'   => 'soporte',
            'EMP'   => 'empleado',
            'JEF'   => 'jefatura'
        ],
    ]
];
