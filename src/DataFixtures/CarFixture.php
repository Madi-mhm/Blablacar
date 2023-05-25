<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $car = new Car();
            $car->setBrand($this->faker->brand);
            $car->setModel($this->faker->model);
            $car->setSeats($this->faker->seats);
            $car->setCreated($this->faker->created);
           

        

            $manager->persist($user);
        }

        $manager->flush();
    }
}

?>




