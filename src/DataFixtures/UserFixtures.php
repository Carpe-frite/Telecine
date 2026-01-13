<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\User_Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public const ADMIN_USER1_REFERENCE = 'user';
    public const ADMIN_USER2_REFERENCE = 'user2';

    public function load(ObjectManager $manager): void
    {

        $user= new User();
        $user->setUserName('George Costanza');
        $user->setUserEmail('gcostanza@telecine.fr');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('$2a$12$ynoP/G08cLv7QRCY.FK7u.wmxBW2ZujGo70I9pqS6o70FVNMFjM/q');
        $user->setUserXP(0);
        $user->setUserStatus(User_status::active);
        $manager->persist($user);

        $user2= new User();
        $user2->setUserName('Fox Mulder');
        $user2->setUserEmail('fmulder@telecine.fr');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword('$2a$12$ynoP/G08cLv7QRCY.FK7u.wmxBW2ZujGo70I9pqS6o70FVNMFjM/q');
        $user2->setUserXP(0);
        $user2->setUserStatus(User_status::active);
        $manager->persist($user2); 

        $user3= new User();
        $user3->setUserName('Dana Scully');
        $user3->setUserEmail('dscully@telecine.fr');
        $user3->setRoles(['ROLE_USER']);
        $user3->setPassword('$2a$12$ynoP/G08cLv7QRCY.FK7u.wmxBW2ZujGo70I9pqS6o70FVNMFjM/q');
        $user3->setUserXP(0);
        $user3->setUserStatus(User_status::active);
        $manager->persist($user3); 

        $manager->flush();

        $this->addReference(self::ADMIN_USER1_REFERENCE, $user);
        $this->addReference(self::ADMIN_USER2_REFERENCE, $user2);
    }
}