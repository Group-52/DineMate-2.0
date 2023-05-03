<?php

namespace controllers\api;

use core\Controller;

class Guest
{
    use Controller;

    public function create(): void
    {
        if (isNotLoggedIn()) {
            $guest = new \models\Guest();
            $guestId = $guest->createGuest(null, null, null, null);
            createSessionGuest($guestId);
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

    public function get($guest_id): void
    {
        if (!isRegistered())
        {
            $guest = new \models\Guest();
            $result = $guest->getGuestById($guest_id);
            if ($result) {
                createSessionGuest($result->guest_id);
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

}