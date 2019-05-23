<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase
{

	use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_channel_consist_of_threads()
    {
        
    	$channel = create('App\Chanel');
    	$thread = create('App\Thread', ['chanel_id' => $channel->id]);
        $this->assertTrue($channel->threads->contains($thread));
    }
    
}
