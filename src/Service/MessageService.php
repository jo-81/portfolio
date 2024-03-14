<?php

namespace App\Service;

use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;

final class MessageService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function read(Message $message): void
    {
        $message
            ->setReaded(true)
            ->setReadedAt(new \DateTimeImmutable())
        ;

        $this->em->flush();
    }
}
