<?php

namespace Tests\Feature;


use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ProfilesTest extends TestCase
{
        use RefreshDatabase;

    
    /**
     * A basic feature test example.
     *
     * @test
     */
     function a_user_has_profile()
        {

            $user = create('App\User');
            //$this->signIn($user);
            $this->get("/profiles/{$user->name}")
                    ->assertSee($user->name);
        }

        /**
     * A basic feature test example.
     *
     * @test
     */
     function profiles_display_all_threads_by_the_associated_user()
        {

            $this->signIn();
            $thread = create('App\Thread', ['user_id' => auth()->id()]);
            //$this->signIn($user);
            $this->get("/profiles/". auth()->user()->name)
                    ->assertSee($thread->title)
                    ->assertSee($thread->body);

        }
    }   
 ?>     