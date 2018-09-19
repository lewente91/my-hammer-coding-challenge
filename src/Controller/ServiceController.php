<?php

namespace MyHammer\Api\Controller;

use MyHammer\Api\Service\ServiceServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class ServiceController
 * @package MyHammer\Api\Controller
 */
class ServiceController extends AbstractController
{
    /** @var ServiceServiceInterface */
    private $serviceService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * JobController constructor.
     * @param ServiceServiceInterface $serviceService
     * @param SerializerInterface $serializer
     */
    public function __construct(ServiceServiceInterface $serviceService, SerializerInterface $serializer)
    {
        $this->serviceService = $serviceService;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/service", name="service_list", methods={"GET"})
     *
     * @SWG\Get(
     *     path="/service",
     *     tags={"service"},
     *     description="Get all services",
     *     responses={
     *          @SWG\Response(
     *              response=200,
     *              description="List of services",
     *              @Model(type=MyHammer\Api\Entity\Service::class)
     *          )
     *      }
     * )
     */
    public function all(): JsonResponse
    {
        $services = $this->serviceService->findAll();

        return new JsonResponse(
            $this->serializer->serialize($services, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
