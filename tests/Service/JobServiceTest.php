<?php

namespace MyHammer\Api\Tests\Service;

use MyHammer\Api\Entity\Job;
use MyHammer\Api\Exception\ConstraintViolationException;
use MyHammer\Api\Repository\JobRepositoryInterface;
use MyHammer\Api\Service\JobService;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class JobServiceTest
 * @package MyHammer\Api\Tests\Service
 */
class JobServiceTest extends TestCase
{
    /** @var JobRepositoryInterface|PHPUnit_Framework_MockObject_MockObject */
    private $jobRepository;

    /** @var ValidatorInterface|PHPUnit_Framework_MockObject_MockObject */
    private $validator;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->jobRepository = $this->createMock(JobRepositoryInterface::class);
        $this->validator = $this->createMock(ValidatorInterface::class);
    }

    /**
     * Test instance
     */
    public function testInstance(): void
    {
        $jobService = new JobService($this->jobRepository, $this->validator);

        self::assertInstanceOf(JobService::class, $jobService);
    }

    /**
     * @return array
     */
    public function jobProvider(): array
    {
        /** @var Job|PHPUnit_Framework_MockObject_MockObject $job */
        $job = $this->createMock(Job::class);

        return [
            'Without constraint violations' => [
                'job' => $job,
                'violationCount' => 0
            ],

            'With constraint violations' => [
                'job' => $job,
                'violationCount' => 1
            ]
        ];
    }

    /**
     * Test create
     *
     * @dataProvider jobProvider
     *
     * @param Job $job
     * @param int $violationsCount
     */
    public function testCreate(Job $job, int $violationsCount): void
    {
        /** @var ConstraintViolationListInterface|PHPUnit_Framework_MockObject_MockObject $constraints */
        $constraints = $this->createMock(ConstraintViolationListInterface::class);
        $constraints
            ->expects(self::once())
            ->method('count')
            ->willReturn($violationsCount);
        $this->validator
            ->expects(self::once())
            ->method('validate')
            ->willReturn($constraints);

        if (0 !== $violationsCount) {
            self::expectException(ConstraintViolationException::class);
        } else {
            $this->jobRepository
                ->expects(self::once())
                ->method('save');
        }

        $jobService = new JobService($this->jobRepository, $this->validator);
        $jobService->create($job);
    }
}
