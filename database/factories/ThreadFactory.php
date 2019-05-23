<?php

use App\User;
use App\Chanel;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Thread::class, function (Faker $faker) {
    return [

    	'user_id' => function()
    	{
    		return factory('App\User')->create()->id;
    	},
    	'chanel_id' => function(){

    		return factory('App\Chanel')->create()->id;
    	},
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
