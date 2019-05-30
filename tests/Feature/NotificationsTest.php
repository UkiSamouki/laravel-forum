<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\DatabaseNotification;



class NotificationsTest extends TestCase
{


    use DatabaseMigrations;

    public function setUp() :void
    {
        
        parent::setUp();

        $this->signIn();  
    }

    /**
     * A basic feature test example.
     *
     * @test 
     */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        


        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);
        // Each time a new replay is left..
        $thread->addReplay([

            'user_id' => auth()->id(),
            'body' => 'Some reply here'
        ]);
        // If we leave the thread the number of notification should be 0
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        //If we add reply from sombody else 
        $thread->addReplay([

            'user_id' => create('App\User')->id,
            'body' => 'Some reply here'
        ]);

        //This sould leave notification
        $this->assertCount(1, auth()->user()->fresh()->notifications);

    }

    /**
     * A user can fetch notifications.
     *
     * @test 
     */
    public function a_user_can_fetch_their_unread_notifications()
    {
        

        create(DatabaseNotification::class);
        /*$thread = create('App\Thread')->subscribe();
        $thread->addReplay([

            'user_id' => create('App\User')->id,
            'body' => 'Some reply here'
        ]);*/

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications")->json();

        $this->assertCount(1, $response);

    }
    /**
     * A user can clear notifications.
     *
     * @test 
     */

    public function a_user_can_mark_notifications_as_read()
    {
        
        create(DatabaseNotification::class);

        $user = auth()->user();
        //user should have 1 notification
        $this->assertCount(1, $user->unreadNotifications);

        $notificationId = $user->unreadNotifications->first()->id;

        $this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);

    }

}
