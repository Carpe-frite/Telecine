<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Enum\User_Role;
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


        // create 20 events! Bam!
        for ($i = 0; $i < 20; $i++) {
            $event= new Event();
            $event->setEventName('Séance '.$i);
            $event->setEventDate(new \DateTime('2011-06-05 12:15:00'));
            $event->setEventMovie('The Day After Tomorrow');
            $event->setEventStart(new \DateTime('2011-06-05 12:15:00'));
            $event->setEventEnd(new \DateTime('2011-06-05 15:15:00'));
            $event->setEventMaxParticipants(5);
            $event->setEventIsValidated(true);
            $event->setUser($user);
            $manager->persist($event);
        }

        $manager->flush();
    }
}