<?php

namespace controllers\api;

use core\Controller;
use models\Unit;

class Feedback
{
    use Controller;

    public function get(int $order_id): void
    {
        if (isset($_SESSION['user'])) {
            $feedback = new \models\Feedback();
            $data["feedback"] = $feedback->getFeedbackById($order_id, "order_id");
            $this->json($data);
        }
        else {
            $this->json([
                'status' => 'error',
                'message' => 'You must be logged in to view this page'
            ]);
        }
    }

    public function add(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                $post = json_decode(file_get_contents('php://input'));
                $order_id = $post->order_id;
                $rating = $post->rating;
                $description = $post->description;
                $feedback = new \models\Feedback();
                $feedback->addFeedback($_SESSION['user']->user_id, true, $order_id, $rating, $description);
                $this->json(["success" => true]);

            } else {
                $this->json([
                    'status' => 'error',
                    'message' => 'Please login to add items to cart'
                ]);
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }

    public function edit(int $feedbackId): void {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_SESSION['user'])) {
                $post = json_decode(file_get_contents('php://input'));
                $rating = $post->rating;
                $description = $post->description;
                $feedback = new \models\Feedback();
                $feedback->editFeedback($feedbackId, $rating, $description);
                $this->json(["success" => true]);
            } else {
                $this->json([
                    'status' => 'error',
                    'message' => 'Please login to add items to cart'
                ]);
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Invalid request method'
            ]);
        }
    }
}