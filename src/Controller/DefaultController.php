<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\EventRepository;
use App\Repository\TakePartInRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home(EventRepository $eventRepository, AuthenticationUtils $authenticationUtils)
    {

        $lastUsername = $authenticationUtils->getLastUsername();
        $events = $eventRepository->findNewlyAddedEvents(3);

        return $this->render('default/home.html.twig', ['last_username' => $lastUsername,'events' => $events]);
    }

    #[Route('/admin', name: 'default_admin', methods: ['GET'])]
    public function admin(EventRepository $eventRepository)
    {
        $events = $eventRepository->findBy(['event_is_validated' => false], ['event_date' => 'DESC']);
        $allMoviegenres = $eventRepository->findAllGenresInEventMovies();
        return $this->render('default/admin.html.twig', ['events' => $events, 'movie_genres' => $allMoviegenres]);
    }

    #[Route('/my-events', name: 'default_my_events', methods: ['GET'])]
    public function myEvents(EventRepository $eventRepository)
    {
        $user = $this->getUser();
        $events = $eventRepository->findEventsITakePartIn($user);
        $allMoviegenres = $eventRepository->findAllGenresInEventMovies();
        return $this->render('default/my_events.html.twig', ['events' => $events, 'movie_genres' => $allMoviegenres]);
    }

    #[Route('/about', name: 'default_about', methods: ['GET'])]
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    #[Route('/see-all-events', name: 'default_see_all_events', methods: ['GET'])]
    public function seeAllEvents(EventRepository $eventRepository)
    {
        $events = $eventRepository->findAllValidatedEvents();
        $allMoviegenres = $eventRepository->findAllGenresInEventMovies();
        return $this->render('default/see-all-events.html.twig', ['events' => $events, 'movie_genres' => $allMoviegenres]);
    }

    #[Route('/get-events-filtered', name: 'default_get_events_filtered', methods: ['GET'])]
    public function seeEventsFiltered(EventRepository $eventRepository, Request $request)
    {
        $fetched_genre = $request->query->all();
        if (!empty($fetched_genre)) {
             $events = $eventRepository->findEventsByGenre($fetched_genre);
        }
        else {
            $events = $eventRepository->findAllValidatedEvents();
        }
        
        return $this->render('partials/_filtered_event_view.html.twig', ['events' => $events]);
   }
}


