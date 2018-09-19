<?php

namespace MyHammer\Api\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestTransformerSubscriber
 * @package MyHammer\Api\EventSubscriber
 */
class RequestTransformerSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelRequest'
        ];
    }

    /**
     * @param FilterControllerEvent $filterControllerEvent
     */
    public function onKernelRequest(FilterControllerEvent $filterControllerEvent): void
    {
        $request = $filterControllerEvent->getRequest();
        if ('json' !== $request->getContentType() || !$request->getContent()) {
            return;
        }

        $data = json_decode($request->getContent(), true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException(
                sprintf('Invalid JSON body: %s', json_last_error_msg())
            );
        }
        $request->request->replace(is_array($data) ? $data : []);
    }
}
