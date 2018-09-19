<?php

namespace MyHammer\Api\Controller;

use MyHammer\Api\Service\CityServiceInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class CityController
 * @package MyHammer\Api\Controller
 */
class CityController extends AbstractController
{
    /** @var CityServiceInterface */
    private $cityService;

    /** @var SerializerInterface */
    private $serializer;

    /**
     * JobController constructor.
     * @param CityServiceInterface $cityService
     * @param SerializerInterface $serializer
     */
    public function __construct(CityServiceInterface $cityService, SerializerInterface $serializer)
    {
        $this->cityService = $cityService;
        $this->serializer = $serializer;
    }

    /**
     * @return JsonResponse
     *
     * @Route("/city", name="city_list", methods={"GET"})
     *
     * @SWG\Get(
     *     path="/city",
     *     tags={"city"},
     *     description="Get all cities",
     *     responses={
     *          @SWG\Response(
     *              response=200,
     *              description="List of cities",
     *              @Model(type=MyHammer\Api\Entity\City::class)
     *          )
     *      }
     * )
     */
    public function all(): JsonResponse
    {
        $services = $this->cityService->findAll();

        return new JsonResponse(
            $this->serializer->serialize($services, 'json'),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
