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
        $this->view('addvendor');
    }

    public function vendor() 
    {
        $vendor = new Vendor;
        $results['Vendor'] = $vendor->getVendors();
        
        $this->view('vendor', $results);
    }

    // public function create(): void
    // {
    //     // if (!isset($_SESSION["user"])) {
    //     //     redirect("login");
    //     // }

    //     $data = [];
    //     if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //         $item = new Vendor();
    //         if ($item->validate($_POST)) {
    //             try {
    //                 $item->insert([
    //                     "name" => $_POST["name"],
    //                     "address" => $_POST["address"] ?? null,
    //                     "company" => $_POST["company"] ?? null,
    //                     "contact_no" => $_POST["contact_no"]
    //                 ]);
    //                 redirect("vendors");
    //             } catch (Exception $e) {
    //                 $data["error"] = "Unknown error.";
    //             }
    //         }
    //     }
    //     $data["controller"] = $this->controller;
    //     $this->view("addvendor", $data);
    // }

}