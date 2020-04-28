<?php

namespace HelpDesk\Builder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

class TicketQuery extends Builder
{
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
     * Filtra los tickets por su titulo
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
     * FFiltra los tickets por su estado
     *
     * @param string|null $status
     * @return Builder
     */
    public function byStatus($status)
    {
        if ($status) {
            return $this->where('estado', $status);
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
     * Filtra los tickets por su prioridad
     *
     * @param string|null $search
     * @return Builder
     */
    public function byPrioridad($prioridad)
    {
        if ($prioridad) {
            return $this->orWhere('prioridad', 'like', "%{$prioridad}%");
        }

        return $this;
    }

    /**
     * Filtra los tickets por el personal al que fue asignado el ticket
     *
     * @param string|null $id
     * @return Builder
     */
    function assingTo($id)
    {
        if ($id) {
            return $this->where('asignado_a', $id);
        }

        return $this->where('asignado_a', Auth::user()->id);
    }
}
