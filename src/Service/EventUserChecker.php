<?php
namespace App\Service;

class EventUserChecker {

    public function checkIfEventCreatedByUser($user, $event) {
        if ($user == $event->getUser()) { #On vérifie si l'utilisateur a créé la séance
            return true;
        }
        elseif (in_array('ROLE_ADMIN', $user->getRoles())) { #ou si c'est un administrateur
            return true;
        }
    }

}