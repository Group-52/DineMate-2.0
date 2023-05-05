<?php

namespace controllers\admin;

use core\Controller;

/**
 * Class Feedback
 */
class Feedback 
{
    use Controller;

    public function index(): void
    {
        $f = new \models\Feedback();
        $data['feedback_list'] = $f->getFeedback();
        $data['controller'] = 'feedback';

        $this->view('admin/feedback', $data);
    }
}

