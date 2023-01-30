<?php

namespace controllers\admin;

use core\Controller;
use models\Vendor;

/**
 * Vendors
 */
class Vendors
{
    use Controller;

    public function index(): void
    {
        $vendor = new \models\Vendor();
        $results['Vendor'] = $vendor->getVendors();
        $this->view('admin/vendor', $results);
    }

    public function addVendor(): void
    {
        if (isset($_POST['save'])) {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $company = $_POST['company'];
            $contact_no = $_POST['contact_no'];

            $vendor = new Vendor;
            $vendor->addVendor([
                'name' => $name,
                'address' => $address,
                'company' => $company,
                'contact_no' => $contact_no
            ]);

            redirect('admin/vendors');

        }
        $this->view('admin/vendor.add');
    }

    public function deleteVendor(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new Vendor();

            $data = json_decode(file_get_contents("php://input"), true);
            $name = $_POST['name'];
            $address = $_POST['address'];
            $company = $_POST['company'];
            $contact_no = $_POST['contact_no'];
        }
    }
}
