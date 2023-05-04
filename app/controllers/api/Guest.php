<?php

namespace controllers\api;

use core\Controller;

class Guest
{
    use Controller;

    function createSessionGuest($guestId): void
    {
        $_SESSION['user'] = new \stdClass();
        $_SESSION['user']->user_id = $guestId;
        $_SESSION['user']->registered = false;
    }

    public function create(): void
    {
        if (isNotLoggedIn()) {
            $guest = new \models\Guest();
            $guestId = $guest->createGuest(null, null, null, null);
            $this->createSessionGuest($guestId);
            $this->json([
                'status' => 'success',
                'message' => 'Guest created',
                'guestId' => $guestId
            ]);
        } else if (isGuest()) {
            $this->json([
                'status' => 'success',
                'message' => 'Guest already created',
                'guestId' => $_SESSION['user']->user_id
            ]);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'User already registered'
            ]);
        }
    }

    public function cashierCreateGuest(): void
    {
        $fName = $_GET['fname'];
        $contactNo = $_GET['contact'];
        $guest = new \models\Guest();
        $guestId = null;

        if (!isset($_SESSION['guest_id'])) {
            $guestId = $guest->createGuest($fName, null, $contactNo, null);
            $_SESSION['guest_id'] = $guestId;
        } else {
            $guestId = $_SESSION['guest_id'];
        }

        $this->json([
            'status' => 'success',
            'message' => 'Guest created',
            'guestId' => $guestId
        ]);
    }

    public function get($guest_id): void
    {
        if (!isRegistered())
        {
            $guest = new \models\Guest();
            $result = $guest->getGuestById($guest_id);
            if ($result) {
                $this->createSessionGuest($result->guest_id);
                $this->json([
                    'status' => 'success',
                    'message' => 'Guest found',
                    'guest' => $result
                ]);
            } else {
                $this->json([
                    'status' => 'error',
                    'message' => 'Guest not found'
                ]);
            }
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'User already registered'
            ]);
        }
    }

    public function update(): void
    {

        $post = json_decode(file_get_contents('php://input'));
        $guest = new \models\Guest();
        $guest_id = $post->guest_id;
        $fname = $post->fname ?? null;
        $lname = $post->lname ?? null;
        $contact = $post->contact ??null;
        $email = $post->email ?? null;
        $guest->updateGuest($guest_id,$fname, $lname, $contact, $email);
        $this->json([
            'status' => 'success',
            'message' => 'Guest updated'
        ]);

    }

}