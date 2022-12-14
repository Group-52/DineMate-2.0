<?php

// vendor class

class Vendors
{
    use Controller;

    public function index()
    {
        echo "HII";
    }

    public function addVendor()
    {
        if(isset($_POST['save'])){
			$name = $_POST['name'];
			$role = $_POST['address'];
			$salary = $_POST['company'];
			$contactNo = $_POST['contact_no'];

			$vendor = new Vendor;
			$vendor ->addVendor([
				'name'=> $name,
				'role'=> $role,
				'salary'=> $salary,
				'DOB'=> $DOB,
				'contactNo'=> $contactNo,
				'NIC'=> $NIC
			]);

			//header('Location: employee');
            redirect('vendor');

        }
        $this->view('addvendor');
    }

    public function vendor() 
    {
        $this->view('vendor');
    }

}