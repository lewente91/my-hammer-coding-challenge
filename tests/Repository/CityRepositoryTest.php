<?php

namespace MyHammer\Api\Tests\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Exception\EntityNotFoundException;
use MyHammer\Api\Repository\CityRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class CityRepositoryTest
 * @package MyHammer\Api\Tests\Repository
 */
class CityRepositoryTest extends TestCase
{
    const TEST_ZIP = 'TEST-ZIP-12345';

    /** @var EntityManagerInterface|PHPUnit_Framework_MockObject_MockObject */
    private $entityManager;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->entityManager = self::createMock(EntityManagerInterface::class);
    }

    /**
     * Test instance
     */
    public function testInstance(): void
    {
        $cityRepository = new CityRepository($this->entityManager);

        self::assertInstanceOf(CityRepository::class, $cityRepository);
    }

    /**
     * @return array
     */
    public function cityProvider(): array
    {
        /** @var City|PHPUnit_Framework_MockObject_MockObject $city */
        $city = $this->createMock(City::class);

        return [
            'City as NULL' => [
                'city' => null,
                'exception' => EntityNotFoundException::class
            ],
            'City as City::class instance, mocked' => [
                'city' => $city,
                'exception' => null
            ]
        ];
    }

    /**
     * Test find by zip
     *
     * @dataProvider cityProvider
     *
     * @param City|null $city
     * @param string|null $exception
     */
    public function testFindWithCity(?City $city, ?string $exception): void
    {
        /** @var EntityRepository|PHPUnit_Framework_MockObject_MockObject $entityRepository */
        $entityRepository = $this->createMock(EntityRepository::class);
        $entityRepository
            ->expects(self::once())
            ->method('find')
            ->with(self::TEST_ZIP)
            ->willReturn($city);
        $this->entityManager
            ->expects(self::once())
            ->method('getRepository')
            ->willReturn($entityRepository);

        if (null !== $exception) {
            self::expectException($exception);
        }

        $cityRepository = new CityRepository($this->entityManager);
        $result = $cityRepository->find(self::TEST_ZIP);

        self::assertEquals($city, $result);
    }

    /**
     * Test find all
     *
     * @dataProvider cityProvider
     *
     * @param City|null $city
     */
    public function testFindAll(?City $city): void
    {
        $willReturn = null === $city ? [] : [$city];

        /** @var EntityRepository|PHPUnit_Framework_MockObject_MockObject $entityRepository */
        $entityRepository = $this->createMock(EntityRepository::class);
        $entityRepository
            ->expects(self::once())
            ->method('findAll')
            ->willReturn($willReturn);
        $this->entityManager
            ->expects(self::once())
            ->method('getRepository')
            ->willReturn($entityRepository);

        $cityRepository = new CityRepository($this->entityManager);
        $result = $cityRepository->findAll();

        self::assertInstanceOf(ArrayCollection::class, $result);
        self::assertEquals(count($willReturn), $result->count());
    }
}
