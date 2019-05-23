<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chanel extends Model
{
    
    public function getRouteKeyName()
    {
    	return 'slug'; // this method override the method in parent class to not autogenerate
    }
     public function threads()
     {
     	return $this->hasMany(Thread::class);
     }
}
