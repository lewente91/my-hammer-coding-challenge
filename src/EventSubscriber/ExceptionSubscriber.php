<?php

namespace MyHammer\Api\EventSubscriber;

use MyHammer\Api\Exception\ConstraintViolationException;
use MyHammer\Api\Exception\ErrorCodeInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ExceptionSubscriber
 * @package MyHammer\Api\EventSubscriber
 */
class ExceptionSubscriber implements EventSubscriberInterface
{
    /** @var string */
    private $environment;

    /**
     * ExceptionSubscriber constructor.
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
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
                    0,
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
        $previous = $exception->getPrevious();
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        $responseBody = [
            'errorCode' => $this->getErrorCode(Response::HTTP_INTERNAL_SERVER_ERROR),
            'message' => $exception->getMessage(),
        ];
        if ($exception instanceof HttpExceptionInterface) {
            $statusCode = $exception->getStatusCode();
            $responseBody['errorCode'] = $this->getErrorCode($exception->getStatusCode());
            $responseBody['message'] = $exception->getMessage();
            if ($previous instanceof ErrorCodeInterface) {
                $responseBody['errorCode'] = $previous->getErrorCode();
                $responseBody['message'] = $previous->getMessage();

                if ($previous instanceof ConstraintViolationException) {
                    $responseBody['message'] = $previous->getMessages();
                }
            }
        }

        if ('dev' === $this->environment) {
            $responseBody['trace'] = $exception->getTrace();
        }

        $response = new JsonResponse($responseBody, Response::HTTP_OK, [], false);
        $response->setStatusCode($statusCode);
        $event->setResponse($response);
    }

    /**
     * @param int $statusCode
     * @return string
     */
    private function getErrorCode(int $statusCode): string
    {
        return strtoupper(
            str_replace(' ', '_', Response::$statusTexts[$statusCode])
        );
    }
}
