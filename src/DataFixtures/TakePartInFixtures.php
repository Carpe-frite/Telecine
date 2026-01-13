<?php

namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\EventFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Entity\Event;
use App\Entity\TakePartIn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TakePartInFixtures extends Fixture implements DependentFixtureInterface
{    

    public function load(ObjectManager $manager): void
    {

        $event = $this->getReference(EventFixtures::EVENT1_REFERENCE, Event::class);
        $user2 = $this->getReference(UserFixtures::ADMIN_USER2_REFERENCE, User::class);

        $takePartIn = new TakePartIn();
        $takePartIn->setEvent($event);
        $takePartIn->setUser($user2);
        $takePartIn->setUserHasConfirmed(true);
        $manager->persist($takePartIn);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class, EventFixtures::class,
        ];
    }
}