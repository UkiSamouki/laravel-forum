<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
        use RefreshDatabase;


    /**
     * A basic feature test example.
     *
     * @test
     */

    public function it_checks_for_invalid_keywords()
    {
    	

    	//invalid keywords

    	//key held down

    	$spam = new Spam();
    	$this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException('Exception');

   		$spam->detect('yahoo customer support');

    }

        /**
     * A basic feature test example.
     *
     * @test
     */

     public function it_checks_for_any_key_being_held_down()
        {
        	
        	$spam = new Spam();

        	$this->expectException('Exception');

    		$spam->detect('Hello World aaaaaaaaaaaaaaaa');

        }   

}

?>







