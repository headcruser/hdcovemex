<?php

namespace HelpDesk\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SolicitudeQuery extends Builder
{
    function auth()
    {
        return $this->where('empleado_id', Auth::user()->id);
    }
}
