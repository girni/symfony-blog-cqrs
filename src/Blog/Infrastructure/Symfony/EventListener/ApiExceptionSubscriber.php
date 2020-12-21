<?php

namespace App\Blog\Infrastructure\Symfony\EventListener;

use App\Blog\Infrastructure\ApiException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException'
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof ApiException) {
            return;
        }

        $data = [
            'status'  => $exception->getStatusCode(),
            'message' => $exception->getMessage()
        ];

        $response = new JsonResponse(
            $data,
            $exception->getStatusCode()
        );
        $response->headers->set('Content-Type', 'application/json');

        $event->setResponse($response);
    }
}