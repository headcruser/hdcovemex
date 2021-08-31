<?php

namespace HelpDesk\Enums;

use BenSampo\Enum\Enum;
use Illuminate\Support\Str;

final class Meses extends Enum
{
    #date("F", mktime(0, 0, 0, 2, 1))
    const ENERO = 1;
    const FEBRERO = 2;
    const MARZO = 3;
    const ARBIL = 4;
    const MAYO = 5;
    const JUNIO = 6;
    const JULIO = 7;
    const AGOSTO = 8;
    const SEPTIEMBRE = 9;
    const OCTUBRE = 10;
    const NOVIEMBRE = 11;
    const DICIEMBRE = 12;


    // public static function getKey($value): string
    // {
    //     return Str::ucfirst(parent::getKey($value));
    // }

    // public static function getDescription($value): string
    // {
    //     return Str::ucfirst(parent::getDescription($value));
    // }
}
