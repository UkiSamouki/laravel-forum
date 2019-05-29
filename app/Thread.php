<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use App\RecordsActivity;

class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with = ['creator', 'chanel'];// with relationship return json property

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
        return $this->replies()->create($replay);
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
    
}
