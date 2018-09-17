<?php

namespace MyHammer\Api\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use MyHammer\Api\Entity\City;

/**
 * Class CityFixtures
 * @package MyHammer\Api\DataFixtures
 */
class CityFixtures extends Fixture
{
    /** @var array */
    private $fixtures = [
        [
            'zip' => '10115',
            'name' => 'Berlin'
        ],
        [
            'zip' => '32457',
            'name' => 'Porta Westfalica'
        ],
        [
            'zip' => '01623',
            'name' => 'Lommatzsch'
        ],
        [
            'zip' => '21521',
            'name' => 'Hamburg'
        ],
        [
            'zip' => '06895',
            'name' => 'Bülzig'
        ],
        [
            'zip' => '01612',
            'name' => 'Diesbar-Seußlitz'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->fixtures as $fixture) {
            $city = new City();
            $city
                ->setZip($fixture['zip'])
                ->setName($fixture['name']);

            $manager->persist($city);
        }

        $manager->flush();
    }
}
