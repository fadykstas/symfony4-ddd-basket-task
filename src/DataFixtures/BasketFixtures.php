<?php

namespace App\DataFixtures;

use App\Project\Domain\Basket\Entity\Basket\Basket;
use App\Project\Domain\Basket\Entity\Basket\BasketId;
use App\Project\Domain\Basket\Entity\Basket\BasketName;
use App\Project\Domain\Basket\Entity\Item\Item;
use App\Project\Domain\Basket\Entity\Item\ItemId;
use App\Project\Domain\Basket\Entity\Item\ItemType;
use App\Project\Domain\Basket\Entity\Weight\Weight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class BasketFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; null) {
            $basket = new Basket(
                BasketId::generate(),
                new BasketName('Basket #'.++$i),
                new Weight($faker->numberBetween(300,500))
            );

            $items = [];
            for ($x = 0; $x < 20; $x++) {
                $item = new Item(
                    ItemId::generate(),
                    new ItemType($faker->randomElement(ItemType::ALLOWED_TYPES)),
                    new Weight($faker->numberBetween(5,15)),
                    $basket
                );
                $items[] = $item;
            };
            $basket->addContents(...$items);

            $manager->persist($basket);
            $manager->flush();

        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
