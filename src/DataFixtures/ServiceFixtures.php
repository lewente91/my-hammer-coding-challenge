<?php

namespace MyHammer\Api\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use MyHammer\Api\Entity\Service;

/**
 * Class ServiceFixtures
 * @package MyHammer\Api\DataFixtures
 */
class ServiceFixtures extends Fixture
{
    /** @var array */
    private $fixtures = [
        [
            'id' => 804040,
            'name' => 'Sonstige Umzugsleistungen'
        ],
        [
            'id' => 802030,
            'name' => 'Abtransport, Entsorgung und Entrümpelung'
        ],
        [
            'id' => 411070,
            'name' => 'Fensterreinigung'
        ],
        [
            'id' => 402020,
            'name' => 'Holzdielen schleifen'
        ],
        [
            'id' => 108140,
            'name' => 'Kellersanierung'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        /** @var ClassMetadata $metadata */
        $metadata = $manager->getClassMetaData(Service::class);
        $metadata->setIdGenerator(new AssignedGenerator());
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);

        foreach ($this->fixtures as $fixture) {
            $service = new Service();
            $service
                ->setId($fixture['id'])
                ->setName($fixture['name']);

            $manager->persist($service);
        }

        $manager->flush();
    }
}
