<?php

namespace App\DataFixtures;

use App\Project\Domain\User\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    const TEST_USER = 'test-user';
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();

        $user = new User();
        $user->setUsername($faker->userName);
        $user->setEmail("user@example.com");
        $user->setPassword(sha1('secret'));

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::TEST_USER, $user);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }

}
