<?php

namespace App\EventSubscriber\Knp;

use Doctrine\DBAL\Query\QueryBuilder;
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

    /**
     * $paginator->paginate($target, int $page = 1, int $limit = null, array $options = [])
     * $event->options = $options.
     */
    public function items(ItemsEvent $event) : void
    {
        if ($event->target instanceof QueryBuilder && array_key_exists('disable_total_count', $event->options)) {
            $target = $event->target;
            $qb = clone $target;
            $qb->setFirstResult($event->getOffset())
                ->setMaxResults($event->getLimit())
            ;
            $event->items = $qb->execute()->fetchAll();

            $event->stopPropagation();
        }

        if ($event->target instanceof OrmQueryBuilder && array_key_exists('disable_total_count', $event->options)) {
            $target = $event->target;
            $qb = clone $target;

            $event->items = $qb->getQuery()->getResult();

            $event->stopPropagation();
        }
    }
}
