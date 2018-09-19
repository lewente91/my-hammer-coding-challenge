<?php

namespace MyHammer\Api\Controller;

use MyHammer\Api\Entity\Job;
use MyHammer\Api\Service\JobServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JobController
 * @package MyHammer\Api\Controller
 */
class JobController extends AbstractController
{
    /** @var JobServiceInterface */
    private $jobService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * JobController constructor.
     * @param JobServiceInterface $jobService
     * @param SerializerInterface $serializer
     */
    public function __construct(JobServiceInterface $jobService, SerializerInterface $serializer)
    {
        $this->jobService = $jobService;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @Route("/job", name="job_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        /** @var Job $job */
        $job = $this->serializer->deserialize($request->getContent(), Job::class, 'json');
        $this->jobService->create($job);

        return new JsonResponse(
            $this->serializer->serialize($job, 'json'),
            Response::HTTP_CREATED,
            [],
            true
        );
    }
}
