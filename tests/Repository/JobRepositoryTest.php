<?php

namespace MyHammer\Api\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use MyHammer\Api\Entity\Job;
use MyHammer\Api\Repository\JobRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

/**
 * Class JobRepositoryTest
 * @package MyHammer\Api\Tests\Repository
 */
class JobRepositoryTest extends TestCase
{
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
        $jobRepository = new JobRepository($this->entityManager);

        self::assertInstanceOf(JobRepository::class, $jobRepository);
    }

    /**
     * Test save
     */
    public function testSave(): void
    {
        /** @var Job|PHPUnit_Framework_MockObject_MockObject $job */
        $job = $this->createMock(Job::class);
        /** @var EntityRepository|PHPUnit_Framework_MockObject_MockObject $entityRepository */
        $entityRepository = $this->createMock(EntityRepository::class);
        $this->entityManager
            ->expects(self::once())
            ->method('getRepository')
            ->willReturn($entityRepository);
        $this->entityManager
            ->expects(self::once())
            ->method('persist')
            ->with($job);
        $this->entityManager
            ->expects(self::once())
            ->method('flush');

        $jobRepository = new JobRepository($this->entityManager);
        $jobRepository->save($job);
    }
}
