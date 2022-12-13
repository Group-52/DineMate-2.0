<?php 

/**
 * home class
 */
class Home
{
	use Controller;

	public function index()
	{

		$data['username'] = empty($_SESSION['user_id']) ? 'User':$_SESSION['fname'];

		#get 5 dishes from database
		$d = new Dish();
		$data['dishes'] = $d->getdishes();
		$m = new Menu();
		$data['menus'] = $m->getmenus();
		$this->view('home',$data);
	}

}
