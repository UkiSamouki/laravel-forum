<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{

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
    public function thread_belongs_to_chanel()
    {
        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Chanel', $thread->chanel);
    }

}
