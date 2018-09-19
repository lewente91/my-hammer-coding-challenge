<?php

namespace MyHammer\Api\Controller;

use MyHammer\Api\Entity\Job;
use MyHammer\Api\Service\JobServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
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
     *
     * @SWG\Post(
     *     path="/job",
     *     tags={"job"},
     *     consumes={"application/json"},
     *     description="Create a new job with the given parameters",
     *     parameters={
     *          @SWG\Parameter(
     *              name="job",
     *              in="body",
     *              required=true,
     *              @SWG\Schema(
     *                  type="object",
     *                  @SWG\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Job title"
     *                  ),
     *                  @SWG\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Job description, >= 5 and <= 50 characters"
     *                  ),
     *                  @SWG\Property(
     *                      property="zip",
     *                      type="string",
     *                      description="ZipCode of the city where the job is taking place @see GET /cities"
     *                  ),
     *                  @SWG\Property(
     *                      property="schedule",
     *                      type="string",
     *                      description="Schedule type @see GET /schedule"
     *                  ),
     *                  @SWG\Property(
     *                      property="service",
     *                      type="integer",
     *                      description="ID of the service the job will belong to @see GET /service"
     *                  )
     *              )
     *          )
     *     },
     *     responses={
     *          @SWG\Response(
     *              response=201,
     *              description="Job was successfully created",
     *              @SWG\Schema(
     *                  type="object",
     *                  @SWG\Property(
     *                      property="id",
     *                      type="integer",
     *                      description="Job ID"
     *                  ),
     *                  @SWG\Property(
     *                      property="title",
     *                      type="string",
     *                      description="Job title"
     *                  ),
     *                  @SWG\Property(
     *                      property="description",
     *                      type="string",
     *                      description="Job description, >= 5 and <= 50 characters"
     *                  ),
     *                  @SWG\Property(
     *                      property="zip",
     *                      type="string",
     *                      description="ZipCode of the city where the job is taking place @see GET /cities"
     *                  ),
     *                  @SWG\Property(
     *                      property="schedule",
     *                      type="string",
     *                      description="Schedule type @see GET /schedule"
     *                  ),
     *                  @SWG\Property(
     *                      property="service",
     *                      type="integer",
     *                      description="ID of the service the job will belong to @see GET /service"
     *                  )
     *              )
     *          )
     *      }
     * )
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
