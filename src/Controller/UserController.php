<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
        public function new(Request $request): Response    {
        $user = new User();
        $user->setUserName();
        $user->setUserEmail();
        $user->setUserDob();
        $user->setUserCountry();
        $user->setUserPassword();

        $form = $this->createFormBuilder($user)
            ->add('userName', TextType::class)
            ->add('userEmail', TextType::class)
            ->add('userDob', DateTimeType::class)
            ->add('userCountry', DateTimeType::class)
            ->add('save', SubmitType::class, ['label' => 'Créer mon compte'])
            ->getForm();
    }    
}


