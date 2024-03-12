<?php

namespace App\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class Entity extends KernelTestCase
{
    protected function assertHasErrors(object $entity, int $number = 0): void
    {
        /** @var ContainerInterface $container */
        $container = self::getContainer();

        /** @var ValidatorInterface $validator */
        $validator = $container->get('validator');

        $error = $validator->validate($entity);
        $this->assertCount($number, $error);
    }
}
