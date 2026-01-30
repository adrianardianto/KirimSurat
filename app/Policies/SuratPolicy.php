<?php

namespace App\Policies;

use App\Models\Surat;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuratPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Surat $surat): bool
    {
        return $user->isAdmin() || $user->id === $surat->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Surat $surat): bool
    {
        return $user->isAdmin() || ($user->id === $surat->user_id && in_array($surat->status, ['draft', 'pending']));
    }

    public function delete(User $user, Surat $surat): bool
    {
        return $user->isAdmin() || ($user->id === $surat->user_id && in_array($surat->status, ['draft', 'pending']));
    }

    public function restore(User $user, Surat $surat): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Surat $surat): bool
    {
        return $user->isAdmin();
    }
}
