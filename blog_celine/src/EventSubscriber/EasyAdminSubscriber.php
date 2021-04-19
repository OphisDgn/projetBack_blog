<?php 

namespace App\EventSubscriber;

use App\Entity\Article;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Security;


class EasyAdminSubscriber implements EventSubscriberInterface {

    private $security;

    public function __construct(Security $security) {
        $this->security = $security;
    }

    public static function getSubscribedEvents() {
        return [
            BeforeEntityPersistedEvent::class => ['setArticleDateAndUser'],
        ];
    }

    public function setArticleDateAndUser(BeforeEntityPersistedEvent $event) {
        $entity = $event->getEntityInstance();
        if (($entity instanceof Article)) {
            $now = new DateTime('now');
            $entity->setPublishAt($now);

            $user = $this->security->getUser();
            $entity->setAuthor($user);
        } else {
            return;
        }
    }
}