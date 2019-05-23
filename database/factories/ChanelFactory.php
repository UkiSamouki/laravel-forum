<?php

use Faker\Generator as Faker;

$factory->define(App\Chanel::class, function (Faker $faker) {
    
        $name = $faker->word;

    return [

    	'name' => $name,
        'slug' => $name
    	
    ];
});
