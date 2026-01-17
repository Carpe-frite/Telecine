<?php
namespace App\Service;
use App\Entity\TakePartIn;
use Doctrine\ORM\EntityManagerInterface;

class PostEventCreationTasksHandler {

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function doPostCreationTasks($user, $event) {
            $event->setUser($user);
            $event->setIfAutoValidated($user);
            $event->setEventIsArchived(false);

            $eventParticipation = new TakePartIn();
            $eventParticipation->setUser($user);
            $eventParticipation->setEvent($event);
            $eventParticipation->setUserHasConfirmed(true);

            $this->entityManager->persist($event);
            $this->entityManager->persist($eventParticipation);
            $this->entityManager->flush();
    }
}