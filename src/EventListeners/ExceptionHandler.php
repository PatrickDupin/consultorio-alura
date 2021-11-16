<?php

namespace App\EventListeners;

use App\Helper\ResponseFactory;
use App\Helper\EntityFactoryException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionHandler implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['handlerEntityException', 2],
                ['handlerAuthenticationException', 1],
                ['handle404Exception', 0]
            ]
        ];
    }

    public function handlerEntityException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof EntityFactoryException) {
            $fabricaResposta = new ResponseFactory(
                false,
                $event->getThrowable()->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
            $event->setResponse($fabricaResposta->getResponse());
        }
    }

    public function handlerAuthenticationException(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof AuthenticationException) {
            $fabricaResposta = new ResponseFactory(
                false,
                $event->getThrowable()->getMessage(),
                Response::HTTP_UNAUTHORIZED
            );
            $event->setResponse($fabricaResposta->getResponse());
        }
    }

    public function handle404Exception(ExceptionEvent $event)
    {
        if ($event->getThrowable() instanceof NotFoundHttpException) {
            $fabricaResposta = new ResponseFactory(
                false,
                $event->getThrowable()->getMessage(),
                Response::HTTP_NOT_FOUND
            );
            $event->setResponse($fabricaResposta->getResponse());
        }
    }
}