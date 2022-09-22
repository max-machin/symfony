<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use Doctrine\Common\EventSubscriber;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSubscriber implements EventSubscriberInterface {

    public static function getSubscribedEvents(){
        return [
            BeforeEntityPersistedEvent::class => ['setEntityCreatedAt']
        ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event){
        $entity = $event->getEntityInstance();

        if (!$entity instanceof TimestampedInterface){
            return;
        }

        $entity->setCreatedAt(new \DateTime());
    }
}


?>