<?php

// vendor class

class Vendors
{
    use Controller;

    public function index()
    {
        echo "HII";
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

            redirect('./vendors/vendor');

        }
        $this->view('vendor.add');
    }

    public function vendor(): void
    {
        $vendor = new Vendor;
        $results['Vendor'] = $vendor->getVendors();
        
        $this->view('vendor', $results);
    }
}