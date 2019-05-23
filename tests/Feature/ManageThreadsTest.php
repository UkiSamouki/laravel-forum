<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{

    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @test 
     */
    function a_guest_may_not_create_thread()
    {

        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');// make give arr and create obj
        $this->post('/threads', $thread->toArray());
    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
    function a_guest_may_not_see_create_thread_page()
    {

        $this->expectException('Illuminate\Auth\AuthenticationException');
      
           $this->get('/threads/create')    
                ->assertRedirect('/login');    
    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
     function a_auth_user_can_create_new_forum_threads()
    {
        //Given sign in user
        $user = create('App\User');
        $this->signIn($user);
        //When we hit endpoint to create a new thread
        $thread = make('App\Thread');// make give arr and create obj 
        $response = $this->post('/threads', $thread->toArray());
        //Then we visit the thread page
        $this->get($response->headers->get('Location')) 
        //We should see the new thread
        ->assertSee($thread->title)
              ->assertSee($thread->body); 
    }
   /**
     * A basic feature test example.
     *
     * @test 
     */
     function a_thread_requires_a_title()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title'); 
    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
     function a_thread_requires_a_body()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body'); 
    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
     function a_thread_requires_a_valid_chanel()
    {

        $this->expectException('Illuminate\Validation\ValidationException');
        factory('App\Chanel', 2)->create();
        $this->publishThread(['chanel_id' => null])
             ->assertSessionHasErrors('chanel_id');
        $this->publishThread(['chanel_id' => 999])
             ->assertSessionHasErrors('chanel_id');  
    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
    public function a_guest_cannot_delete_therads()
    {
        $this->expectException('Symfony\Component\HttpKernel\Exception\HttpException');
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create('App\Thread');
        $this->json('DELETE', $thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->assertStatus(403);

    }
    /**
     * A basic feature test example.
     *
     * @test 
     */
    public function auth_users_thread_can_be_deleted()
    {
        $this->signIn();
        $thread = create('App\Thread', ['user_id' => auth()->id()]);//user must own a thread
        $reply = create('App\Replay', ["thread_id" => $thread->id]);
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ["id" => $thread->id]);
        $this->assertDatabaseMissing('replays', ["id" => $reply->id]);
        $this->assertDatabaseMissing('activities', [

            "subject_id" => $thread->id,
            "subject_type" => get_class($thread)

        ]);
        $this->assertDatabaseMissing('activities', [

            "subject_id" => $reply->id,
            "subject_type" => get_class($reply)

        ]);

    }

    function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
       return $this->post('/threads' ,$thread->toArray()); 
    }

}
