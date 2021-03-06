<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void{

        parent::setUp();
        $this->thread = factory('App\Thread')->create();//this is useful so we dont create thread for every test

    }
    
    /** @test */
    public function a_user_can_view_all_threads()
    {
       

        $response = $this->get('/threads')
            ->assertSee($this->thread->title);//if there is title of thread    

    }

     /** @test */
    public function a_user_can_read_single_thread()
    {
    
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);

    }

     /** @test */
    function a_user_can_filter_threads_according_to_channel()
    {

         $chanel = create('App\Chanel');
         $threadInChanel = create('App\Thread', ['chanel_id' => $chanel->id]);
         $threadNotInChanel = create('App\Thread');
         $this->get('/threads/'.$chanel->slug)
                ->assertSee($threadInChanel->title)
                ->assertDontSee($threadNotInChanel->title);
    }
    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
       
        $this->signIn(create('App\User',['name' => 'Uros']));
        $threadByUros = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByUros = create('App\Thread');
        
        $this->get('/threads?by=Uros')
                ->assertSee($threadByUros->title)
                ->assertDontSee($threadNotByUros->title);
    }

    /** @test */
   /* public function a_user_can_filter_threads_by_popularity()
    {
       
          //Given 3 threads with  3 replies and 0 replies respectively
        $threadWithTwoReplies = create('App\Thread');
        create('App\Replay', ['thread_id' => $threadWithTwoReplies->id], 2);
        $threadWithThreeReplies = create('App\Thread');
        create('App\Replay', ['thread_id' => $threadWithThreeReplies->id], 3);
        $threadWithNoReplies = $this->thread;
         // When we filter all threads by popularity
        
        $response = $this->getJson('/threads?popular=1')->json();
        // Then they should be return from most replies to least
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));

    }*/

    /** @test */
    public function a_user_can_request_all_replies_for_given_thread()
    {
       
            $thread = create('App\Thread');
            $replay = create('App\Replay', ['thread_id' => $thread->id], 2);

            $response = $this->getJson($thread->path() . '/replies')->json();


            $this->assertCount(2, $response['data']);
            $this->assertEquals(2, $response['total']);
    }
    /** @test */

    public function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread')->fresh();
        $replay = create('App\Replay', ['thread_id' => $thread->id]);
        $response = $this->getJson('/threads?unanswered=1')->json();
        $this->assertCount(1, $response);
    }
}
