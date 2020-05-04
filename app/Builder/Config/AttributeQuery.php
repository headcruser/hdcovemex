<?php

namespace HelpDesk\Builder\Config;

use Illuminate\Database\Eloquent\Builder;

class AttributeQuery extends Builder
{
    function contact()
    {
        return $this->where('attribute', 'Contacto');
    }

    function status()
    {
        return $this->where('attribute', 'Estado');
    }

    function personal()
    {
        return $this->where('attribute', 'Personal');
    }

    function process()
    {
        return $this->where('attribute', 'Proceso');
    }

    function remote()
    {
        return $this->where('attribute', 'Remoto');
    }

    function type()
    {
        return $this->where('attribute', 'tipo');
    }

    function typeAttribute(string $value)
    {
        if (empty($value)) {
            return $this;
        }

        return $this->where('attribute', $value);
    }

    function categoryAttribute()
    {
        return $this->select(['attribute'])->distinct();
    }
}
