<?php 

namespace App\Filters;

use Symfony\Component\HttpFoundation\Request;

abstract class Filters {

		protected $request, $builder;
		protected $filters = [];

			
	function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function apply($builder)
	{

		$this->builder = $builder;

		foreach ($this->getfilters() as $filter => $value) {

			if(method_exists($this, $filter)){

				$this->$filter($value);
					
				// We apply our filters to the builder
		            
		     	 return $this->builder;    
			 }
		}
	}

	public function getfilters()
	{
		return $this->request->only($this->filters);// intersect is better then only
	}

 }





 ?>