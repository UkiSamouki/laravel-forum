<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplayTest extends TestCase
{

	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function it_has_owner()
    {
        $replay = factory('App\Replay')->create();

        $this->assertInstanceOf('App\User' , $replay->owner);
    }
}
