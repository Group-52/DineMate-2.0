<?php

namespace controllers\admin;

use core\Controller;
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
        $employee = new Employee;
        $results['employee'] = $employee->getEmployee();      
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

			$employee = new Employee;
			$employee ->addEmployee([
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

    public function edit($emp_id): void
    {
        $employee = new Employee;
        $results['e1'] = $employee->getEmployee($emp_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $employee = new Employee;
            $employee->editEmployee($_POST);
            redirect('admin/employees');
        }
        $this->view('admin/employee.edit', $results);
    }
}