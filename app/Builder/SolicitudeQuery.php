<?php

namespace HelpDesk\Builder;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;

class SolicitudeQuery extends Builder
{
    function auth()
    {
        return $this->where('usuario_id', Auth::user()->id);
    }

    function pendientes()
    {
        return $this->where('estatus_id', Config::get('helpdesk.solicitud.statuses.values.PEN', '1'));
    }

    function proceso()
    {
        return $this->where('estatus_id', Config::get('helpdesk.solicitud.statuses.values.PAS', '2'));
    }

    function finalizadas()
    {
        return $this->where('estatus_id', Config::get('helpdesk.solicitud.statuses.values.END', '3'));
    }

    function canceladas()
    {
        return $this->where('estatus_id', Config::get('helpdesk.solicitud.statuses.values.CAN', '4'));
    }

    /**
     * Filtra los elementos por su ID
     *
     * @param string|null $id Identificador del modelo.
     * @return Builder
     */
    public function byId($id)
    {
        if ($id) {
            return $this->orWhere('id', 'like', "%{$id}%");
        }
        return $this;
    }

    /**
     * Filtra por el titulo
     *
     * @param string|null $title
     * @return Builder
     */
    public function byTitle($title)
    {
        if ($title) {
            return $this->orWhere('titulo', 'like', "%{$title}%");
        }

        return $this;
    }

    /**
     * Realiza la busqueda en el modelo.
     *
     * @param string|null $search
     * @return Builder
     */
    public function search($search)
    {
        return $this->where(function ($query) use ($search) {
            $query->byId($search)->byTitle($search);
        });
    }

    /**
     * Filtra los usuarios por departamentos
     *
     * @param string|null $status
     * @return Builder
     */
    public function byStatus($status)
    {
        if ($status) {
           return $this->where('estatus_id',$status);
        }
        return $this;
    }

    /**
     * Filtra los elementos con la fecha mayor a la especificada
     *
     * @param string $date
     * @return Builder
     */
    public function from($date)
    {
        if ($date) {
            $date = Carbon::createFromFormat('d/m/Y', $date);
            return $this->whereDate('created_at', '>=', $date);
        }

        return $this;
    }

    /**
     * Filtra los elementos hasta la fecha especificada
     *
     * @param [type] $date
     * @return Build
     */
    public function to($date)
    {
        if ($date) {
            $date = Carbon::createFromFormat('d/m/Y', $date);
            return $this->whereDate('created_at', '<=', $date);
        }

        return $this;
    }
}
