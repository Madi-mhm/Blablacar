<?php

namespace App\DataFixtures;

use App\Entity\Rule;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RuleFixture extends AbstractFixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {

            $rule = new Rule();
            $rule->setName($this->faker->name());
            $rule->setDescription($this->faker->sentence());

            $rule->setAuthor($this->getReference("owner_" . $this->faker->numberBetween(0, 9)));
            $this->setReference('rule_' . $i, $rule);

            $manager->persist($rule);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixture::class,
        ];
    }
}