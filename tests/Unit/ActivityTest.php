<?php 

namespace Tests\Unit;

use Tests\TestCase;
use Carbon\Carbon as Carbon;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Activity as Activity;
	
/**
 * 
 */
class ActivityTest extends TestCase
{
	
	use RefreshDatabase;
	/**
     * A basic unit test example.
     *
     * @test 
     */

	public function it_records_activity_when_a_thread_is_created()
	{
		$this->signIn();
		$thread = create('App\Thread');
		$this->assertDatabaseHas('activities', [

			'type' => 'created_thread',
			'user_id' => auth()->id(),
			'subject_id' => $thread->id,
			'subject_type' => 'App\Thread'
		]);
		$activity = Activity::first();
		$this->assertEquals($activity->subject->id, $thread->id);
	}
	/**
     * A basic unit test example.
     *
     * @test 
     */

	public function it_fetches_a_feed_for_any_user()
	{
		// Given we have a thread
		$this->signIn();
		create('App\Thread', ['user_id' => auth()->id()], 2);
		// Any another thread form a week ago
		auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
		// When we fetch their feed.
		$feed = Activity::feed(auth()->user());
		//Then it should be return in proper format
		$this->assertTrue($feed->keys()->contains(

			Carbon::now()->format('Y-m-d')
		));
		$this->assertTrue($feed->keys()->contains(

			Carbon::now()->subWeek()->format('Y-m-d')
		));
	}


	/**
     * A basic unit test example.
     *
     * @test 
     */

	public function it_records_activity_when_a_replay_is_created()
	{

		$this->signIn();
		$replay = create('App\Replay');
		$this->assertEquals(2, Activity::count());
	}
}

 ?>