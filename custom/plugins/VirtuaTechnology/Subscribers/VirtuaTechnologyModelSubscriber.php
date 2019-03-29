<?php

namespace VirtuaTechnology\Subscribers;

use Doctrine\Common\EventSubscriber;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use VirtuaTechnology\Models\VirtuaTechnology;

class VirtuaTechnologyModelSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $modelManager = $args->getEntityManager();

        $model = $args->getEntity();
        if ($model instanceof VirtuaTechnology) {
            $model->setUrl(
                urlencode($model->getName())
            );
        }
    }
}