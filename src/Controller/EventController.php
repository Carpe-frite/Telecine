<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\TakePartIn;
use App\Entity\User;
use App\Form\EventFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EventController extends AbstractController
{
    #[Route('/create-event', name: 'event_create_event', methods: ['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        //$event->setEventName('Nom de votre évènement');

        $form = $this->createForm(EventFormType::class, $event);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $event= $form->getData();

            $user = $this->getUser();
            $event->setUser($user);

            if (in_array("ROLE_ADMIN", $user->getRoles())) {
                $event->setEventIsValidated(true);
            }
            else {
                $event->setEventIsValidated(false);
            }

            $entityManager->persist($event);
            $entityManager->flush();    

            $eventParticipation = new TakePartIn();
            $eventParticipation->setUser($user);
            $eventParticipation->setEvent($event);
            $eventParticipation->setUserHasConfirmed(true);

            $entityManager->persist($eventParticipation);
            $entityManager->flush($eventParticipation);

            return $this->redirectToRoute('default_see_all_events');
        }

        return $this->render('default/create-event.html.twig', [
            'eventForm' => $form,
        ]);

    }

    #[Route('/show-event-{id}', name: 'event_show_event', methods: ['GET'])]
    public function showEvent(int $id, EntityManagerInterface $entityManager):Response
    {    

        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }

        return $this->render('event/event-detail.html.twig', ['event' => $event]);
    }

    #[Route('/edit-event-{id}', name: 'event_edit_event', methods: ['GET', 'POST'])]
    public function editEvent(Request $request, int $id, EntityManagerInterface $entityManager):Response
    {    

        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }

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

    #[Route('/delete-event-{id}', name: 'event_delete_event', methods: ['GET'])]
    public function deleteEvent(int $id, EntityManagerInterface $entityManager):Response
    {    
        $event = $entityManager->getRepository(Event::class)->find($id);

        if (!$event) {
            $this->addFlash('Séance introuvable', "Cette séance n'existe pas");
            return $this->redirectToRoute('default_see_all_events');
        }
        else {
            if ($this->getUser() == $event->getUser() || $this->isGranted('ROLE_ADMIN')) { //On s'assure que seul l'utiisateur (ou un admin) ayant créé l'event puisse le supprimer
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
    public function takePartInEvent(int $id, bool $confirm, EntityManagerInterface $entityManager):Response
    {    
        $user = $this->getUser();
        $event = $entityManager->getRepository(Event::class)->find($id);

        $eventParticipation = new TakePartIn();
        $eventParticipation->setUser($user);
        $eventParticipation->setEvent($event);
        $eventParticipation->setUserHasConfirmed($confirm.(boolval("true") ? 'true' : 'false'));

        $entityManager->persist($eventParticipation);
        $entityManager->flush($eventParticipation);

        return $this->redirectToRoute('event_show_event', ['id' => $id]);

    }

}