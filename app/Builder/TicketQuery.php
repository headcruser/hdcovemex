<?php

namespace HelpDesk\Builder;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

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
        if (empty($status)) {
            return $this;
        }

        return $this->where('estado', $status);
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
     * Filtra los tickets por su proceso
     *
     * @param string|null $search
     * @return Builder
     */
    public function byProcess($proceso)
    {
        if (!empty($proceso)) {
            return $this->orWhere('proceso', 'like', "%{$proceso}%");
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
        if (empty($id)) {
            return $this;
        }

        return $this->where('asignado_a', $id);
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
