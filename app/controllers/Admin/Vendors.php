<?php

namespace controllers\admin;

use core\Controller;
use models\Vendor;
// vendor class

class Vendors
{
    use Controller;

    public function index(): void
    {
        $vendor = new Vendor;
        $data['Vendor'] = $vendor->getVendors();
        $data['controller']  = 'vendors';
        $this->view('admin/vendor', $data);
    }

    public function addVendor(): void
    {
        if(isset($_POST['save'])){
			$vendor_name = $_POST['vendor_name'] ?? null;
			$address = $_POST['address'] ?? null;
			$company = $_POST['company'] ?? null;
			$contact_no = $_POST['contact_no'] ?? null;
            $email = $_POST['email'] ?? null;

			$vendor = new Vendor;
            $data = [
                'vendor_name' => $vendor_name,
                'address' => $address,
                'company' => $company,
                'contact_no' => $contact_no,
                'email' => $email
            ];
            //remove empty and null values from array
            $data = array_filter($data);
            $vendor ->addVendor($data);

            redirect('admin/vendors');

        }
    }

    public function edit($vendor_id): void
    {
        $vendor = new Vendor;
        $data['v1'] = $vendor->getVendor($vendor_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
//            show($_POST);
            $vendor = new Vendor;
            $vendor->editVendor($_POST);
            redirect('admin/vendors');
        }
        $data['controller']  = 'vendors';
        $this->view('admin/vendor.edit', $data);
    }

    public function delete($vendor_id): void
    {
        $vendor = new Vendor;
        $vendor->deleteVendor($vendor_id);
        redirect('admin/vendors'); 
    }
}