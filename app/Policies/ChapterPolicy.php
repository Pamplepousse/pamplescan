<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chapitre;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChapterPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'contrib';
    }

    public function update(User $user, Chapitre $chapitre)
    {
        return $user->role === 'admin' || $user->id === $chapitre->user_id;
    }

    public function delete(User $user, Chapitre $chapitre)
    {
        return $user->role === 'admin' || $user->id === $chapitre->user_id;
    }
}
