<?php 

// Dish class

class Dish extends Model
{
	
	public  $order_column = "dish_id";
	protected $table = 'dishes';
	protected $allowedColumns = [
		'dish_id',
		'name',
		'netPrice',
		'sellingPrice',
		'description',
		'prepTime',
		'image_url'
	];

	public function validate($data)
	{
		$this->errors = [];

		if(empty($data['name']))
			$this->errors['name'] = 'Name is required';

		if(empty($this->errors))
			return true;

		return false;
	}
	
	public function getdishes(){
		return $this->findAll();
	}


}

