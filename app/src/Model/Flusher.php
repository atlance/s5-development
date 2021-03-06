<?php

declare(strict_types=1);

namespace App\Model;

use App\Event\Dispatcher\EventDispatcher;
use Doctrine\ORM\EntityManagerInterface;

class Flusher
{
    private EntityManagerInterface $em;
    private EventDispatcher $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcher $dispatcher)
    {
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    public function flush(AggregateRoot ...$roots) : void
    {
        $this->em->flush();

        foreach ($roots as $root) {
            $this->dispatcher->dispatch($root->releaseEvents());
        }
    }
}
