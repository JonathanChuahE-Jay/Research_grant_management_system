<?php

namespace App\Policies;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AcademicianPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Academician $academician): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Academician $academician): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Academician $academician): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Academician $academician): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Academician $academician): bool
    {
        return false;
    }
}
