<?php 


/**
 * User class
 */
class RegUser extends Model
{
	protected $table = 'reg_users';

	protected $allowedColumns = [
		'user_id',
		'fname',
		'lname',
		'contactNo',
		'email',
		'password',
		'registered_date',
		'last_modified'
	];
	protected $order_column = "user_id";

	public function validate($data)
	{
		$this->errors = [];

		$exists = $this->where(['email' => $data['email']]);
		if ($exists!=false)
			$this->errors['email'] = "Email already exists";

		if(empty($data['email']))
			$this->errors['email'] = "Email is required";
		else if(!filter_var($data['email'],FILTER_VALIDATE_EMAIL))
			$this->errors['email'] = "Email is not valid";

		if(empty($data['password']))
			$this->errors['password'] = "Password is required";

		if(empty($data['contactNo']))
			$this->errors['contactNo'] = "Contact number is required";

		if(empty($data['lname']))
			$this->errors['lname'] = "Last name is required";

		if(empty($data['fname']))
			$this->errors['fname'] = "First name is required";

		if($data['password'] != $data['password_confirmation'])
			$this->errors['password'] = "Password does not match";

		if(empty($this->errors))
			return true;

		return false;
	}
}

