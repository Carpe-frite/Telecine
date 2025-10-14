<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Enum\User_Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user= new User();
        $user->setUserName('JeanAdmin67');
        $user->setUserEmail('jeanadmin67@wanadoo.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('okok1234');
        $user->setUserXP(0);
        $user->setUserStatus(User_status::active);
        $manager->persist($user);


        for ($i = 0; $i < 20; $i++) {
            $event= new Event();
            $event->setEventName('Séance '.$i);
            $event->setEventDate(new \DateTime('2011-06-05 12:15:00'));
            $event->setEventMovie('The Day After Tomorrow');
            $event->setEventMovieYear(new \DateTime('2003-06-05'));
            $event->setEventStart(new \DateTime('2025-06-05 12:15:00'));
            $event->setEventEnd(new \DateTime('2025-06-05 15:15:00'));
            $event->setEventDetail('Le climatologue Jack Hall avait prédit l’arrivée d’un autre âge de glace, mais n’avait jamais pensé que cela se produirait de son vivant. Un changement climatique imprévu et violent à l’échelle mondiale entraîne à travers toute la planète de gigantesques ravages : inondations, grêle, tornades et températures d’une magnitude inédite. Jack a peu de temps pour convaincre le président des États-Unis d’évacuer le pays pour sauver des millions de personnes en danger, dont son fils Sam bloqué à New York par -70°C...');
            $event->setEventMaxParticipants(5);
            $event->setEventIsValidated(true);
            $event->setUser($user);
            $manager->persist($event);
        }

        $manager->flush();
    }
}