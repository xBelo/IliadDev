<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();
        $products = $manager->getRepository(Products::class)->findAll();

        for ($i = 0; $i < 50; $i++) {
            $order = new Order();
            $order->setDate($faker->dateTimeThisYear());
            $order->setName('Order ' . $i+1);
            $order->setDescription($faker->randomElement(['pending', 'completed', 'shipped']));

            // Associa ordini a prodotti in modo casuale
            $orderProducts = [];
            for ($j = 0; $j < rand(1, 5); $j++) {
                $orderProducts[] = $faker->randomElement($products);
            }
            foreach ($orderProducts as $product) {
                $order->addProducts($product);
            }

            $manager->persist($order);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProductsFixtures::class,
        ];
    }
}