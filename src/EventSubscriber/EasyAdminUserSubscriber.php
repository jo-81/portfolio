<?php

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminUserSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityUpdatedEvent::class => ['editUser'],
        ];
    }

    public function editUser(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        if ($entity instanceof User && null != $entity->getPlainPassword()) {
            $newPassword = $this->hasher->hashPassword($entity, $entity->getPlainPassword());
            $entity->setPassword($newPassword);
        }
    }
}
