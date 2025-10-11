<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\EventRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home()
    {
        return $this->render('default/home.html.twig');
    }

    #[Route('/admin', name: 'default_admin', methods: ['GET'])]
    public function admin()
    {
        return $this->render('default/admin.html.twig');
    }

    #[Route('/about', name: 'default_about', methods: ['GET'])]
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    #[Route('/see-all-events', name: 'default_see_all_events', methods: ['GET'])]
    public function seeAllEvents(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAll();
        return $this->render('default/see-all-events.html.twig', ['events' => $events]);
    }
}


