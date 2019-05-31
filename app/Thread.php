<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use App\RecordsActivity;
use App\Notifications\ThreadWasUpdated;
use App\Events\ThreadHasNewReplay;


class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'chanel'];// with relationship return json property
    protected $appends = ['isSubscribedTo'];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($thread){

            $thread->replies->each(function ($reply){

                $reply->delete();
            });
        });

    }
    
    public function path(){

    	return "/threads/{$this->chanel->slug}/{$this->id}";
    }

    public function replies()
    {
    	return $this->hasMany(Replay::class);// if we want all favorites to fetch ->withCount('favorites')
    }

    public function getReplyCountAttribute()
    {
        return $this->replies()->count();// count all replies for thread
    }

    public function creator()
    {
    	return $this->belongsTo(User::class, 'user_id');//jer gleda creator_id
    }
  
    public function addReplay($replay)
    {
        $replay =  $this->replies()->create($replay);

       $this->notifySubscribers($replay);
            
        return $replay;

    }

    public function notifySubscribers($replay)
    {
        
        // Prepare notifications for all subscribes.
        $this->subscriptions
            
            ->where('user_id', '!=' , $replay->user_id)

            ->each
            
            ->notify($replay);
    }

    public function chanel()
    {
        return $this->belongsTo(Chanel::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([

            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($userId = null)
    {
        $this->subscriptions()

        ->where('user_id', $userId ?: auth()->id())

        ->delete();

    }
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
                ->where('user_id', auth()->id())
                ->exists();
    }
}
