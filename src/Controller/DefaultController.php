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

    #[Route('/sign-up', name: 'sign_up', methods: ['GET'])]
    public function signUp()
    {
        return $this->render('default/sign-up.html.twig');
    }

    #[Route('/categorie/{type}', name: 'default_category', methods: ['GET'])]
    public function category($type)
    {
        return new Response(content: "<h1>Catégorie : $type</h1>");
    }

    #[Route('/{category}/{title}_{id}', name: 'default_event', methods: ['GET'])]
    public function event($category,$title,$id)
    {
        return new Response(content: "<h1>Catégorie : $category<br>Titre : $title<br>ID : $id </h1>");
    }
}


