<?php

namespace App\Policies;

use App\Models\Grant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GrantPolicy
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
    public function view(User $user, Grant $grant): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        if ($user->role === 'admin_executive') {
            return Response::allow();
        }

        return Response::deny('Only admin can create grants.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Grant $grant): Response
    {
        if ($user->role === 'admin_executive') {
            return Response::allow();
        }

        if ($user->id ===  $grant->projectLeader->user->id ) {
            return Response::allow();
        }
    
        return Response::deny('Only the assigned project leader or admin can edit this grant.');
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Grant $grant): bool
    {
        return $user->role === 'admin_executive';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Grant $grant): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Grant $grant): bool
    {
        return false;
    }
}
