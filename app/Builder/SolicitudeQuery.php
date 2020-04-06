<?php

namespace HelpDesk\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class SolicitudeQuery extends Builder
{
    function auth()
    {
        return $this->where('usuario_id', Auth::user()->id);
    }
}
