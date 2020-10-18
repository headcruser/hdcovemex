<?php

namespace HelpDesk\Builder\Admin;

use Illuminate\Database\Eloquent\Builder;

class UserQuery extends Builder
{
    /**
     * Filtering users according to their role or many roles
     *
     * @param string|array $role
     * @return users collection
     */
    public function withRoles($role)
    {
        $values  = is_array($role) ? $role : func_get_args();

        return $this->whereHas('roles', function ($query) use ($values) {
            $query->whereIn('name', $values);
        });
    }

    public function activos()
    {
        return $this->whereNull('deleted_at');
    }
}
