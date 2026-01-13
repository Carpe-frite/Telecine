<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{    

    public const EVENT1_REFERENCE = 'event';
    public const EVENT2_REFERENCE = 'user2';

    public function load(ObjectManager $manager): void
    {

        $user = $this->getReference(UserFixtures::ADMIN_USER1_REFERENCE, User::class);
        $user2 = $this->getReference(UserFixtures::ADMIN_USER2_REFERENCE, User::class);

        $event0= new Event();
        $event0->setEventName('Séance archivée');
        $event0->setEventDate(new \DateTime('2025-05-05 12:15:00'));
        $event0->setEventMovie('Une soirée étrange');
        $event0->setEventMoviePicture('https://image.tmdb.org/t/p/w600_and_h900_face/VGt38MnKByK3NuKMQq66TrZ0uA.jpg');
        $event0->setEventMovieGenre('Drame');
        $event0->setEventMovieYear(new \DateTime('2003-06-05'));
        $event0->setEventStart(new \DateTime('2025-06-05 12:15:00'));
        $event0->setEventEnd(new \DateTime('2025-06-05 15:15:00'));
        $event0->setEventDetail('Dans une région reculée du Pays de Galles, cinq voyageurs assaillis par une tempête incessante trouvent refuge dans un vieux manoir..');
        $event0->setEventMaxParticipants(5);
        $event0->setEventIsValidated(true);
        $event0->setEventIsArchived(true);
        $event0->setUser($user2);
        $manager->persist($event0);

        $event= new Event();
        $event->setEventName('Séance cinéma');
        $event->setEventDate(new \DateTime('2025-06-05 12:15:00'));
        $event->setEventMovie('Metropolis');
        $event->setEventMoviePicture('https://media.themoviedb.org/t/p/w300_and_h450_face/vHDWZOpupmKB7iNuiWFqnUSjfmN.jpg');
        $event->setEventMovieGenre('Science-fiction');
        $event->setEventMovieYear(new \DateTime('2003-06-05'));
        $event->setEventStart(new \DateTime('2025-06-05 12:15:00'));
        $event->setEventEnd(new \DateTime('2025-06-05 15:15:00'));
        $event->setEventDetail('En 2026, une métropole à l’architecture fantastique vit sous le joug d’un groupe de tyrans. Les aristocrates se prélassent et se divertissent dans de somptueuses demeures et de luxuriants jardins, tandis que la grande masse de la population travaille, dort et survit durement dans les profondeurs de la terre. Le fils du maître de la ville découvre avec effarement l’existence du monde souterrain, où se rencontrent en secret les ouvriers, peu enclins à supporter pour toujours leur situation. Pendant ce temps, un savant invente une femme‐robot qui doit détourner les opprimés de leur révolte…');
        $event->setEventMaxParticipants(5);
        $event->setEventIsValidated(true);
        $event->setEventIsArchived(false);
        $event->setUser($user);
        $manager->persist($event);

        $event2= new Event();
        $event2->setEventName('Autre séance');
        $event2->setEventDate(new \DateTime('2025-07-05 12:15:00'));
        $event2->setEventMovie('Le Fantôme de L\'Opéra');
        $event2->setEventMoviePicture('https://media.themoviedb.org/t/p/w300_and_h450_face/3p1n38hiQgxlB56Ci8LF4vRQJ5k.jpg');
        $event2->setEventMovieGenre('Horreur');
        $event2->setEventMovieYear(new \DateTime('2003-06-05'));
        $event2->setEventStart(new \DateTime('2025-07-05 12:15:00'));
        $event2->setEventEnd(new \DateTime('2025-06-07 15:15:00'));
        $event2->setEventDetail('La prometteuse soprano Christine Dubois est une jeune femme très courtisée, à la fois par le chanteur lyrique Anatole Garron et l\'inspecteur Raoul D\'Aubert. Mais elle a également un prétendant secret, ancien violoniste de l\'Opéra de Paris défiguré par une projection d\'acide, qui hante les catacombes de l\'édifice...');
        $event2->setEventMaxParticipants(5);
        $event2->setEventIsValidated(true);
        $event2->setEventIsArchived(false);
        $event2->setUser($user);
        $manager->persist($event2);

        $event3= new Event();
        $event3->setEventName('Encore une séance');
        $event3->setEventDate(new \DateTime('2025-07-05 12:15:00'));
        $event3->setEventMovie('Le 13ème Guerrier');
        $event3->setEventMoviePicture('https://media.themoviedb.org/t/p/w300_and_h450_face/2L8OCwCcZ1F12P2Knm2zGTeYoJc.jpg');
        $event3->setEventMovieGenre('Action');
        $event3->setEventMovieYear(new \DateTime('2003-06-05'));
        $event3->setEventStart(new \DateTime('2025-07-05 12:15:00'));
        $event3->setEventEnd(new \DateTime('2025-06-07 15:15:00'));
        $event3->setEventDetail('Contraint à l\'exil par son calife, pour avoir séduit la femme d\'un autre, Ahmed Ibn Fahdlan est envoyé comme ambassadeur en Asie mineure. Une prophétie l\oblige à devenir le "13ème Guerrier" d\'un groupe de Vikings allant porter secours au seigneur Rothgar, dont le village est régulièrement attaqué par une horde de démons, mi-humains mi-animaux. Au cours de ce long périple vers le Nord de l\'Europe, Ahmed apprend la langue de ses compagnons et le maniement des armes. Sur place, il devra affronter ses propres peurs.');
        $event3->setEventMaxParticipants(5);
        $event3->setEventIsValidated(true);
        $event3->setEventIsArchived(false);
        $event3->setUser($user2);
        $manager->persist($event3);

        $manager->flush();

        $this->addReference(self::EVENT1_REFERENCE, $event);
        $this->addReference(self::EVENT2_REFERENCE, $event2);
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}