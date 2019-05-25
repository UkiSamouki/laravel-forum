<?php 

namespace App\Filters;

use App\User;
use Symfony\Component\HttpFoundation\Request;


	/**
	 * class for thread filtering
	 */
	class ThreadFilters extends Filters
	{

		protected $filters = ['by','popular', 'unanswered'];

		/**
		* Filter the query by username
		*
		* @param string $username
		* @return mixed
		*/
	   protected function by($username)
	        {
	        	$user = User::where('name', $username)->firstOrFail();

	        	return $this->builder->where('user_id', $user->id);
	        }

	        /**
		* Filter the query according to most popular threads
		*
		* @param string $username
		* @return mixed
		*/
	   protected function popular()
	        {
	        	$this->builder->getQuery()->orders = [];
	        	return $this->builder->orderBy('replies_count', 'desc');
	        }

	        protected function unanswered()
	        {
	        	return $this->builder->where('replies_count', 0);
	        }

		}


	 ?>