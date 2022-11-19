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

		$this->view('home',$data);
	}

}
