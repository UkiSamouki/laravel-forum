<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replay extends Model
{

    use Favoritable, RecordsActivity;

	protected $guarded = [];
    
    protected $with = ['owner', 'favorites'];// ego load owner relationship for every single replay query
    
    protected $appends = ['favoritesCount', 'isFavorited']; // send a count of relation of that instance


    protected static function boot()
    {
        parent::boot();

        static::created(function ($replay){

            $replay->thread->increment('replies_count');
        });

        static::deleted(function ($replay){

            $replay->thread->decrement('replies_count');
        });
    }

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id'); // foreign key is user_id not owner_id
    }
   public function thread()
    {
    	return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#replay-{$this->id}";
    }

}
