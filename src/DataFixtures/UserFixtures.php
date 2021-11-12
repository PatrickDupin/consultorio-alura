<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('usuario')
            ->setPassword('$2y$13$b4yn4yGoscNuBp0AmzsEiu9IDy6vhFVdCH9YXrPELeNN7J1WOs/TK');
        $manager->persist($user);
        $manager->flush();
    }
}
