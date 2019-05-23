<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
        use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @test
     */
     function unauthenticated_users_may_not_add_replies()
        {

            $this->expectException('Illuminate\Auth\AuthenticationException');
            $this->post('/threads/some-chanel/1/replies', []);//not need factory this should event trigger the method

        }    

    /**
     * A basic feature test example.
     *
     * @test
     */
     function an_authenticated_user_may_participate_in_forum_threads()
    {

        //Given a authenticate user
        $user = factory('App\User')->create();
        $this->signIn($user);
        //And an existing thread
        $thread = factory('App\Thread')->create();
        //When user adds replay to thread
        $replay = factory('App\Replay')->make();// we want to make in memory not create on db
        $this->post($thread->path().'/replies' ,$replay->toArray());
        //Then repaly should be visible on the page.
        $this->get($thread->path())
                ->assertSee($replay->body); 
    }
    /**
     * A basic feature test example.
     *
     * @test
     */
    function a_replay_requires_a_body()
    {

        $this->expectException('Illuminate\Validation\ValidationException');

        $this->signIn();
        $thread = create('App\Thread');
        $replay = make('App\Replay', ['body' => null]);

        $this->post($thread->path() . '/replies', $replay->toArray())
             ->assertSessionHasErrors('body');
        
    }

    /**
     * A basic feature test example.
     *
     * @test
     */
     function unauthenticated_users_may_not_delete_replies()
        {

            $this->expectException('Illuminate\Auth\AuthenticationException');
            $replay = create('App\Replay');

            $this->delete("/replies/{$replay->id}")
                            ->assertRedirect('login');

            $this->signIn()->delete("/replies/{$replay->id}")
                            ->assertStatus(403);

        }

    /**
     * A basic feature test example.
     *
     * @test
     */
     function authenticated_users_may_delete_replies()
        {


            $this->signIn();

            $replay = create('App\Replay', ['user_id' => auth()->id()]);
            
            $this->delete("/replies/{$replay->id}")->assertStatus(302);

            $this->assertDatabaseMissing('replays', ['id' => $replay->id]);
        }
            /**
     * A basic feature test example.
     *
     * @test
     */
     function unauthenticated_users_may_not_update_replies()
        {

            $this->expectException('Illuminate\Auth\AuthenticationException'); 
            $replay = create('App\Replay');

            $this->patch("/replies/{$replay->id}")
                            ->assertRedirect('login');

            $this->signIn()->patch("/replies/{$replay->id}")
                            ->assertStatus(403);

        }


          /**
     * A basic feature test example.
     *
     * @test
     */
     function authenticated_users_may_update_replies()
        {


            $this->signIn();

            $replay = create('App\Replay', ['user_id' => auth()->id()]);
            
            $updatedReplay = "You been changed fool";

            $this->patch("/replies/{$replay->id}", ["body" => $updatedReplay]);

            $this->assertDatabaseHas('replays', ['id' => $replay->id, "body" => $updatedReplay]);
        }           
}
