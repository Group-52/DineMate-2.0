<?php

namespace controllers\admin;

use core\Controller;
use models\Menu;

/**
 * Dish Class
 */
class Menus
{
    use Controller;

    public function index(): void
    {
        $m = new Menu();
        $results['menulist'] = $m->getMenus();
        $this->view('menus', $results);
    }

    // public function addMenu(): void
    // {
    //     if (isset($_POST['submit'])) {
    //         $name = $_POST['name'];
    //         $preptime = $_POST['preptime'];
    //         $netprice = $_POST['netprice'];
    //         $sellprice = $_POST['sellprice'];
    //         $description = $_POST['description'];
    //         $file = $_FILES["fileToUpload"];

    //         $target_dir = '../public/assets/images/dishes/';

    //         $target_file = "";

    //         if (isImageType($file) && isValidSize($file, 5000000) && isImage($file)) {

    //             // 	// Set path to store the uploaded image
    //             $target_file = getFileName($name, $file);

    //             if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
    //                 echo "Sorry, there was an error uploading your file.";
    //             }
    //         }
    //         $d = new Dish;
    //         $d->adddish([
    //             'name' => $name,
    //             'net_price' => $netprice,
    //             'selling_price' => $sellprice,
    //             'description' => $description,
    //             'prep_time' => $preptime,
    //             'image_url' => $target_file
    //         ]);

    //         redirect('menus');

    //     }
    //     $this->view('addmenu');
    // }

}

