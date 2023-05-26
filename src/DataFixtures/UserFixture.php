<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractFixture
{
   
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $user = new User();
            $user->setEmail($this->faker->email());
            $user->setPassword($this->faker->password());
            $user->setRoles($this->faker->word());
            $user->setFirstName($this->faker->firstName());
            $user->setLastName($this->faker->lastName());
            $user->setPhone(intval($this->faker->phoneNumber()));
            $user->setCreated($this->faker->dateTime());

            $manager->persist($user);
            $this->setReference('owner_' . $i, $user);
        }

        $manager->flush();
    }
}