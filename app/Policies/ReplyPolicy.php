<?php

namespace App\Policies;

use App\User as User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Repay as Repay;


class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function update(User $user, \App\Replay $replay)
    {
        return $replay->user_id == $user->id;
    }
}
