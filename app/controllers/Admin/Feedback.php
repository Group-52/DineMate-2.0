<?php

namespace controllers\admin;

use core\Controller;
use models\Feedback;

/**
 * Class Feedback
 */
class Feedback 
{
    use Controller;

    public function index(): void
    {
        $f = new Feedback();
        $data['feedback_list'] = $f->getFeedback();
        $data['controller'] = 'feedback';

        $this->view('admin/feedback', $data);

    }

}

