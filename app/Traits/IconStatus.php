<?php
namespace HelpDesk\Traits;

use Illuminate\Support\HtmlString;

trait IconStatus
{
    public function flagIcon(bool $flag):HtmlString {

        if (!$flag) {
            return new HtmlString("<span class='badge badge-danger'> <i class='fas fa-times-circle'></i> Inhabilitado</span>");
        }

        return new HtmlString("<span class='badge badge-success'> <i class='fas fa-check-circle'></i>  Habilitado</span>");
    }
}
