<?php
namespace App\Service;
use App\Entity\TakePartIn;

class postEventCreationTasksFulfiller {

    public function doPostCreationTasks($user, $event, $entityManager) {
            $event->setUser($user);
            $event->setIfAutoValidated($user);
            $event->setEventIsArchived(false);

            $eventParticipation = new TakePartIn();
            $eventParticipation->setUser($user);
            $eventParticipation->setEvent($event);
            $eventParticipation->setUserHasConfirmed(true);

            $entityManager->persist($event);
            $entityManager->persist($eventParticipation);
            $entityManager->flush();
    }


}