<?php

namespace App\Policies;

use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadPolicy
{
    use HandlesAuthorization;



    public function before($user)
    {
        if ($user->name === 'Uros') {
            
            return true;// when return true he has all auth ovo moze i u AuthServiceProvider u before meth
        }
    }
    /**
     * Determine whether the user can view the odel= thread.
     *
     * @param  \App\User  $user
     * @param  \App\odel=Thread  $odel=Thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can create odel= threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the odel= thread.
     *
     * @param  \App\User  $user
     * @param  \App\odel=Thread  $odel=Thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $thread->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the odel= thread.
     *
     * @param  \App\User  $user
     * @param  \App\odel=Thread  $odel=Thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can restore the odel= thread.
     *
     * @param  \App\User  $user
     * @param  \App\odel=Thread  $odel=Thread
     * @return mixed
     */
    public function restore(User $user, Thread $thread)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the odel= thread.
     *
     * @param  \App\User  $user
     * @param  \App\odel=Thread  $odel=Thread
     * @return mixed
     */
    public function forceDelete(User $user, Thread $thread)
    {
        //
    }
}
