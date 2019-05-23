<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Replay;

class FavoritesTest extends TestCase
{
        use RefreshDatabase;

    
    /**
     * A basic feature test example.
     *
     * @test
     */
     function a_guest_can_not_favorite_anything()
        {

            $this->expectException('Illuminate\Auth\AuthenticationException');

            $this->post('/replies/1/favorites')
                    ->assertRedirect('/login');

        }         



    /**
     * A basic feature test example.
     *
     * @test
     */
     function a_authenticated_users_can_favorite_any_replay()
        {

            $this->signIn();
            // /threads/channel/id/replies/id/favorites
            // /replies/id/favorites
            // /replies/id/favorite
            // /favorites  <-- reply_id in req
            $replay = create('App\Replay');
            //If I post to a 'favorite' endpoint
            $this->post('/replies/'.$replay->id .'/favorites');
            //It should be recorded in the database

            //dd(\App\Favorite::all());
            $this->assertCount(1, $replay->favorites);

        }
        /**
         * A basic feature test example.
         *
         * @test
         */ 

        public function a_authenticated_users_can_favorite_a_reply_once()
        {
            
            $this->signIn();
            $replay = create('App\Replay');
            try {

                $this->post('/replies/'.$replay->id .'/favorites');
                $this->post('/replies/'.$replay->id .'/favorites');
                $this->assertCount(1, $replay->favorites);
            }
            catch (\Exception $e){
                
                $this->fail('Did not expect to insert the same record twice.');
            }    
        }

             /**
         * A basic feature test example.
         *
         * @test
         */ 

        public function a_authenticated_users_can_unfavorite_a_reply()
        {
            
                $this->signIn();
                $replay = create('App\Replay');
                $replay->favorite();// using our API to favorite replay
                $this->delete('/replies/'.$replay->id .'/favorites');
                $this->assertCount(0, $replay->favorites);// we dont need a $replay->fresh()->favorites fresh instance
         }
    
}
?>