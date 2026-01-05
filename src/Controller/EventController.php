<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TakePartIn;
use App\Form\EventFormType;
use App\Service\EventUserChecker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/create-event', name: 'event_create_event', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
                    
        $form = $this->createForm(EventFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event= $form->getData();
            $user = $this->getUser();
            $event->setUser($user);
            $event->setIfAutoValidated($user);
            $entityManager->persist($event);
            $entityManager->flush();    

            $eventParticipation = new TakePartIn();
            $eventParticipation->setUser($user);
            $eventParticipation->setEvent($event);
            $eventParticipation->setUserHasConfirmed(true);

            $entityManager->persist($eventParticipation);
            $entityManager->flush();

            return $this->redirectToRoute('default_see_all_events');
        }        
        return $this->render('default/create-event.html.twig', ['eventForm' => $form, ]);
    }

    #[Route('/show-event-{id}', name: 'event_show_event', methods: ['GET'])]
    public function showEvent(int $id, EntityManagerInterface $entityManager):Response
    {    

        $event = $entityManager->getRepository(Event::class)->find($id);
        /** @var \App\Entity\User|null $user */
        $user = $this->getUser();

        $isParticipantofEvent = false;
        $isHostofEvent = false;
        $isAdmin = false;

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }

        if ($user){
            $isParticipantofEvent = $event->getIfParticipantOfEvent($user);
            $isHostofEvent = $event->getIfHostOfEvent($user);
            $isAdmin = $user->getIfAdmin();
        }

        return $this->render('event/event-detail.html.twig', ['event' => $event, 'isAdmin' => $isAdmin, 'isHost' => $isHostofEvent, 'isParticipant' => $isParticipantofEvent]);
    }                              

    #[Route('/edit-event-{id}', name: 'event_edit_event', methods: ['GET', 'POST'])]
    public function editEvent(Request $request, int $id, EntityManagerInterface $entityManager, EventUserChecker $eventUserChecker):Response
    {    

        $event = $entityManager->getRepository(Event::class)->find($id);
        $user = $this->getUser();

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        } 
        if (!$eventUserChecker->checkIfEventCreatedByUser($user,$event)) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }
        else {
            $form = $this->createForm(EventFormType::class, $event);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $event= $form->getData();

                $entityManager->flush();    
                $this->addFlash('Séance modifiée', "La séance a été modifiée avec succès");
                return $this->redirectToRoute('default_see_all_events');
            }

            return $this->render('event/edit-event.html.twig', ['event' => $event, 'eventForm' => $form]);
        }
        
    }

    #[Route('/validate-event-{id}', name: 'event_validate_event', methods: ['GET', 'POST'])]
    public function validateEvent(int $id, EntityManagerInterface $entityManager):Response
    {    

        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }

        $event->setEventIsValidated(true);
        $entityManager->flush();    
        $this->addFlash('Séance validée', "La séance a été validée avec succès");
        return $this->redirectToRoute('default_admin');        
    }

    #[Route('/delete-event-{id}', name: 'event_delete_event', methods: ['GET'])]
    public function deleteEvent(int $id, EntityManagerInterface $entityManager):Response
    {    
        $event = $entityManager->getRepository(Event::class)->find($id);
        $user = $this->getUser();

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }
        if ($user != $event->getUser()) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }
        else {
            if ($event->checkIfCanDelete($user)) { //On s'assure que seul l'utiisateur (ou un admin) ayant créé l'event puisse le supprimer
                $entityManager->remove($event);
                $entityManager->flush();
                return $this->redirectToRoute('default_see_all_events');
            }
            else {
                return $this->redirectToRoute('default_see_all_events');
            }
        }
    }

    #[Route('/take-part-in-event-{id}/{confirm}', name: 'event_take_part_in_event', methods: ['GET', 'POST'])]
    public function takePartInEvent(int $id, string $confirm, EntityManagerInterface $entityManager):Response
    {    
        $user = $this->getUser();
        $event = $entityManager->getRepository(Event::class)->find($id);

        $eventParticipation = new TakePartIn();
        $eventParticipation->setUser($user);
        $eventParticipation->setEvent($event);
        $eventParticipation->setUserHasConfirmed($confirm === 'true');

        $entityManager->persist($eventParticipation);
        $entityManager->flush();

        return $this->redirectToRoute('event_show_event', ['id' => $id]);

    }

}