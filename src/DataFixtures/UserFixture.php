<?php

namespace MyHammer\Api\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use MyHammer\Api\Entity\User;

/**
 * Class UserFixture
 * @package MyHammer\Api\DataFixtures
 */
class UserFixture extends Fixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('levente.molnar91');

        $manager->persist($user);
        $manager->flush();
    }
}
