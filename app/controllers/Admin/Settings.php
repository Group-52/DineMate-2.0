<?php

namespace controllers\Admin;

use core\Controller;
use models\GeneralDetails;

class Settings
{
    use Controller;

    public function index(): void
    {
        $m = new GeneralDetails();
        $m->getDetails();
        $data['details'] = $m->getDetails();
        $data['controller'] = 'settings';
        $this->view('admin/settings', $data);
    }

    public function update(): void
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $m = new GeneralDetails();
            $m->updateDetails($_POST);
            redirect('admin/settings');
        }
    }

    public function updateAppearance():void{
        //TODO:form processing of images
    }




}
