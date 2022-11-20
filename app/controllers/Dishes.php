<?php 

// dish class

class Dishes
{
	use Controller;

	public function index()
	{
        $dish = new Dish;
        $results['dishlist'] = $dish->getdishes();
		
		$this->view('dishes',$results);
		
	}

}
