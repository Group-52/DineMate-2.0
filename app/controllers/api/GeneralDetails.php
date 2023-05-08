<?php

namespace controllers\api;

use core\Controller;

class GeneralDetails
{
    use Controller;

    public function get(): void
    {
        $general_details = new \models\GeneralDetails();
        $details = $general_details->getDetails();
        $this->json([
            'status' => 'success',
            'message' => 'General Details fetched',
            'details' => $details
        ]);
    }
}