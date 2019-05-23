<?php 

namespace App;

trait RecordsActivity
{

	protected static function bootRecordsActivity(){// convention is boot_NameOfTrait and it triggers as it is in Threa

		if (auth()->guest()) return;
		
		static::created(function ($thread){

            $thread->recordActivity('created');
        });

        static::deleting(function ($model) {

            $model->activity()->delete();
        });
	}

	public function recordActivity($event)
    {
        
        $this->activity()->create([

            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            /*'subject_id' => $this->id,
            'subject_type' => get_class($this)*/
            ]);
    }

    public function activity()
    {
    	return $this->morphMany('App\Activity', 'subject');
    }

    public function getActivityType($event)
    {

    	$type = strtolower((new \ReflectionClass($this))->getShortName());//Thread
        return "{$event}_{$type}";
    }
}







 ?>