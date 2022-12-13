<?php

// dish class

class Dishes
{
    use Controller;

    public function index()
    {
        $dish = new Dish;
        $results['dishlist'] = $dish->getDishes();

        $this->view('dishes', $results);

    }

    public function addDish()
    {
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $preptime = $_POST['preptime'];
            $netprice = $_POST['netprice'];
            $sellprice = $_POST['sellprice'];
            $description = $_POST['description'];
            $file = $_FILES["fileToUpload"];

            $target_dir = '../public/assets/images/dishes/';

            if (isImage($file) && isValidSize($file, 5000000) && isImageType($file)) {

                // 	// Set path to store the uploaded image
                $target_file = getFileName($name, $file);

                if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $target_file)) {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            $d = new Dish;
            $d->addDish([
                'name' => $name,
                'net_price' => $netprice,
                'selling_price' => $sellprice,
                'description' => $description,
                'prep_time' => $preptime,
                'image_url' => $target_file
            ]);

            redirect('dishes');

        }
        $this->view('adddish');
    }

}

