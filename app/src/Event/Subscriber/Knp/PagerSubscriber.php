<?php

declare(strict_types=1);

namespace App\Event\Subscriber\Knp;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\QueryBuilder as OrmQueryBuilder;
use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Служит для удаления total count запроса в пагинаторе.
 * При больших объемах данных в БД, запрос total count съедает много времени.
 */
class PagerSubscriber implements EventSubscriberInterface
{
    /**
     * $paginator->paginate($target, int $page = 1, int $limit = null, array $options = [])
     * $event->options = $options.
     */
    public function items(ItemsEvent $event) : void
    {
        if ($event->target instanceof QueryBuilder && \array_key_exists('disable_total_count', $event->options)) {
            $target = $event->target;
            $qb = clone $target;
            $stmt = $qb->setFirstResult($event->getOffset())
                ->setMaxResults($event->getLimit())
                ->execute()
            ;

            if ($stmt instanceof ResultSetMapping) {
                $event->items = $stmt->fetchAll();
                $event->stopPropagation();
            }

            throw new \DomainException('this method works only with the select operator');
        }

        if ($event->target instanceof OrmQueryBuilder && \array_key_exists('disable_total_count', $event->options)) {
            $target = $event->target;
            $qb = clone $target;

            $event->items = $qb->getQuery()->getResult();

            $event->stopPropagation();
        }
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents() : array
    {
        return [
            'knp_pager.items' => [
                'items',
                255,
            ],
        ];
    }
}
