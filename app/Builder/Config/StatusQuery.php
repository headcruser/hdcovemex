<?php
namespace HelpDesk\Builder\Config;

use Illuminate\Database\Eloquent\Builder;

class StatusQuery extends Builder
{
    function pendientes(){
        return $this->where('name','PEN');
    }

    function proceso(){
        return $this->where('name','PAS');
    }

    function canceladas(){
        return $this->where('name','CAN');
    }

    function finalizadas(){
        return $this->where('name','END');
    }
}
