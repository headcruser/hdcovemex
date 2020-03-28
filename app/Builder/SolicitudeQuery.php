<?php

namespace HelpDesk\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Entrust;

class SolicitudeQuery extends Builder
{

    function auth()
    {

        if (Entrust::hasRole(['admin', 'soporte'])) {
            return $this;
        }

        return $this->where('empleado_id', Auth::user()->id);
    }
}
