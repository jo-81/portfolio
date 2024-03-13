<?php

namespace App\Controller\Admin\Filter;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\FilterDataDto;
use EasyCorp\Bundle\EasyAdminBundle\Filter\FilterTrait;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Filter\FilterInterface;

class MessageReadFilter implements FilterInterface
{
    use FilterTrait;

    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setFilterFqcn(__CLASS__)
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(CheckboxType::class)
        ;
    }

    public function apply(
        QueryBuilder $queryBuilder, 
        FilterDataDto $filterDataDto, 
        ?FieldDto $fieldDto, 
        EntityDto $entityDto
    ): void
    {
        dd($queryBuilder, $filterDataDto, $fieldDto, $entityDto);

        // if ('today' === $filterDataDto->getValue()) {
        //     $queryBuilder->andWhere(sprintf('%s.%s = :today', $filterDataDto->getEntityAlias(), $filterDataDto->getProperty()))
        //         ->setParameter('today', (new \DateTime('today'))->format('Y-m-d'));
        // }
    }
}