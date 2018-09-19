<?php

namespace MyHammer\Api\Service;

use MyHammer\Api\Entity\Job;
use MyHammer\Api\Exception\ConstraintViolationException;
use MyHammer\Api\Repository\JobRepositoryInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class JobService
 * @package MyHammer\Api\Service
 */
class JobService implements JobServiceInterface
{
    /** @var JobRepositoryInterface */
    private $jobRepository;

    /** @var ValidatorInterface */
    private $validator;

    /**
     * JobService constructor.
     * @param JobRepositoryInterface $jobRepository
     * @param ValidatorInterface $validator
     */
    public function __construct(JobRepositoryInterface $jobRepository, ValidatorInterface $validator)
    {
        $this->jobRepository = $jobRepository;
        $this->validator = $validator;
    }

    /**
     * {@inheritdoc}
     */
    public function create(Job $job): void
    {
        /** @var ConstraintViolationListInterface $constraints */
        $constraints = $this->validator->validate($job);
        if (0 !== $constraints->count()) {
            $constraintViolationException = new ConstraintViolationException();
            $constraintViolationException->setConstraintViolationList($constraints);

            throw $constraintViolationException;
        }

        $this->jobRepository->save($job);
    }
}
