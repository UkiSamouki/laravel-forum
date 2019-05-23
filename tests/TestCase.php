<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user =null)
    {
    	$user = $user ? : create('App\User');
    	$this->be($user);// set the current logged in user for the app
    	return $this;
    }
}
