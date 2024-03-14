<?php

namespace App\EventSubscriber;

use App\Controller\Admin\MessageCrudController;
use App\Entity\Message;
use App\Service\MessageService;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class EasyAdminReadMessageSubscriber implements EventSubscriberInterface
{
    public function __construct(private MessageService $messageService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeCrudActionEvent::class => ['readMessage'],
        ];
    }

    public function readMessage(BeforeCrudActionEvent $event): void
    {
        $context = $event->getAdminContext();
        if (is_null($context)) {
            return;
        }

        $crud = $context->getCrud();
        if (is_null($crud)) {
            return;
        }

        $controller = $crud->getControllerFqcn();
        $pageName = $crud->getCurrentPage();
        $message = $context->getEntity()->getInstance();

        if (!$message instanceof Message) {
            return;
        }

        if ($message->isReaded()) {
            return;
        }

        if (MessageCrudController::class == $controller && 'detail' == $pageName) {
            $this->messageService->read($message);
        }
    }
}
