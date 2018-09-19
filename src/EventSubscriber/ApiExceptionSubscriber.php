<?php

namespace MyHammer\Api\EventSubscriber;

use MyHammer\Api\Exception\AbstractApiException;
use MyHammer\Api\Service\ExceptionTransformerServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ApiExceptionSubscriber
 * @package MyHammer\Api\EventSubscriber
 */
class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /** @var ExceptionTransformerServiceInterface */
    private $exceptionTransformerService;

    /**
     * ApiExceptionSubscriber constructor.
     * @param ExceptionTransformerServiceInterface $exceptionTransformerService
     */
    public function __construct(ExceptionTransformerServiceInterface $exceptionTransformerService)
    {
        $this->exceptionTransformerService = $exceptionTransformerService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                [
                    'onKernelException',
                    10,
                ],
            ],
        ];
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $exception = $event->getException();
        if ($exception instanceof AbstractApiException) {
            $exceptionClass = $this->exceptionTransformerService->transform(get_class($exception));

            $event->setException(new $exceptionClass($exception->getMessage(), $exception));
        }
    }
}
