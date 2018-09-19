<?php

namespace MyHammer\Api\Controller;

use MyHammer\Api\Service\ScheduleServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ScheduleController
 * @package MyHammer\Api\Controller
 */
class ScheduleController extends AbstractController
{
    /** @var ScheduleServiceInterface */
    private $scheduleService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * ScheduleController constructor.
     * @param ScheduleServiceInterface $scheduleService
     * @param SerializerInterface $serializer
     */
    public function __construct(ScheduleServiceInterface $scheduleService, SerializerInterface $serializer)
    {
        $this->scheduleService = $scheduleService;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/schedule", name="schedule_list", methods={"GET"})
     */
    public function all(): JsonResponse
    {
        $schedules = $this->scheduleService->findAll();

        return new JsonResponse(
            $this->serializer->serialize($schedules, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
