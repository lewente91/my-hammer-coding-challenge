<?php

namespace MyHammer\Api\Serializer;

use MyHammer\Api\Entity\Job;
use MyHammer\Api\Entity\User;
use MyHammer\Api\Service\CityServiceInterface;
use MyHammer\Api\Service\ScheduleServiceInterface;
use MyHammer\Api\Service\ServiceServiceInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class JobSerializer
 * @package MyHammer\Api\Serializer
 */
class JobSerializer implements NormalizerInterface, DenormalizerInterface
{

    /** @var ServiceServiceInterface */
    private $serviceService;

    /** @var CityServiceInterface */
    private $cityService;

    /** @var ScheduleServiceInterface */
    private $scheduleService;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * JobSerializer constructor.
     * @param ServiceServiceInterface $serviceService
     * @param CityServiceInterface $cityService
     * @param ScheduleServiceInterface $scheduleService
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        ServiceServiceInterface $serviceService,
        CityServiceInterface $cityService,
        ScheduleServiceInterface $scheduleService,
        TokenStorageInterface $tokenStorage
    ) {
        $this->serviceService = $serviceService;
        $this->cityService = $cityService;
        $this->scheduleService = $scheduleService;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, $class, $format = null, array $context = []): Job
    {
        $service = null;
        $schedule = null;
        $city = null;
        $job = new Job();

        if (array_key_exists('object_to_populate', $context) && $context['object_to_populate'] instanceof Job) {
            $job = $context['object_to_populate'];
        }

        if (array_key_exists('service', $data)) {
            $service = $this->serviceService->find($data['service']);
        }

        if (array_key_exists('schedule', $data)) {
            $schedule = $this->scheduleService->find($data['schedule']);
        }

        if (array_key_exists('zip', $data)) {
            $city = $this->cityService->find($data['zip']);
        }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $job->setTitle($data['title'] ?? null);
        $job->setDescription($data['description'] ?? null);
        $job->setService($service);
        $job->setCity($city);
        $job->setSchedule($schedule);
        $job->setCreatedBy($user);

        return $job;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $type === Job::class;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        return [
            'id' => $object->getId(),
            'title' => $object->getTitle(),
            'description' => $object->getDescription(),
            'zip' => $object->getCity()->getZip(),
            'city' => $object->getCity()->getName(),
            'schedule' => $object->getSchedule(),
            'service' => $object->getService()->getId()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $data instanceof Job;
    }
}
