<?php

declare(strict_types=1);

namespace App\Event\Subscriber\Kernel\Request;

use App\Utils\Http\Factory\SubDomainFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class SubDomainSubscriber implements EventSubscriberInterface
{
    private SubDomainFactory $factory;

    public function __construct(SubDomainFactory $factory)
    {
        $this->factory = $factory;
    }

    public function setSubDomain(RequestEvent $event) : void
    {
        $request = $event->getRequest();

        if (!$request->attributes->has('subDomain')) {
            return;
        }

        try {
            $subDomain = $this->factory->createFromRequest($request);
            $attributes = array_merge($request->attributes->all(), compact('subDomain'));
            $request->attributes->replace($attributes);
        } catch (\Throwable $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }
    }

    public static function getSubscribedEvents() : array
    {
        return [
            KernelEvents::REQUEST => [
                ['setSubDomain', -255],
            ],
        ];
    }
}
