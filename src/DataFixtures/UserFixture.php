<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            $user->setRoles('ROLE_USER');
            $user->setFirstName($this->faker->firstName);
            $user->setLastName($this->faker->lastName);
            $user->setPhone(intval($this->faker->phoneNumber));
            $user->setCreated($this->faker->dateTimeThisYear);

            // Add additional associations or modifications if needed
            // For example, to set a user's car:
            // $car = new Car();
            // $car->setOwner($user);
            // $user->setUserCar($car);

            $manager->persist($user);
        }

        $manager->flush();
    }
}

?>




