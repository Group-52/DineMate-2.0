<?php

namespace controllers\admin;

use core\Controller;
use models\Dish;

/**
 * Class Dishes
 */
class Dishes
{
    use Controller;

    public function index(): void
    {
        $dish = new Dish();
        $results['dish_list'] = $dish->getDishes();
        $results['controller'] = 'dishes';

        $this->view('admin/dishes', $results);

    }

    public function addDish(): void
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $preptime = $_POST['preptime'];
            $netprice = $_POST['netprice'];
            $sellprice = $_POST['sellprice'];
            $description = $_POST['description'];
            $file = $_FILES["fileToUpload"];

            
            // Check if image field is empty
            if ($file['size'] != 0) {                
                $target_dir = '../public/assets/images/dishes/';
    
                if (isImage($file) && isValidSize($file, 5000000) && isImageType($file)) {
    
                    // 	// Set path to store the uploaded image
                    $target_file = getFileName($name, $file);
    
                    if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            $d = new Dish;
            $data = [
                'name' => $name,
                'net_price' => $netprice,
                'selling_price' => $sellprice,
                'description' => $description,
                'prep_time' => $preptime,
                'image_url' => $target_file ?? null,
            ];
            // remove empty and null values
            $data = array_filter($data, function ($value) {
                return $value !== null && $value !== '';
            });

            $d->addDish($data);

            redirect('admin/dishes');

        }
        $this->view('admin/dishes.add');
    }

    public function delete($dish_id): void
    {
        $dish = new Dish;
        $results['dish'] = $dish->deleteDish($dish_id);
        redirect('admin/dishes'); 
            
    }

}

