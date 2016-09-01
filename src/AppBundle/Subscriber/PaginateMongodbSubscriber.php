<?php
/**
 * Created by PhpStorm.
 * Date: 01.09.2016
 *
 * @author Kamil Bednarek <kb@protonmail.ch>
 */
namespace AppBundle\Subscriber;

use AppBundle\Query\MongoDBQuery;
use AppBundle\Service\MongoDBService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Knp\Component\Pager\Event\ItemsEvent;

class PaginateMongodbSubscriber implements EventSubscriberInterface
{
    /**
     * @var MongoDBService
     */
    private $mongoDBService;

    public function __construct(MongoDBService $mongoDBService)
    {
        $this->mongoDBService = $mongoDBService;
    }

    public function items(ItemsEvent $event)
    {
        $offset = $event->getOffset();
        $limit = $event->getLimit();
        /** @var MongoDBQuery $target */
        $target = $event->target;

        // Counting results
        $event->count = $this->mongoDBService->getCollection($target->getCollection())->count($target->getQuery());
        $event->items = $this->mongoDBService->getCollection($target->getCollection())->find($target->getQuery(), [
            'skip' => $offset,
            'limit' => $limit,
            'sort' => $target->getSort()
        ])->toArray();

        $event->stopPropagation();
    }

    public static function getSubscribedEvents()
    {
        return array(
            'knp_pager.items' => array('items', 1/*increased priority to override any internal*/)
        );
    }
}