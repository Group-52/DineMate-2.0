<?php 

// Menu class

class Menu extends Model
{
	
	public  $order_column = "menu_id";
	protected $table = 'menus';
	protected $allowedColumns = [
        'menu_id',
        'name',
        'description',
        'startTime',
        'endTime',
        'imageurl',
        'allday'
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
	
	public function getmenus(){
		return $this->findAll();
	}
	public function addmenu($data){
		$this->insert($data);
	}

}

