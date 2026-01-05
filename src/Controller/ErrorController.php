<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends AbstractController
{
    #[Route(path: '/access_denied', name: 'error_403')]
    public function error_403()
    {
        return $this->render('bundles\TwigBundle\Exception\error403.html.twig');
    }
}
