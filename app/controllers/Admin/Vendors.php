<?php

namespace controllers\admin;

use core\Controller;
use Exception;
use models\Vendor;
// vendor class

class Vendors
{
    use Controller;

    public function index()
    {
        $vendor = new Vendor;
        $results['Vendor'] = $vendor->getVendors();      
        $this->view('admin/vendor', $results);
    }

    public function addVendor(): void
    {
        if(isset($_POST['save'])){
			$name = $_POST['name'];
			$address = $_POST['address'];
			$company = $_POST['company'];
			$contact_no = $_POST['contact_no'];

			$vendor = new Vendor;
			$vendor ->addVendor([
				'name'=> $name,
				'address'=> $address,
				'company'=> $company,
                'contact_no'=> $contact_no
			]);

            redirect('admin/vendors');

        }
        $this->view('admin/vendor.add');
    }

    public function edit($vendor_id): void
    {
        $vendor = new Vendor;
        $results['vendor'] = $vendor->getVendors($vendor_id);
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            show($_POST);
            $vendor = new Vendor;
            $vendor->editVendor($_POST);
            redirect('admin/vendors');
        }
        $this->view('admin/vendor.edit', $results);
    }
}