<?php

use App\User;
use App\Thread;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Replay::class, function (Faker $faker) {
    return [

    	'thread_id' => function()
    	{
    		return factory('App\Thread')->create()->id;
    	},
    	'user_id' => function()
    	{
    		return factory('App\User')->create()->id;
    	},
        'body' => $faker->paragraph  
    ];
});
