<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory as FakerFactory;

class ProductsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        for ($i = 0; $i < 20; $i++) {
            $product = new Products();
            $product->setName($faker->word);
            $product->setPrice($faker->randomFloat(2, 5, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}