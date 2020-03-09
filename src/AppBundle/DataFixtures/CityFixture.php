<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\City;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;
use Faker\Factory;

class CityFixture extends Fixture
{
    /** @var Generator */
    protected $faker;

    public function load(ObjectManager $manager)
    {
        $this->faker = Factory::create();

        // create 20 Country!
        for ($i = 0; $i < 20; $i++) {
            $city = new City();
            $city->setName($this->faker->city);
            $city->setCountry('eg');

            $manager->persist($city);
        }

        $manager->flush();
    }
}
