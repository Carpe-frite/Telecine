<?php

namespace App\Tests;

use App\Repository\UserRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLoginAsUser(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findUserByEmail('dscully@telecine.fr');

        $client->loginUser($testUser);
        $client->request('GET', '/user-profile'); /* Si l'utilisateur est connecté, alors il peut accéder à cette page */

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue Dana Scully');
    }
}
