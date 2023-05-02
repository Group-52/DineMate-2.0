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
        if (!isset($_SESSION['user'])) {
            $guest = new \models\Guest();
            $guestId = $guest->createGuest(null, null, null, null);
            $this->createSessionGuest($guestId);
            $this->json([
                'status' => 'success',
                'message' => 'Guest created',
                'guestId' => $guestId
            ]);
        } else if (!$_SESSION['user']->registered) {
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

    public function get($guest_id): void
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
    }

}