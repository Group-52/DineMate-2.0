<?php 


class Menuitems extends Model
{
	
	public  $order_column = "menu_id";
	protected $table = 'menuitems';
	protected $allowedColumns = [
        'menu_id',
        'dish_id'
	];

	
	public function getdishes($menu){
		return $this->findAll();
	}
	public function addmenu($data){
		$this->insert($data);
	}

}

