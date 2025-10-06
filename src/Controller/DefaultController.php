<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default_home', methods: ['GET'])]
    public function home()
    {
        //return new Response(content: '<h1>Yo wie geht\'s???</h1>');
        return $this->render(view: 'default/home.html.twig');
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


