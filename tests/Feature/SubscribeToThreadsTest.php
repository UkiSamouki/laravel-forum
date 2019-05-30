<?php

namespace Test\Feature;

use Tests \TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * 
 */
class SubscribeToThreadsTest extends TestCase
{
	
	use DatabaseMigrations;


	/** @test */

	public function a_user_can_subscribe_to_threads ()
	{

		//Given a therad
		$this->signIn();
		//And the user subscribe to the therad
		$thread = create('App\Thread');
		//Then each time a new replay is left
		$this->post($thread->path() . '/subscriptions');

		$this->assertCount(1, $thread->fresh()->subscriptions);

		// A notification should be prepare for user

		
	}

	/** @test */

	public function it_know_if_authenticated_user_is_subsribed_to_it()
	{
		
		$thread = create('App\Thread');

		$this->signIn();

		$this->assertFalse($thread->isSubscribedTo);

		$thread->subscribe();

		$this->assertTrue($thread->isSubscribedTo);

	}

	/** @test */

	public function a_user_can_unsubscribe_from_thread()
	{

		$thread = create('App\Thread');

		$this->signIn();

		$thread->subscribe();

		$this->delete($thread->path() . '/subscriptions');

		$this->assertCount(0, $thread->subscriptions);


	}


}
