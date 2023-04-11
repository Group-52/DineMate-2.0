<?php

namespace controllers\admin;

use core\Controller;
use models\Promotion;
use models\Dish;

class Promotions
{
    use Controller;

    public function index(): void
    {

        $data = [];
        $data['controller'] = 'promotions';

        $p = new Promotion();
        $d = new Dish();

        $data['dishes'] = $d->getDishes();
        $data['discount'] = $p->getDiscounts();
        $data['spending_bonus'] = $p->getSpendingBonus();
        $data['free_dish'] = $p->getFreeDish();

        $this->view('admin/promotions', $data);
    }

    public function delete(): void
    {
        $p = new Promotion();
        $p->deletepromo($_GET['promoid']);
        redirect('admin/promotions');
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $name = $_POST['title'];
            $file = $_FILES["promo_image"];
            if ($file['size'] != 0) {
                $target_dir = APP_DIR . '/../public/assets/images/promotions/';
                if (isImage($file) && isValidSize($file, 5000000) && isImageType($file)) {

                    // 	// Set path to store the uploaded image
                    $target_file = getFileName($name, $file);

                    if (!move_uploaded_file($_FILES["promo_image"]["tmp_name"], $target_dir . $target_file)) {
                        echo "Sorry, there was an error uploading your file.";
                    }
                }
            }
            $_POST['image_url'] = $target_file;
            $p = new Promotion();
            $p->addpromotion($_POST);
            redirect('admin/promotions');
        } else {
            redirect('admin/promotions');
        }
    }

    public function edit(): void{
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $p = new Promotion();
            $p->editpromo($_POST);
        }
        redirect('admin/promotions');
    }
}
