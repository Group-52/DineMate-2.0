<?php

namespace controllers\admin;

use core\Controller;
use Exception;
use models\Employee;
use models\Role;

/**
 * Employee Controller
 */

class Employees
{
    use Controller;

    public function index()
    {
        $vendor = new Employee;
        $results['employee'] = $vendor->getEmployee();      
        $this->view('admin/employee', $results);
    }

    public function addEmployee(): void
    {
        if(isset($_POST['save'])){
			$first_name = $_POST['first_name'];
			$last_name = $_POST['last_name'];
			$role = $_POST['role'];
            $salary = $_POST['salary'];
            // $DOB = $_POST['DOB'];
			$contact_no = $_POST['contact_no'];
            $NIC = $_POST['NIC'];

			$vendor = new Employee;
			$vendor ->addEmployee([
				'first_name'=> $first_name,
				'last_name'=> $last_name,
				'role'=> $role,
                'salary'=> $salary,
                // 'DOB'=> $DOB,
                'contact_no'=> $contact_no,
                'NIC'=> $NIC
			]);

            redirect('admin/employees');

        }
        $this->view('admin/employee.add');
    }
}