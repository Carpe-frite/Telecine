<?php

namespace App\Tests;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DisplayEventsCertainGenreTest extends WebTestCase
{
    public function testDisplayEventsCertainGenre(): void
    {
        $client = static::createClient();
        $eventRepository = static::getContainer()->get(EventRepository::class);

        $testHorrorEvent = $eventRepository->findOneEventByGenre('Horreur'); /* On tente d'afficher un event étiquetté avec le genre horreur */

        $crawler = $client->request('GET', '/see-all-events');
        $crawler = $client->request('GET', '/get-events-filtered', ['genres' =>['Horreur']]);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h4', 'Autre séance'); /* Dans les data fixture, la séance étiquettée Horreur s'appelle Autre séance */
    }
}
