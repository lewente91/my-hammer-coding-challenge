<?php

namespace MyHammer\Api\Tests\Service;

use Doctrine\Common\Collections\ArrayCollection;
use MyHammer\Api\Entity\City;
use MyHammer\Api\Repository\CityRepository;
use MyHammer\Api\Repository\CityRepositoryInterface;
use MyHammer\Api\Service\CityService;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class CityServiceTest
 * @package MyHammer\Api\Tests\Service
 */
class CityServiceTest extends TestCase
{
    const TEST_ZIP = 'TEST-ZIP-12345';

    /** @var CityRepository|PHPUnit_Framework_MockObject_MockObject */
    private $cityRepository;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->cityRepository = $this->createMock(CityRepositoryInterface::class);
    }

    /**
     * Test instance
     */
    public function testInstance(): void
    {
        $cityService = new CityService($this->cityRepository);

        self::assertInstanceOf(CityService::class, $cityService);
    }

    /**
     * Test find
     */
    public function testFind(): void
    {
        /** @var City|PHPUnit_Framework_MockObject_MockObject $city */
        $city = $this->createMock(City::class);
        $this->cityRepository
            ->expects(self::once())
            ->method('find')
            ->with(self::TEST_ZIP)
            ->willReturn($city);

        $cityService = new CityService($this->cityRepository);
        $result = $cityService->find(self::TEST_ZIP);

        self::assertEquals($city, $result);
    }

    /**
     * Test find all
     */
    public function testFindAll(): void
    {
        /** @var ArrayCollection|PHPUnit_Framework_MockObject_MockObject $cities */
        $cities = $this->createMock(ArrayCollection::class);
        $this->cityRepository
            ->expects(self::once())
            ->method('findAll')
            ->willReturn($cities);

        $cityService = new CityService($this->cityRepository);
        $result = $cityService->findAll();

        self::assertEquals($cities, $result);
    }
}
