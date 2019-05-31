<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ThreadWasUpdated;

class ThreadTest extends TestCase
{


    use DatabaseMigrations;

	protected $thread;

	public function setUp(): void
	{
		parent::setUp();
    	$this->thread = factory('App\Thread')->create();
    }
    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_thread_has_a_creator()
    {
    	
    	$this->assertInstanceOf('App\User' , $this->thread->creator); 
    }

    /** @test */
    public function a_user_can_make_string_path()
    {
       

        $thread = create('App\Thread');

        $this->assertEquals("/threads/{$thread->chanel->slug}/{$thread->id}", $thread->path());
    }
	
    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function thread_has_replies()
    {
    	
    	$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }
    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_thread_can_add_reply()
    {
    	$this->thread->addReplay([
    		'body' => 'Foobar',
    		'user_id' => '5'
    	]);
    	$this->assertCount(1, $this->thread->replies);
    }

    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added()
    {

        Notification::fake();

        $this->signIn()

       ->thread

       ->subscribe()

       ->addReplay([

            'body' => 'Foobar',
            'user_id' => 1
        ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function thread_belongs_to_chanel()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Chanel', $thread->chanel);
    }

    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_thread_can_be_subscribe_to()
    {

        $thread = create('App\Thread');

        // User subscribe to the thread
        $thread->subscribe($userId = 1);
        // Fetch all threads that user has subscribed
        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /**
     * A basic unit test example.
     *
     * @test 
     */
    public function a_thread_can_be_unsubscribe_from()
    {

        $thread = create('App\Thread');

        // User subscribe to the thread
        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId = 1);

        // Fetch all threads that user has subscribed
        $this->assertCount(0, $thread->subscriptions);
    }

}
