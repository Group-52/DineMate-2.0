<?php

namespace controllers\admin;

use core\Controller;
use models\FeedbackModel;

/**
 * Class Feedback
 */
class Feedback 
{
    use Controller;

    public function index(): void
    {
        $f = new FeedbackModel();
        $data['feedback_list'] = $f->getFeedback();
        $data['controller'] = 'feedback';

        $this->view('admin/feedback', $data);

    }

}

