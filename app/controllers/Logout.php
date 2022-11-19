<?php 

/**
 * logout class
 */
class Logout
{
	use Controller;

	public function index()
	{

		unset($_SESSION['user_id']);
		unset($_SESSION['email']);
		unset($_SESSION['fname']);

		redirect('home');
	}

}
