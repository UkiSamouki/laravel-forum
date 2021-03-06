<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     public function getRouteKeyName()
    {
        return 'name'; // this method override the method in parent class to not autogenerate
    }
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function visitedThreadCacheKey($thread)
    {
        
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);// users.50.visits.1

    }

    public function read($thread)
    {
        
         //simulate that the user visited the thread

        cache()->forever(
        $this->visitedThreadCacheKey($thread),
         \Carbon\Carbon::now());// we store a key to cache and make it equal to currnet time
    }
}
