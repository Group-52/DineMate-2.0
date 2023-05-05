<?php

namespace controllers\admin;

use core\Controller;
use models\Employee;

/**
 * Employee Controller
 */
class Employees
{
    use Controller;

    public function index(): void
    {
        $employee = new Employee;
        $data['employee'] = $employee->getEmployees();
        $data['controller'] = 'employees';
        $this->view('admin/employee', $data);
    }

    public function addEmployee(): void
    {
        if (isset($_POST['save'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $role = $_POST['role'];
            $salary = $_POST['salary'];
            $username = $_POST['username'];
            // $DOB = $_POST['DOB'];
            $contact_no = $_POST['contact_no'];
            $NIC = $_POST['NIC'];

            //create a password by concatenating first name and last name and NIC and removing spaces
            $password = $first_name . $last_name . $NIC;
            $password = str_replace(' ', '', $password);
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $employee = new Employee;
            $employee->addEmployee([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => $role,
                'salary' => $salary,
                'username' => $username,
                // 'DOB'=> $DOB,
                'password' => $hashed,
                'contact_no' => $contact_no,
                'NIC' => $NIC
            ]);


            redirect('admin/employees');

        }
        $this->view('admin/employee.add');
    }

    public function edit($emp_id): void
    {
        $employee = new Employee;
        $data['e1'] = $employee->getEmployee($emp_id);
        $data['controller'] = 'employees';
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//            show($_POST);
            $employee = new Employee;
            $employee->editEmployee($_POST);
            redirect('admin/employees');
        }
        $this->view('admin/employee.edit', $data);
    }

    public function delete($emp_id): void
    {
        $employee = new Employee;
        $employee->deleteEmployee($emp_id);
        redirect('admin/employees');
    }
}